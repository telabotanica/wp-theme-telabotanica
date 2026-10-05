<?php
/**
 * Mon compte sans BuddyPress.
 *
 * Fournit : URL compte, shortcode [tb_mon_compte], traitement des 4 sections
 * (pseudo affiché, email avec vérification, mot de passe avec confirmation,
 * suppression avec réassignation).
 *
 * @package telabotanica
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

global $tb_account_notices;
$tb_account_notices = [
  'errors'  => [],
  'success' => [],
  'info'    => [],
];

/**
 * URL de la page Mon compte (template-mon-compte.php ou slug mon-compte).
 * Résultat mémorisé par requête pour éviter get_pages répété.
 *
 * @return string
 */
function tb_account_url() {
  static $cached = null;
  if ( null !== $cached ) {
    return $cached;
  }

  $pages = get_pages( [
    'meta_key'   => '_wp_page_template',
    'meta_value' => 'template-mon-compte.php',
    'number'     => 1,
  ] );

  if ( ! empty( $pages ) ) {
    $url = get_permalink( $pages[0]->ID );
    if ( $url ) {
      $cached = $url;
      return $cached;
    }
  }

  $by_path = get_page_by_path( 'mon-compte' );
  if ( $by_path ) {
    $url = get_permalink( $by_path->ID );
    if ( $url ) {
      $cached = $url;
      return $cached;
    }
  }

  $cached = home_url( '/mon-compte/' );
  return $cached;
}

/**
 * Avatar : BuddyPress si présent, sinon Gravatar WP.
 *
 * @param int $user_id
 * @return string URL
 */
function tb_account_avatar_url( $user_id ) {
  $user_id = (int) $user_id;
  if ( $user_id <= 0 ) {
    return '';
  }
  if ( function_exists( 'tb_bp_avatar' ) ) {
    $bp = tb_bp_avatar( $user_id );
    if ( is_string( $bp ) && '' !== $bp ) {
      return $bp;
    }
  }
  $url = get_avatar_url( $user_id, [ 'size' => 96 ] );
  return is_string( $url ) ? $url : '';
}

/**
 * Ajoute une notice.
 *
 * @param string $type errors|success|info
 * @param string $message Message déjà traduit.
 */
function tb_account_add_notice( $type, $message ) {
  global $tb_account_notices;
  if ( ! isset( $tb_account_notices[ $type ] ) ) {
    $type = 'info';
  }
  $tb_account_notices[ $type ][] = $message;
}

/**
 * Récupère et vide les notices.
 *
 * @return array
 */
function tb_account_pull_notices() {
  global $tb_account_notices;
  $notices = $tb_account_notices;
  $tb_account_notices = [ 'errors' => [], 'success' => [], 'info' => [] ];
  return $notices;
}

/**
 * Utilisateur Ex-telabotaniste pour réassignation (créé si absent).
 *
 * @return int|WP_Error ID ou erreur.
 */
function tb_account_get_deleted_reassign_id() {
  if ( ! get_role( 'deleted_tb_user' ) ) {
    add_role( 'deleted_tb_user', __( 'Ex-telabotaniste', 'telabotanica' ), [ 'read' => false ] );
  }

  $existing = get_user_by( 'login', 'ex-telabotaniste' );
  if ( $existing instanceof WP_User ) {
    return (int) $existing->ID;
  }

  $id = wp_insert_user( [
    'user_login'   => 'ex-telabotaniste',
    'user_pass'    => wp_generate_password( 32, true, true ),
    'user_email'   => 'ex-telabotaniste@' . wp_parse_url( home_url(), PHP_URL_HOST ),
    'display_name' => __( 'Ex-telabotaniste', 'telabotanica' ),
    'role'         => 'deleted_tb_user',
  ] );

  if ( is_wp_error( $id ) ) {
    return $id;
  }

  return (int) $id;
}

/**
 * Confirmation d'email en attente pour l'utilisateur.
 *
 * @param int $user_id
 * @return array|null ['newemail' => string] ou null.
 */
