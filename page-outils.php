<?php
/**
 * Page
 */

get_header();

$taxonomy_name = 'tb_outils_category';
$tools_categories = get_terms( [
  'taxonomy'   => $taxonomy_name,
  'hide_empty' => false,
  'fields'     => 'all',
  'parent'     => 0
] );

function tools_category($term) {
  global $taxonomy_name;

  the_telabotanica_component( 'title', [
    "level" => $term->parent === 0 ? 2 : 3,
    "anchor" => $term->slug,
    "title" => $term->name
  ] );

  if ( !empty( $term->description ) ) {
    the_telabotanica_component( 'text', [
      "text" => sprintf( "<p>%s</p>", $term->description )
    ] );
  }

  $tools = get_posts( [
    'post_type' => 'tb_outil',
    'tax_query' => [
      [
        'taxonomy' => $taxonomy_name,
        'field' => 'term_id',
        'terms' => $term->term_id,
        'include_children' => false
      ]
    ],
    'orderby' => 'menu_order',
    'sort_order' => 'asc',
    'numberposts' => -1
  ] );
  the_telabotanica_component('tools', [
    'items' => $tools
  ] );

}

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php the_telabotanica_module('cover', []); ?>

      <div class="layout-left-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
            <?php the_telabotanica_module('toc', [
              'items' => [
                [ 'items' => $tools_categories ]
              ]
            ] ); ?>
          </aside>
          <div class="layout-content">
            <?php the_telabotanica_module('breadcrumbs', []); ?>
            <article class="article">
              <?php
              // Si la page utilise des composants
              if( have_rows('components') ):

                  // On boucle sur les composants
                  while ( have_rows('components') ) : the_row();

                    the_telabotanica_component(get_row_layout(), []);

                  endwhile;

              else :

                  // no layouts found

              endif;

              foreach ( $tools_categories as $term ) :

                tools_category($term);

                foreach ( get_term_children( $term->term_id, $taxonomy_name ) as $child ) :
                  $term_child = get_term_by( 'id', $child, $taxonomy_name );
                  tools_category($term_child);
                endforeach;

              endforeach;

              ?>
            </article>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
