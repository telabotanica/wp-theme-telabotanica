<?php
require_once 'inc/walker.php';

function telabotanica_module_header($data) {
  // $header_small can be set be true before calling get_header()
  // in a template file to force a small header (without use cases navigation)
  $header_small = $data->small ?? false;

  $defaults = [
    'image' => tb_acf('cover_image'),
    'title' => get_the_title(),
    'subtitle' => tb_acf('cover_subtitle'),
    'content' => false,
    'search' => false,
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('header', $data->modifiers);
  if ( $header_small === true ) $data->modifiers[] = 'is-small';

  printf(
    '<header class="%s" role="banner">',
    implode(' ', $data->modifiers)
  );

    echo '<div class="header-fixed">';

      // Logo

      $logo_element = ( is_front_page() && is_home() ) ? 'h1' : 'div';

      printf(
        '<%s class="header-logo"><a href="%s" rel="home">%s</a></%s>',
        $logo_element,
        esc_url( home_url( '/' ) ),
        sprintf(
          '<img src="%s" alt="Tela Botanica" />',
          get_template_directory_uri() . '/modules/header/logo.svg'
        ),
        $logo_element
      );

      printf(
        '<button type="button" class="header-toggle">%s%s</button>',
        __( 'Menu', 'telabotanica' ),
        get_telabotanica_module('icon', ['icon' => 'menu'])
      );

      printf(
        '<button type="button" class="header-toggle is-hidden">%s%s</button>',
        __( 'Fermer', 'telabotanica' ),
        get_telabotanica_module('icon', ['icon' => 'close'])
      );

      // Menu secondaire

      if ( has_nav_menu('secondary') ) :

        printf(
          '<nav class="header-nav" role="navigation" aria-label="%s">',
          esc_attr__( 'Menu secondaire', 'telabotanica' )
        );
          wp_nav_menu( [
            'container'      => false,
            'theme_location' => 'secondary',
            'menu_class'     => 'header-nav-items',
            'depth'          => 2,
//            'walker' => new Walker_Nav_Menu(),
            'walker'         => new HeaderNavWalker(),
            'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>'
           ] );
        echo '</nav>';

      endif;

      echo '<ul class="header-links">';


      // Utilisateur

      if ( is_user_logged_in() ) :
        $current_user = wp_get_current_user();
        $account_url = function_exists( 'tb_account_url' ) ? tb_account_url() : wp_login_url();
        $logout_url = wp_logout_url( home_url() );
        $avatar_url = function_exists( 'tb_account_avatar_url' ) ? tb_account_avatar_url( $current_user->ID ) : get_avatar_url( $current_user->ID ); ?>
        <li class="header-links-item header-links-item-user has-submenu">
          <button type="button" class="header-user-toggle" aria-haspopup="true" aria-expanded="false">
            <span class="header-links-item-text">
              <span class="header-links-item-user-name"><?php echo esc_html( $current_user->display_name ); ?></span>
              <?php if ( $avatar_url ) : ?>
                <span class="header-links-item-user-avatar" style="background-image: url(<?php echo esc_url( $avatar_url ); ?>);"></span>
              <?php endif; ?>
            </span>
          </button>
          <ul class="header-user-submenu" role="menu" aria-label="<?php esc_attr_e( 'Mon compte', 'telabotanica' ); ?>">
            <li role="none"><a role="menuitem" href="<?php echo esc_url( $account_url ); ?>"><?php esc_html_e( 'Afficher mon profil', 'telabotanica' ); ?></a></li>
            <li role="none"><a role="menuitem" href="<?php echo esc_url( $logout_url ); ?>"><?php esc_html_e( 'Me déconnecter', 'telabotanica' ); ?></a></li>
          </ul>
        </li>
      <?php else :
        printf(
          '<li class="header-links-item header-links-item-login"><a href="%s"><span class="header-links-item-text">%s</span></a></li>',
          wp_login_url( get_permalink() ),
          __( 'Connexion', 'telabotanica' )
        );
      endif;


      // Choix de la langue

      // echo '<li class="header-links-item">';
      //   if (function_exists('icl_get_languages')) :
      //     try {
      //       foreach (icl_get_languages() as $locale) {
      //         if ($locale['active'] === '1') {continue;}
      //         printf(
      //           '<a href="%s" rel="alternate" hreflang="%s" title="%s"><span class="header-links-item-text">%s</span></a>',
      //           $locale['url'],
      //           $locale['code'],
      //           $locale['native_name'],
      //           strtoupper($locale['code'])
      //         );
      //       }
      //     } catch (Exception $e) {
      //       echo $e->getMessage();
      //     }
      //   endif;
      // echo '</li>';


      // Lien "Faites un don"

      printf(
        '<li class="header-links-item header-links-item-donate"><a href="%s">%s%s</a></li>',
        get_permalink( get_page_by_path( 'presentation/soutenir' ) ),
        get_telabotanica_module('icon', ['icon' => 'heart', 'color' => 'vert-clair']),
        __( 'Faites un don !', 'telabotanica' )
      );

      // Recherche

//      printf(
//        '<li class="header-links-item header-links-item-search">%s</li>',
//        get_telabotanica_module('search-box', [
//          'placeholder' => __('Rechercher...', 'telabotanica'),
//          'modifiers' => ['tiny']
//        ])
//      );
    echo '</ul>';
  echo '</div>';


  // Menu principal

  if ( has_nav_menu('principal') && $header_small !== true ) :

    printf(
      '<nav class="header-nav-usecases" role="navigation" aria-label="%s">',
      esc_attr__( 'Menu principal', 'telabotanica' )
    );
      wp_nav_menu( [
        'theme_location'  => 'principal',
        'menu_class'      => 'header-nav-usecases-items',
        'depth'            => 1,
      ] );
    echo '</nav>';

  endif;

  printf(
    '<div class="header-container"></div><div class="header-submenu-container"><button class="header-submenu-back">%s%s</button><div class="header-submenu-container-nav"></div></div>',
    get_telabotanica_module('icon', ['icon' => 'arrow-left']),
    __( 'Retour', 'telabotanica' )
  );

  echo '</header>';
}