function tb_account_pending_email( $user_id ) {
  $pending = get_user_meta( (int) $user_id, '_new_tb_email', true );
  if ( ! is_array( $pending ) || empty( $pending['newemail'] ) || empty( $pending['hash'] ) ) {
    return null;
  }
  if ( ! empty( $pending['expires'] ) && (int) $pending['expires'] < time() ) {
    delete_user_meta( (int) $user_id, '_new_tb_email' );
    return null;
  }
  return $pending;
}

/**
 * Traitement GET (confirmation email) + POST (4 formulaires).
 * Hooké sur template_redirect : headers encore disponibles pour redirects.
 */
function tb_account_handle_requests() {
  if ( is_admin() ) {
    return;
  }

  // 1. Confirmation d'email via lien.
  if ( ! empty( $_GET['tb_confirm_email'] ) ) {
    if ( ! is_user_logged_in() ) {
      // Redirige vers le login puis retour avec le hash intact.
      $current = add_query_arg( 'tb_confirm_email', sanitize_text_field( wp_unslash( $_GET['tb_confirm_email'] ) ), tb_account_url() );
      wp_safe_redirect( wp_login_url( $current ) );
      exit;
    }

    $hash = sanitize_text_field( wp_unslash( $_GET['tb_confirm_email'] ) );
    $user = wp_get_current_user();

    if ( ! $user instanceof WP_User || ! $user->exists() ) {
      return;
    }

    $pending = tb_account_pending_email( $user->ID );

    if ( ! $pending || ! hash_equals( (string) $pending['hash'], $hash ) ) {
      tb_account_add_notice( 'errors', __( 'Lien de confirmation invalide ou expiré.', 'telabotanica' ) );
      return;
    }

    $new_email = sanitize_email( $pending['newemail'] );

    if ( ! is_email( $new_email ) ) {
      delete_user_meta( $user->ID, '_new_tb_email' );
      tb_account_add_notice( 'errors', __( 'Adresse en attente invalide.', 'telabotanica' ) );
      return;
    }

    $owner = get_user_by( 'email', $new_email );
    if ( $owner instanceof WP_User && (int) $owner->ID !== (int) $user->ID ) {
      delete_user_meta( $user->ID, '_new_tb_email' );
      tb_account_add_notice( 'errors', __( 'Cette adresse est déjà utilisée.', 'telabotanica' ) );
      return;
    }

    $updated = wp_update_user( [
      'ID'         => $user->ID,
      'user_email' => $new_email,
    ] );

    if ( is_wp_error( $updated ) ) {
      tb_account_add_notice( 'errors', $updated->get_error_message() );
      return;
    }

    delete_user_meta( $user->ID, '_new_tb_email' );
    wp_safe_redirect( add_query_arg( 'tb_notice', 'email-confirmed', tb_account_url() ) );
    exit;
  }

  // 2. Formulaires POST.
  if ( empty( $_POST['tb_account_action'] ) || ! is_user_logged_in() ) {
    return;
  }

  $user = wp_get_current_user();
  if ( ! $user instanceof WP_User || ! $user->exists() ) {
    return;
  }

  $action = sanitize_key( wp_unslash( $_POST['tb_account_action'] ) );

  switch ( $action ) {
    case 'profile':
      tb_account_handle_profile( $user );
      break;
    case 'email':
      tb_account_handle_email( $user );
      break;
    case 'password':
      tb_account_handle_password( $user );
      break;
    case 'delete':
      tb_account_handle_delete( $user );
      break;
    default:
      break;
  }
}
add_action( 'template_redirect', 'tb_account_handle_requests' );

/**
 * Section 1 : pseudo affiché (display_name + nickname).
 *
 * @param WP_User $user
 */
