<?php
require_once 'inc/walker.php';

function telabotanica_module_header($data)
{
    // $header_small can be set be true before calling get_header()
    // in a template file to force a small header (without use cases navigation)
    global $header_small;

    $defaults = [
        'image'     => get_field('cover_image'),
        'title'     => get_the_title(),
        'subtitle'  => get_field('cover_subtitle'),
        'content'   => false,
        'search'    => false,
        'modifiers' => [],
    ];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('header', $data->modifiers);
    if ($header_small === true) {
        $data->modifiers[] = 'is-small';
    }

    printf(
        '<header class="%s" role="banner">',
        implode(' ', $data->modifiers)
    );

    echo '<div class="header-fixed">';

            // Logo

            $logo_element = (is_front_page() && is_home()) ? 'h1' : 'div';

    printf(
                '<%s class="header-logo"><a href="%s" rel="home">%s</a></%s>',
                $logo_element,
                esc_url(home_url('/')),
                sprintf(
                    '<img src="%s" alt="Tela Botanica" />',
                    get_template_directory_uri().'/modules/header/logo.svg'
                ),
                $logo_element
            );

            // Menu secondaire

            if (has_nav_menu('secondary')) :

                printf(
                    '<nav class="header-nav" role="navigation" aria-label="%s">',
                    esc_attr__('Menu secondaire', 'telabotanica')
                );
    wp_nav_menu([
                        'container'      => false,
                        'theme_location' => 'secondary',
                        'menu_class'     => 'header-nav-items',
                        'depth'          => 2,
                        'walker'         => new HeaderNavWalker(),
                        'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
                     ]);
    echo '</nav>';

    endif;

    echo '<ul class="header-links">';

            // Utilisateur

            if (is_user_logged_in()) :
                $current_user = wp_get_current_user();
    $avatar_url = bp_core_fetch_avatar([
                    'item_id' => $current_user->ID,
                    'html'    => false,
                ]); ?>
				<li class="header-links-item header-links-item-user">
					<a href="<?php echo bp_loggedin_user_domain(); ?>">
						<span class="header-links-item-text">
							<?php echo $current_user->display_name; ?>
							<span class="header-links-item-user-avatar" style="background-image: url(<?php echo $avatar_url ?>);"></span>
						</span>
					</a>
				</li>
			<?php else :
                printf(
                    '<li class="header-links-item header-links-item-login"><a href="%s"><span class="header-links-item-text">%s</span></a></li>',
                    wp_login_url(get_permalink()),
                    __('Connexion', 'telabotanica')
                );
    endif;

            // Choix de la langue

            echo '<li class="header-links-item">';
    if (function_exists('icl_get_languages')) :
                    try {
                        foreach (icl_get_languages() as $locale) {
                            if ($locale['active'] === '1') {
                                continue;
                            }
                            printf(
                                '<a href="%s" rel="alternate" hreflang="%s" title="%s"><span class="header-links-item-text">%s</span></a>',
                                $locale['url'],
                                $locale['code'],
                                $locale['native_name'],
                                strtoupper($locale['code'])
                            );
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
    endif;
    echo '</li>';

            // Lien "Faites un don"

            printf(
                '<li class="header-links-item header-links-item-donate"><a href="%s">%s</a></li>',
                get_permalink(get_page_by_path('presentation/soutenir')),
                __('Faites un don !', 'telabotanica')
            );

            // Recherche

            printf(
                '<li class="header-links-item header-links-item-search">%s</li>',
                get_telabotanica_module('search-box', [
                    'placeholder' => __('Rechercher...', 'telabotanica'),
                    'modifiers'   => ['tiny'],
                ])
            );
    echo '</ul>';
    echo '</div>';

    // Menu principal

    if (has_nav_menu('principal') && $header_small !== true) :

        printf(
            '<nav class="header-nav-usecases" role="navigation" aria-label="%s">',
            esc_attr__('Menu principal', 'telabotanica')
        );
    wp_nav_menu([
                'theme_location'               => 'principal',
                'menu_class'                   => 'header-nav-usecases-items',
                'depth'                        => 1,
            ]);
    echo '</nav>';

    endif;

    echo '</header>';
}
