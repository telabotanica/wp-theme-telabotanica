<?php
/**
 * Template pour le formulaire de désinscription de la newsletter
 *
 * Utilise la bibliothèque de gestion de liste définie par le plugin
 * Tela Botanica, et envoie un ordre de désinscription à toute personne
 * saisissant son adresse email dans le formulaire
 */
 /*
Template Name: newsletter-desinscription
*/

get_header();

?>
<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <div class="layout-wrapper">
      <div class="layout-content">
        <?php the_telabotanica_module('breadcrumbs'); ?>
        <article class="newsletter-unsubscribe">
          <div class="component component-title level-2">
            <h1><?php echo get_the_title() ?></h1>
          </div>

<?php
// Détection du plugin Tela Botanica
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// détecte si le plugin TB est activé, sans avoir à mentionner le nom du dossier
if (function_exists('tbChargerConfigPlugin')) {

  // adresse de la liste "lettre d'actu"
  $newsletter_config = json_decode(get_option('tb_newsletter_config'), true);
  if (! empty($newsletter_config['newsletter_recipient'])) {
    if (! empty($_POST['name'])) {
      //robot
    } elseif (!empty ($_POST['email'])) {
      $email = trim($_POST['email']);
      // instance du gestionnaire de liste, pour la lettre d'actualités de TB ou du Mooc
      // $listes est défini par le template parent
      if (empty($listes)) {
        $adresse_liste = $newsletter_config['newsletter_recipient'];
        $nom_liste = trim(substr($adresse_liste, 0, strpos($adresse_liste, '@')));
        $liste = new TB_ListeEzmlm($nom_liste);
        // désinscription
        $ok = $liste->modifierStatutAbonnement(false, $email);
      } else {
        $ok = false;
        foreach ($listes as $nom_liste) {
          $liste = new TB_ListeEzmlm($nom_liste);
          $res = $liste->modifierStatutAbonnement(false, $email);
          $ok = $res || $ok;
        }
      }

      if ($ok) {
        ?>
        <p>
          <?php printf(__("L'adresse <strong>%s</strong> a bien été désinscrite de la lettre d'actualités", 'telabotanica'), $email) ?>.
        </p>
        <?php
        // si la personne a un compte, décochage de la case "je veux
        // recevoir la lettre" dans son profil
        $utilisateur = get_user_by( 'email', $email );
        if (empty($listes) && $utilisateur) {
          $config_plugin_tb = tbChargerConfigPlugin();
          if (! empty($config_plugin_tb['profil']['id_case_inscription_lettre_actu'])) {
            $id_case = $config_plugin_tb['profil']['id_case_inscription_lettre_actu'];
            // modification de la métadonnée
            xprofile_set_field_data($id_case, $utilisateur->ID, false);
            ?>
            <p>
              <?php printf(__("Votre profil a été mis à jour", 'telabotanica'), $email) ?>.
            </p>
            <?php
          } // else message ?
        }
      } else {
        $destinataires_emails_erreurs = $newsletter_config['error_recipients_emails'];
        /**
         * Lors d'un échec de désinscription, envoie une alerte par email
         * aux destinataires listés dans la configuration du plugin :
         * "Newsletter" => "Réglages" => "Destinataires des emails d'erreurs"
         */
        $message = 'Désinscription à la lettre d\'actu : erreur ! ' . "\r\n"
          . "\r\n"
          . 'Adresse à désinscrire : ' . $email . "\r\n"
          . 'Liste : ' . $nom_liste . "\r\n"
        ;
        $headers = 'Content-Type: text/plain; charset="utf-8"' . "\r\n"
          . 'Content-Transfer-Encoding: 8bit' . "\r\n"
          . 'From: wp-newsletter@tela-botanica.org' . "\r\n"
          . 'Reply-To: no-reply@example.com' . "\r\n"
          . 'X-Mailer: PHP/' . phpversion()
        ;
        foreach ($destinataires_emails_erreurs as $destinataire) {
          if ($destinataire && '#' !== substr($destinataire, 0, 1)) {
            error_log($message, 1, $destinataire, $headers);
            error_log($message);
          }
        }
        the_telabotanica_module('notice', [
          'type' => 'warning',
          'text' =>
            __( "Une erreur est survenue lors de la désinscription, nous en avons été informés.", 'telabotanica' )
            . ' '
            . __( "Pour plus d'informations n'hésitez pas à nous contacter", 'telabotanica' )

        ]);
      }
    }
  } else {
    // erreur config lettre
    the_telabotanica_module('notice', [
      'type' => 'warning',
      'title' => __( "Configuration incomplète", 'telabotanica' ),
      'text' => __( "Vérifiez les réglages de la lettre d'actualités", 'telabotanica' )
    ]);
  }
  ?>
  <form method="post" action="" class="form-newsletter layout-column">
    <input type="hidden" name="name" id="name">
    <input class="form-newsletter-email" name="email" type="email" required placeholder="<?php _e('Votre adresse e-mail', 'telabotanica') ?>">
    <?php the_telabotanica_module('button', [
      'tag' => 'button',
      'extra_attributes' => ['type' => 'submit'],
      'icon_before' => 'mail',
      'text' => __( 'Me désinscrire', 'telabotanica' )
    ] ); ?>
  </form>
<?php
} else {
  ?>
  <p><?php _e("Vérifiez que le plugin Tela Botanica est installé et activé", 'telabotanica') ?>.</p>
  <?php
}
?>
        </article>
      </div>
    </div>
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php
get_footer();
