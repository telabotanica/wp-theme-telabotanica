<?php
/**
 * Page d'accueil
 */

get_header();

$category = get_category( get_query_var('cat') );
$category_actualites = get_category_by_slug( 'actualites' );
$category_emploi = get_category_by_slug( 'offres-emploi' );
$category_evenements = get_category_by_slug( 'evenements' );
$is_category_emploi = is_category( $category_emploi ) || cat_is_ancestor_of( $category_emploi, $category );
$is_category_events = is_category( $category_evenements ) || cat_is_ancestor_of( $category_evenements, $category );
?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php
      $cover_image = get_field('cover_image', get_queried_object());

      if ($is_category_emploi) {
        the_telabotanica_module('cover', [
          'title' => $category_emploi->name,
          'subtitle' => __("Toutes les offres d'emploi, de stage et de service civique", 'telabotanica'),
          'image' => $cover_image,
          'search' => false
        ] );
      } elseif ($is_category_events) {
        the_telabotanica_module('cover', [
          'title' => $category_evenements->name,
          'subtitle' => __('Tous les évènements à venir', 'telabotanica'),
          'image' => $cover_image,
          'search' => [
            'index' => 'evenements',
            'placeholder' => __('Rechercher un évènement...', 'telabotanica'),
            'instantsearch' => true,
            'pageurl' => 'evenements'
          ]
        ] );
      } else {
        the_telabotanica_module('cover', [
          'title' => $category_actualites->name,
          'subtitle' => sprintf(
            __('Toute l\'<a href="%s">actualité</a>, les <a href="%s">offres d\'emploi</a> et les <a href="%s">évènements</a>', 'telabotanica'),
            get_category_link( $category_actualites ),
            get_category_link( $category_emploi ),
            get_category_link( $category_evenements )
          ),
          'image' => get_field( 'cover_image', get_queried_object() ),
          'search' => [
            'index' => 'actualites',
            'placeholder' => __("Rechercher une actualité...", 'telabotanica'),
            'instantsearch' => true,
            'pageurl' => 'actualites'
          ]
        ] );
      }
      ?>

      <div class="layout-content-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
            <?php

            $algolia_autocomplete_config = telabotanica_algolia_config()['autocomplete'];
            $current_index = $is_category_events ? 'evenements' : 'actualites';

            // Retrieve the label for the current index
            $indices = $algolia_autocomplete_config['sources'];
            foreach ( $indices as $index ) :
              if ( $index['index_id'] === $current_index ) {
                $current_index = [
                  'id' => $current_index,
                  'label' => $index['label'],
                  'name' => $index['index_name'],
                  'filters' => @$index['filters'] ?: []
                ];
                break;
              }
            endforeach;

            the_telabotanica_module('categories', [
              'modifiers' => 'layout-column-item'
            ] );

            if ( $is_category_events ) :
              ?>
              <div class="layout-column-item background-white with-shadow with-padding">
                <?php the_telabotanica_module('button', [
                  'href' => get_permalink( get_page_by_path( 'proposer-une-actualite' ) ),
                  'text' => __( 'Proposer un évènement', 'telabotanica' ),
                  'modifiers' => 'block orange'
                ] ); ?>
              </div>
              <!-- <div class="layout-column-item background-white with-shadow">
                <?php
                the_telabotanica_module('map-events');
                ?>
              </div> -->
              <?php
            else :
              ?>
              <div class="layout-column-item background-white with-shadow with-padding">
                <?php the_telabotanica_module('button', [
                  'href' => get_permalink( get_page_by_path( 'proposer-une-actualite' ) ),
                  'text' => __( 'Proposer une actualité', 'telabotanica' ),
                  'modifiers' => 'block'
                ] ); ?>
              </div>
              <?php the_telabotanica_module('newsletter', [
                'modifiers' => 'layout-column-item background-white with-shadow with-padding'
              ] ); ?>
              <?php the_telabotanica_module('upcoming-events', [
                'modifiers' => 'layout-column-item background-white with-shadow with-padding'
              ] );
            endif;

            the_telabotanica_module('search-filters', [
              'filters' => $current_index['filters']
            ]);

            the_telabotanica_module('button-top');
            ?>
          </aside>
          <div class="layout-content">
            <?php
            if ( !empty( $category ) ):
              $rss_button = sprintf(
                '<a href="%s" title="%s" rel="nofollow">%s</a>',
                get_category_feed_link( $category->cat_ID ),
                esc_attr( sprintf( __( 'Flux RSS %s', 'telabotanica' ), $category->name ) ),
                get_telabotanica_module('icon', ['icon' => 'rss', 'color' => 'orange'])
              );
            endif;
            the_telabotanica_module('breadcrumbs', ['button' => $rss_button]);

            the_telabotanica_module('list-articles');

            // Container for instantsearch hits
            echo '<div class="list-articles" id="search-hits"></div>';
            ?>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
