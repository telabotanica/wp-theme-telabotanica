<?php
/**
 * Page d'accueil de l'Espace Projets, listant les projets
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php the_telabotanica_module('cover', []); ?>

      <div class="layout-left-col full-width">
        <div class="layout-wrapper">
          <aside class="layout-column">
            <?php
            $categories_items = [
              [
                'text' => __('Tous les projets', 'telabotanica'),
                'href' => bp_get_groups_directory_permalink(),
                'items' => [
                  [
                    'text' => "Catégorie 1",
                    'href' => '#categorie-1'
                  ],
                  [
                    'text' => "Catégorie 2",
                    'href' => '#categorie-2'
                  ],
                  [
                    'text' => "Catégorie 3",
                    'href' => '#categorie-3'
                  ],
                ]
              ]
            ];

            if ( is_user_logged_in() && bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) :
              $categories_items[] = [
                'text' => __('Mes projets', 'telabotanica'),
                'number' => bp_get_total_group_count_for_user( bp_loggedin_user_id() ),
                'href' => trailingslashit( bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups' )
              ];
            endif;

            $help_project_page = get_page_by_path( 'projets/aide' );
            if ( $help_project_page ) :
              $categories_items[] = [
                'text' => get_the_title( $help_project_page ),
                'href' => get_permalink( $help_project_page )
              ];
            endif;

            the_telabotanica_module('categories', [
              'modifiers' => 'layout-column-item',
              'items' => $categories_items
            ] );

            echo '<div class="layout-column-item">';
            $create_project_page = get_page_by_path( 'projets/creer-un-projet' );
            if ( $create_project_page ) :
              the_telabotanica_module('button', [
                'text' => get_the_title( $create_project_page ),
                'href' => get_permalink( $create_project_page ),
                'modifiers' => 'block'
              ] );
            endif;
            echo '</div>';

            ?>
          </aside>
          <div class="layout-content">
            <?php
            the_telabotanica_module('breadcrumbs', ['modifiers' => 'no-border']);
            the_telabotanica_module('list-projects', []);
            ?>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