function tb_account_handle_profile( WP_User $user ) {
  if ( ! isset( $_POST['tb_account_profile_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tb_account_profile_nonce'] ) ), 'tb_account_profile' ) ) {
    tb_account_add_notice( 'errors', __( 'Session expirée, veuillez réessayer.', 'telabotanica' ) );
    return;
  }

  $display = isset( $_POST['tb_display_name'] ) ? sanitize_text_field( wp_unslash( $_POST['tb_display_name'] ) ) : '';
  $display = trim( preg_replace( '/\s+/', ' ', $display ) );

  if ( '' === $display ) {
    tb_account_add_notice( 'errors', __( 'Le pseudo ne peut pas être vide.', 'telabotanica' ) );
    return;
  }

  if ( mb_strlen( $display ) > 50 ) {
    tb_account_add_notice( 'errors', __( 'Le pseudo doit faire 50 caractères maximum.', 'telabotanica' ) );
    return;
  }

  $updated = wp_update_user( [
    'ID'           => $user->ID,
    'display_name' => $display,
    'nickname'     => $display,
  ] );

  if ( is_wp_error( $updated ) ) {
    tb_account_add_notice( 'errors', $updated->get_error_message() );
    return;
  }

  wp_safe_redirect( add_query_arg( 'tb_notice', 'profile-updated', tb_account_url() ) );
  exit;
}

/**
 * Section 2 : demande de changement d'email (vérification par lien).
 *
 * @param WP_User $user
 */
function tb_account_handle_email( WP_User $user ) {
  if ( ! isset( $_POST['tb_account_email_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tb_account_email_nonce'] ) ), 'tb_account_email' ) ) {
    tb_account_add_notice( 'errors', __( 'Session expirée, veuillez réessayer.', 'telabotanica' ) );
    return;
  }

  $new_email = isset( $_POST['tb_new_email'] ) ? sanitize_email( wp_unslash( $_POST['tb_new_email'] ) ) : '';

  if ( ! is_email( $new_email ) ) {
    tb_account_add_notice( 'errors', __( 'Adresse e-mail invalide.', 'telabotanica' ) );
    return;
  }

  if ( strcasecmp( $new_email, $user->user_email ) === 0 ) {
    tb_account_add_notice( 'info', __( 'C’est déjà votre adresse actuelle.', 'telabotanica' ) );
    return;
  }

  $owner = get_user_by( 'email', $new_email );
  if ( $owner instanceof WP_User && (int) $owner->ID !== (int) $user->ID ) {
    tb_account_add_notice( 'errors', __( 'Cette adresse est déjà utilisée par un autre compte.', 'telabotanica' ) );
    return;
  }

  $hash = wp_generate_password( 32, false, false );

  update_user_meta( $user->ID, '_new_tb_email', [
    'hash'     => $hash,
    'newemail' => $new_email,
    'expires'  => time() + DAY_IN_SECONDS,
  ] );

  $verify = tb_account_pending_email( $user->ID );
  if ( ! $verify || ! hash_equals( (string) $verify['hash'], $hash ) ) {
    tb_account_add_notice( 'errors', __( 'Impossible d’enregistrer la demande, veuillez réessayer.', 'telabotanica' ) );
    return;
  }

  $confirm_url = add_query_arg( 'tb_confirm_email', $hash, tb_account_url() );

  /* translators: %s: confirmation URL */
  $message = sprintf(
    __( "Bonjour %1\$s,\n\nVous avez demandé à changer l’adresse e-mail de votre compte Tela Botanica pour %2\$s.\n\nConfirmez ce changement en cliquant sur ce lien (valable 24 h) :\n%3\$s\n\nSi vous n’êtes pas à l’origine de cette demande, ignorez ce message.", 'telabotanica' ),
    $user->display_name,
    $new_email,
    $confirm_url
  );

  $sent = wp_mail(
    $new_email,
    __( '[Tela Botanica] Confirmez votre nouvelle adresse e-mail', 'telabotanica' ),
    $message
  );

  if ( ! $sent ) {
    delete_user_meta( $user->ID, '_new_tb_email' );
    tb_account_add_notice( 'errors', __( 'E-mail de confirmation non envoyé, veuillez réessayer.', 'telabotanica' ) );
    return;
  }

  wp_safe_redirect( add_query_arg( 'tb_notice', 'email-sent', tb_account_url() ) );
  exit;
}

/**
 * Section 3 : mot de passe (actuel + nouveau + confirmation).
 *
 * @param WP_User $user
 */
