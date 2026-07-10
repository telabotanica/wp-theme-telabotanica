<?php
/**
 * Template pour le formulaire de désinscription de la newsletter
 *
 * Utilise l'API Brevo (ex Sendinblue) pour blacklister l'adresse email
 * et la désinscrire de toutes les communications.
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
if (function_exists('tbChargerConfigPlugin')) {

  $newsletter_config = json_decode(get_option('tb_newsletter_config'), true);

  if (! empty($newsletter_config['brevo_api_key'])) {
    if (! empty($_POST['name'])) {
      //robot
    } elseif (!empty ($_POST['email'])) {
      $email = trim($_POST['email']);

      require_once WP_PLUGIN_DIR . '/telabotanica/newsletter/class-brevo-api.php';

      try {
        $brevo = new Brevo_API($newsletter_config['brevo_api_key']);
        $brevo->unsubscribe($email);
        ?>
        <p>
          <?php printf(__("L'adresse <strong>%s</strong> a bien été désinscrite de la lettre d'actualités", 'telabotanica'), esc_html($email)) ?>.
        </p>
        <?php
        $utilisateur = get_user_by('email', $email);
        if ($utilisateur) {
          $config_plugin_tb = tbChargerConfigPlugin();
          if (! empty($config_plugin_tb['profil']['id_case_inscription_lettre_actu'])) {
            $id_case = $config_plugin_tb['profil']['id_case_inscription_lettre_actu'];
            xprofile_set_field_data($id_case, $utilisateur->ID, false);
            ?>
            <p>
              <?php printf(__("Votre profil a été mis à jour", 'telabotanica'), esc_html($email)) ?>.
            </p>
            <?php
          }
        }
      } catch (\RuntimeException $e) {
        $destinataires_emails_erreurs = $newsletter_config['error_recipients_emails'];
        $message = 'Désinscription à la lettre d\'actu : erreur ! ' . "\r\n"
          . "\r\n"
          . 'Adresse à désinscrire : ' . $email . "\r\n"
          . 'Erreur : ' . $e->getMessage() . "\r\n"
        ;
        $headers = 'Content-Type: text/plain; charset="utf-8"' . "\r\n"
          . 'Content-Transfer-Encoding: 8bit' . "\r\n"
          . 'From: wp-newsletter@tela-botanica.org' . "\r\n"
          . 'Reply-To: no-reply@example.com' . "\r\n"
          . 'X-Mailer: PHP/' . phpversion()
        ;
        foreach ((array) $destinataires_emails_erreurs as $destinataire) {
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
