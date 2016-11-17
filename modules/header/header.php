<?php function telabotanica_module_header($data) { ?>
<header class="header" role="banner">
  <div class="header-fixed">
    <?php
      $logo_element = ( is_front_page() && is_home() ) ? 'h1' : 'div';
      ?>
      <<?php echo $logo_element ?> class="header-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <img src="<?php echo get_template_directory_uri() . '/modules/header/logo.svg'; ?>" alt="Tela Botanica" />
      </a></<?php echo $logo_element ?>>
    <?php if ( has_nav_menu('secondary') ) : ?>
      <nav class="header-nav" role="navigation"  aria-label="<?php esc_attr_e( 'Menu secondaire', 'telabotanica' ); ?>">
        <?php
          wp_nav_menu( [
            'theme_location' => 'secondary',
            'menu_class'     => 'header-nav-items',
            'depth'          => 1,
           ] );
        ?>
      </nav>
    <?php endif; ?>
    <ul class="header-links">
      <?php if ( is_user_logged_in() ) :
        $current_user = wp_get_current_user();
        $avatar_url = get_avatar_url($current_user->ID, [ 'size' => 22 ]); ?>
        <li class="header-links-item header-links-item-user">
          <a href="<?php echo admin_url(); ?>">
            <span class="header-links-item-text">
              <?php echo $current_user->display_name; ?>
              <span class="header-links-item-user-avatar" style="background-image: url(<?php echo $avatar_url ?>);"></span>
            </span>
          </a>
        </li>
      <?php else : ?>
        <li class="header-links-item header-links-item-login"><a href="<?php echo wp_login_url( get_permalink() ); ?>"><span class="header-links-item-text"><?php _e( 'Connexion', 'telabotanica' ) ?></span></a></li>
      <?php endif; ?>
      <li class="header-links-item">
        <?php
        if (function_exists('icl_get_languages')) :
          try {
            foreach (icl_get_languages() as $locale) {
              if ($locale['active'] === '1') {continue;}
              echo '<a href="' . $locale['url'] . '" rel="alternate" hreflang="' . $locale['code'] . '" title="' . $locale['native_name'] . '"><span class="header-links-item-text">' . strtoupper($locale['code']) . '</span></a>';
            }
          } catch (Exception $e) {
            echo $e->getMessage();
          }
        endif; ?>
      </li>
      <li class="header-links-item header-links-item-donate"><a href="#"><?php _e( 'Faites un don !', 'telabotanica' ) ?></a></li>
      <li class="header-links-item header-links-item-search"><a href="<?php echo get_search_link(); ?>"><span class="header-links-item-text">🔎</span></a></li>
    </ul>
  </div>
  <?php if ( has_nav_menu('principal') ) : ?>
    <nav class="header-nav-usecases" role="navigation" aria-label="<?php esc_attr_e( 'Menu principal', 'telabotanica' ); ?>">
      <?php
        wp_nav_menu( [
          'theme_location' => 'principal',
          'menu_class'     => 'header-nav-usecases-items',
          'depth'          => 1,
         ] );
      ?>
    </nav>
  <?php endif; ?>
</header>
<?php }