function tb_account_handle_password( WP_User $user ) {
  if ( ! isset( $_POST['tb_account_password_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tb_account_password_nonce'] ) ), 'tb_account_password' ) ) {
    tb_account_add_notice( 'errors', __( 'Session expirée, veuillez réessayer.', 'telabotanica' ) );
    return;
  }

  $current = isset( $_POST['tb_current_password'] ) ? wp_unslash( $_POST['tb_current_password'] ) : '';
  $new     = isset( $_POST['tb_new_password'] ) ? wp_unslash( $_POST['tb_new_password'] ) : '';
  $confirm = isset( $_POST['tb_new_password_confirm'] ) ? wp_unslash( $_POST['tb_new_password_confirm'] ) : '';

  if ( '' === $current || '' === $new || '' === $confirm ) {
    tb_account_add_notice( 'errors', __( 'Veuillez remplir les trois champs du mot de passe.', 'telabotanica' ) );
    return;
  }

  if ( ! wp_check_password( $current, $user->user_pass, $user->ID ) ) {
    tb_account_add_notice( 'errors', __( 'Le mot de passe actuel est incorrect.', 'telabotanica' ) );
    return;
  }

  if ( $new !== $confirm ) {
    tb_account_add_notice( 'errors', __( 'La confirmation ne correspond pas au nouveau mot de passe.', 'telabotanica' ) );
    return;
  }

  if ( strlen( $new ) < 12 ) {
    tb_account_add_notice( 'errors', __( 'Le nouveau mot de passe doit contenir au moins 12 caractères.', 'telabotanica' ) );
    return;
  }

  if ( hash_equals( (string) $current, (string) $new ) ) {
    tb_account_add_notice( 'errors', __( 'Le nouveau mot de passe doit être différent de l’actuel.', 'telabotanica' ) );
    return;
  }

  wp_set_password( $new, $user->ID );

  // Reconnecte l'utilisateur (wp_set_password déconnecte toutes les sessions).
  $fresh = get_user_by( 'ID', $user->ID );
  if ( $fresh instanceof WP_User ) {
    wp_set_current_user( $user->ID );
    wp_set_auth_cookie( $user->ID, true );
    do_action( 'wp_login', $fresh->user_login, $fresh );
  }

  wp_safe_redirect( add_query_arg( 'tb_notice', 'password-updated', tb_account_url() ) );
  exit;
}

/**
 * Section 4 : suppression du compte avec réassignation.
 *
 * @param WP_User $user
 */
function tb_account_handle_delete( WP_User $user ) {
  if ( ! isset( $_POST['tb_account_delete_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tb_account_delete_nonce'] ) ), 'tb_account_delete' ) ) {
    tb_account_add_notice( 'errors', __( 'Session expirée, veuillez réessayer.', 'telabotanica' ) );
    return;
  }

  if ( user_can( $user, 'manage_options' ) ) {
    tb_account_add_notice( 'errors', __( 'Un compte administrateur ne peut pas être supprimé ici.', 'telabotanica' ) );
    return;
  }

  $password = isset( $_POST['tb_delete_password'] ) ? wp_unslash( $_POST['tb_delete_password'] ) : '';
  $confirm  = isset( $_POST['tb_delete_confirm'] ) ? sanitize_text_field( wp_unslash( $_POST['tb_delete_confirm'] ) ) : '';

  if ( '' === $password ) {
    tb_account_add_notice( 'errors', __( 'Veuillez saisir votre mot de passe pour confirmer la suppression.', 'telabotanica' ) );
    return;
  }

  if ( 'SUPPRIMER' !== strtoupper( trim( $confirm ) ) ) {
    tb_account_add_notice( 'errors', __( 'Veuillez taper SUPPRIMER pour confirmer.', 'telabotanica' ) );
    return;
  }

  if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {
    tb_account_add_notice( 'errors', __( 'Le mot de passe est incorrect.', 'telabotanica' ) );
    return;
  }

  $reassign = tb_account_get_deleted_reassign_id();
  if ( is_wp_error( $reassign ) ) {
    tb_account_add_notice( 'errors', $reassign->get_error_message() );
    return;
  }

  if ( (int) $reassign === (int) $user->ID ) {
    tb_account_add_notice( 'errors', __( 'Suppression impossible pour ce compte.', 'telabotanica' ) );
    return;
  }

  require_once ABSPATH . 'wp-admin/includes/user.php';
  $deleted = wp_delete_user( $user->ID, $reassign );

  if ( ! $deleted ) {
    tb_account_add_notice( 'errors', __( 'La suppression a échoué, veuillez réessayer.', 'telabotanica' ) );
    return;
  }

  wp_logout();
  wp_safe_redirect( add_query_arg( 'account-deleted', '1', home_url( '/' ) ) );
  exit;
}

