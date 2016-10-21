<?php function telabotanica_module_footer($data) { ?>
  <footer class="footer" role="contentinfo">
    <div class="footer-about layout-2-col">
      <div class="layout-wrapper">
        <div class="footer-about-tela layout-column">
          <div class="footer-about-tela-logo">Tela Botanica</div>
          <div class="footer-about-tela-details">
            <div class="footer-about-tela-details-adresse">4 rue de Belfort, 34000 Montpellier, France</div>
            <div class="footer-about-tela-details-tel"><?php _e( 'Téléphone', 'telabotanica' ) ?> : +33 (4) 67 52 41 225</div>
            <div class="footer-about-tela-details-mail"><a href="mailto:accueil@tela-botanica.org">accueil@tela-botanica.org</a></div>
          </div>

          <ul class="footer-about-tela-social-items">
            <li class="footer-about-tela-social-item"><a href="#" target="_blank"><i class="footer-about-tela-social-icon icon-facebook"></i> Facebook</a></li>
            <li class="footer-about-tela-social-item"><a href="#" target="_blank"><i class="footer-about-tela-social-icon icon-twitter"></i> Twitter</a></li>
            <li class="footer-about-tela-social-item"><a href="#" target="_blank"><i class="footer-about-tela-social-icon icon-pinterest"></i> Pinterest</a></li>
          </ul>
        </div>

        <?php the_telabotanica_module('form-newsletter', array('modifiers' => 'layout-column')); ?>
      </div>
    </div>

    <?php if ( has_nav_menu( 'footer-columns' ) ) : ?>
      <nav class="footer-nav" role="navigation" aria-label="<?php esc_attr_e( 'Plan du site', 'telabotanica' ); ?>">
        <?php
          wp_nav_menu( array(
            'theme_location' => 'footer-columns',
            'menu_class'     => 'footer-nav-items layout-wrapper',
          ) );
        ?>
      </nav>
    <?php endif; ?>

    <?php if ( has_nav_menu( 'footer-bar' ) ) : ?>
      <nav class="footer-nav-bar" role="navigation" aria-label="<?php esc_attr_e( 'Menu de pied de page', 'telabotanica' ); ?>">
        <?php
          wp_nav_menu( array(
            'theme_location' => 'footer-bar',
            'menu_class'     => 'footer-nav-bar-items',
            'depth'          => 1,
          ) );
        ?>
        <a href="http://creativecommons.org/licenses/by-sa/2.0/fr/" target="_blank" rel="nofollow" class="footer-nav-license">CC BY-SA 2.0</a>
      </nav>
    <?php endif; ?>
  </footer><!-- .site-footer -->
<?php }
