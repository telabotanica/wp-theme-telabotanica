<?php
/**
 * Template pour l'affichage des pages de texte d'eFlore
 */
 /*
Template Name: flore
*/

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php
      $pagename = get_query_var('pagename');

      // Index between page names and facet in Algolia
      $referentielsFacets = [
        'france-metropolitaine' => 'referentiels:bdtfx',
        'antilles-francaises' => 'referentiels:bdtxa',
        'afrique-du-nord' => 'referentiels:isfan',
        'afrique-tropicale' => 'referentiels:apd',
      ];

      the_telabotanica_module('cover', [
        'search' => [
          'index' => 'flore',
          'placeholder' => __('Rechercher un nom, un taxon...', 'telabotanica'),
          'instantsearch' => true,
          'facetFilters' => array_key_exists($pagename, $referentielsFacets) ? $referentielsFacets[$pagename] : false
        ]
      ]); ?>

      <div class="layout-content-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
            <?php

            $algolia_autocomplete_config = telabotanica_algolia_config()['autocomplete'];
            $current_index = 'flore';

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

            the_telabotanica_module('toc');

            the_telabotanica_module('search-filters', [
              'filters' => $current_index['filters']
            ]);

            the_telabotanica_module('button-top');
            ?>
          </aside>
          <div class="layout-content">
            <?php the_telabotanica_module('breadcrumbs'); ?>
            <article>
              <?php
              // Si la page utilise des composants
              if( have_rows('components') ):

                  // On boucle sur les composants
                  while ( have_rows('components') ) : the_row();

                    the_telabotanica_component(get_row_layout());

                  endwhile;

              else :

                  // no layouts found

              endif;

              wp_link_pages( [
                  'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
                  'after'       => '</div>',
                  'link_before' => '<span>',
                  'link_after'  => '</span>',
                  'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
                  'separator'   => '<span class="screen-reader-text">, </span>',
              ] );
              ?>
            </article>

            <!-- Container for instantsearch hits -->
            <div id="search-hits"></div>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