/**
 * Rendu du shortcode [tb_mon_compte].
 *
 * @return string HTML
 */
function tb_account_shortcode() {
  if ( ! is_user_logged_in() ) {
    $login_url = wp_login_url( tb_account_url() );
    return '<div class="tb-account"><p>' . esc_html__( 'Vous devez être connecté pour gérer votre compte.', 'telabotanica' ) . '</p>'
      . '<p><a class="button" href="' . esc_url( $login_url ) . '">' . esc_html__( 'Se connecter', 'telabotanica' ) . '</a></p></div>';
  }

  $user = wp_get_current_user();
  if ( ! $user instanceof WP_User || ! $user->exists() ) {
    return '<div class="tb-account"><p>' . esc_html__( 'Compte introuvable.', 'telabotanica' ) . '</p></div>';
  }

  // Notice via redirect (?tb_notice=...). Évite le re-POST au refresh.
  if ( isset( $_GET['tb_notice'] ) ) {
    switch ( sanitize_key( wp_unslash( $_GET['tb_notice'] ) ) ) {
      case 'email-confirmed':
        tb_account_add_notice( 'success', __( 'Adresse e-mail confirmée et mise à jour.', 'telabotanica' ) );
        break;
      case 'profile-updated':
        tb_account_add_notice( 'success', __( 'Pseudo mis à jour.', 'telabotanica' ) );
        break;
      case 'email-sent':
        tb_account_add_notice( 'success', __( 'E-mail de confirmation envoyé. Cliquez sur le lien reçu pour valider.', 'telabotanica' ) );
        break;
      case 'password-updated':
        tb_account_add_notice( 'success', __( 'Mot de passe mis à jour.', 'telabotanica' ) );
        break;
      default:
        break;
    }
  }

  $notices = tb_account_pull_notices();
  $pending = tb_account_pending_email( $user->ID );

  ob_start();
  ?>
  <div class="tb-account">
    <?php foreach ( $notices['errors'] as $message ) : ?>
      <div class="notice notice-alert"><span class="notice-text"><?php echo esc_html( $message ); ?></span></div>
    <?php endforeach; ?>
    <?php foreach ( $notices['success'] as $message ) : ?>
      <div class="notice notice-confirm"><span class="notice-text"><?php echo esc_html( $message ); ?></span></div>
    <?php endforeach; ?>
    <?php foreach ( $notices['info'] as $message ) : ?>
      <div class="notice notice-info"><span class="notice-text"><?php echo esc_html( $message ); ?></span></div>
    <?php endforeach; ?>

    <section class="tb-account-section" aria-labelledby="tb-account-profile-title">
      <h2 id="tb-account-profile-title"><?php esc_html_e( 'Pseudo affiché', 'telabotanica' ); ?></h2>
      <p class="description"><?php esc_html_e( 'Identifiant visible. Votre login de connexion reste inchangé.', 'telabotanica' ); ?></p>
      <form method="post" action="<?php echo esc_url( tb_account_url() ); ?>">
        <input type="hidden" name="tb_account_action" value="profile">
        <?php wp_nonce_field( 'tb_account_profile', 'tb_account_profile_nonce' ); ?>
        <p>
          <label for="tb_display_name"><?php esc_html_e( 'Pseudo', 'telabotanica' ); ?></label><br>
          <input type="text" id="tb_display_name" name="tb_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" maxlength="50" required autocomplete="nickname">
        </p>
        <p><button type="submit" class="button"><?php esc_html_e( 'Enregistrer le pseudo', 'telabotanica' ); ?></button></p>
      </form>
    </section>

    <section class="tb-account-section" aria-labelledby="tb-account-email-title">
      <h2 id="tb-account-email-title"><?php esc_html_e( 'Adresse e-mail', 'telabotanica' ); ?></h2>
      <p><?php printf( esc_html__( 'Adresse actuelle : %s', 'telabotanica' ), '<strong>' . esc_html( $user->user_email ) . '</strong>' ); ?></p>
      <?php if ( $pending ) : ?>
        <p class="description"><?php printf( esc_html__( 'Changement en attente vers %s : cliquez sur le lien reçu par e-mail (valable 24 h).', 'telabotanica' ), '<strong>' . esc_html( $pending['newemail'] ) . '</strong>' ); ?></p>
      <?php endif; ?>
      <form method="post" action="<?php echo esc_url( tb_account_url() ); ?>">
        <input type="hidden" name="tb_account_action" value="email">
        <?php wp_nonce_field( 'tb_account_email', 'tb_account_email_nonce' ); ?>
        <p>
          <label for="tb_new_email"><?php esc_html_e( 'Nouvelle adresse e-mail', 'telabotanica' ); ?></label><br>
          <input type="email" id="tb_new_email" name="tb_new_email" value="" required autocomplete="email">
        </p>
        <p><button type="submit" class="button"><?php esc_html_e( 'Recevoir le lien de vérification', 'telabotanica' ); ?></button></p>
      </form>
    </section>

    <section class="tb-account-section" aria-labelledby="tb-account-password-title">
      <h2 id="tb-account-password-title"><?php esc_html_e( 'Mot de passe', 'telabotanica' ); ?></h2>
      <form method="post" action="<?php echo esc_url( tb_account_url() ); ?>" autocomplete="off">
        <input type="hidden" name="tb_account_action" value="password">
        <?php wp_nonce_field( 'tb_account_password', 'tb_account_password_nonce' ); ?>
        <p>
          <label for="tb_current_password"><?php esc_html_e( 'Mot de passe actuel', 'telabotanica' ); ?></label><br>
          <input type="password" id="tb_current_password" name="tb_current_password" required autocomplete="current-password">
        </p>
        <p>
          <label for="tb_new_password"><?php esc_html_e( 'Nouveau mot de passe (12 caractères minimum)', 'telabotanica' ); ?></label><br>
          <input type="password" id="tb_new_password" name="tb_new_password" required minlength="12" autocomplete="new-password">
        </p>
        <p>
          <label for="tb_new_password_confirm"><?php esc_html_e( 'Confirmer le nouveau mot de passe', 'telabotanica' ); ?></label><br>
          <input type="password" id="tb_new_password_confirm" name="tb_new_password_confirm" required minlength="12" autocomplete="new-password">
        </p>
        <p><button type="submit" class="button"><?php esc_html_e( 'Changer le mot de passe', 'telabotanica' ); ?></button></p>
      </form>
    </section>

    <section class="tb-account-section tb-account-danger" aria-labelledby="tb-account-delete-title">
      <h2 id="tb-account-delete-title"><?php esc_html_e( 'Supprimer mon compte', 'telabotanica' ); ?></h2>
      <p class="description"><?php esc_html_e( 'Vos contenus seront réassignés au compte Ex-telabotaniste. Cette action est définitive.', 'telabotanica' ); ?></p>
      <form method="post" action="<?php echo esc_url( tb_account_url() ); ?>" autocomplete="off" onsubmit="return confirm('Supprimer définitivement votre compte ?');">
        <input type="hidden" name="tb_account_action" value="delete">
        <?php wp_nonce_field( 'tb_account_delete', 'tb_account_delete_nonce' ); ?>
        <p>
          <label for="tb_delete_password"><?php esc_html_e( 'Mot de passe actuel', 'telabotanica' ); ?></label><br>
          <input type="password" id="tb_delete_password" name="tb_delete_password" required autocomplete="current-password">
        </p>
        <p>
          <label for="tb_delete_confirm"><?php esc_html_e( 'Tapez SUPPRIMER pour confirmer', 'telabotanica' ); ?></label><br>
          <input type="text" id="tb_delete_confirm" name="tb_delete_confirm" required autocomplete="off">
        </p>
        <p><button type="submit" class="button rouge"><?php esc_html_e( 'Supprimer définitivement mon compte', 'telabotanica' ); ?></button></p>
      </form>
    </section>
  </div>
  <?php
  return (string) ob_get_clean();
}
add_shortcode( 'tb_mon_compte', 'tb_account_shortcode' );
