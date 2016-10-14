<?php function telabotanica_module_header($data) { ?>
<header class="header" role="banner">
  <div class="header-fixe">
    <?php if ( is_front_page() && is_home() ) : ?>
      <h1 class="header-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Tela Botanica</a></h1>
    <?php else : ?>
      <div class="header-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Tela Botanica</a></div>
    <?php endif; ?>
    <?php if ( has_nav_menu('secondaire') ) : ?>
      <nav class="header-nav" role="navigation"  aria-label="<?php esc_attr_e( 'Menu secondaire', 'telabotanica' ); ?>">
        <?php
          wp_nav_menu( array(
            'theme_location' => 'secondaire',
            'menu_class'     => 'header-nav-items',
            'depth'          => 1,
           ) );
        ?>
      </nav>
    <?php endif; ?>
    <ul class="header-liens">
      <li class="header-liens-item header-liens-item-login"><a href="#"><span class="header-liens-item-texte">Connexion</span></a></li>
      <li class="header-liens-item"><a href="#"><span class="header-liens-item-texte">EN</span></a></li>
      <li class="header-liens-item header-liens-item-don"><a href="#">Faites un don !</a></li>
      <li class="header-liens-item header-liens-item-recherche"><a href="#"><span class="header-liens-item-texte">🔎</span></a></li>
    </ul>
  </div>
  <?php if ( has_nav_menu('principal') ) : ?>
    <nav class="header-nav-usages" role="navigation" aria-label="<?php esc_attr_e( 'Menu principal', 'telabotanica' ); ?>">
      <?php
        wp_nav_menu( array(
          'theme_location' => 'principal',
          'menu_class'     => 'header-nav-usages-items',
          'depth'          => 1,
         ) );
      ?>
    </nav>
  <?php endif; ?>
</header>
<?php }
