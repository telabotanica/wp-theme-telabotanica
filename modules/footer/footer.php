<?php function telabotanica_module_footer($data) { ?>
  <footer class="footer" role="contentinfo">
    <div class="footer-about layout-2-col">
      <div class="layout-wrapper">
        <div class="footer-about-tela layout-column">
          <div class="footer-about-tela-logo">
            <img src="<?php echo get_template_directory_uri() . '/modules/footer/logo.svg'; ?>" alt="Tela Botanica" />
          </div>
          <div class="footer-about-tela-details">
            <div class="footer-about-tela-details-adresse">4 rue de Belfort, 34000 Montpellier, France</div>
            <div class="footer-about-tela-details-tel"><?php _e( 'Téléphone', 'telabotanica' ) ?> : +33 (4) 67 52 41 225</div>
            <div class="footer-about-tela-details-mail"><a href="mailto:accueil@tela-botanica.org">accueil@tela-botanica.org</a></div>
          </div>

          <ul class="footer-about-tela-social-items">
            <li class="footer-about-tela-social-item"><a href="https://www.facebook.com/telabotanica/" target="_blank"><?php the_telabotanica_module('icon', ['icon' => 'facebook-disc']) ?> Facebook</a></li>
            <li class="footer-about-tela-social-item"><a href="https://twitter.com/TelaBotanica" target="_blank"><?php the_telabotanica_module('icon', ['icon' => 'twitter-disc']) ?> Twitter</a></li>
            <li class="footer-about-tela-social-item"><a href="https://vimeo.com/telabotanica" target="_blank"><?php the_telabotanica_module('icon', ['icon' => 'vimeo-disc']) ?> Vimeo</a></li>
            <li class="footer-about-tela-social-item"><a href="https://github.com/telabotanica" target="_blank"><?php the_telabotanica_module('icon', ['icon' => 'github-disc']) ?> Github</a></li>
          </ul>
        </div>

        <?php
          global $footer_no_newsletter;
          global $footer_newsletter_no_subscription;
          if ($footer_no_newsletter !== true) {
            $newsletter_module_options = ['modifiers' => 'layout-column'];
            if ($footer_newsletter_no_subscription === true) {
              $newsletter_module_options['button'] = false;
            }
            the_telabotanica_module('newsletter',  $newsletter_module_options);
          }
        ?>
      </div>
    </div>

    <?php if ( has_nav_menu( 'footer-columns' ) ) : ?>
      <nav class="footer-nav" role="navigation" aria-label="<?php esc_attr_e( 'Plan du site', 'telabotanica' ); ?>">
        <?php
          wp_nav_menu( [
            'theme_location' => 'footer-columns',
            'menu_class'     => 'footer-nav-items layout-wrapper',
          ] );
        ?>
      </nav>
    <?php endif; ?>

    <?php if ( has_nav_menu( 'footer-bar' ) ) : ?>
      <nav class="footer-nav-bar" role="navigation" aria-label="<?php esc_attr_e( 'Menu de pied de page', 'telabotanica' ); ?>">
        <?php
          wp_nav_menu( [
            'theme_location' => 'footer-bar',
            'menu_class'     => 'footer-nav-bar-items',
            'depth'          => 1,
          ] );
        ?>
        <a href="https://creativecommons.org/licenses/by-sa/4.0/deed.<?php echo ICL_LANGUAGE_CODE ?>" target="_blank" rel="nofollow" class="footer-nav-license">CC BY-SA 4.0</a>
      </nav>
    <?php endif; ?>
  </footer><!-- .site-footer -->
<?php }
