<?php
/**
 * Toutes les thématiques
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php the_telabotanica_module('cover', [
        'title' => __('Toutes les thématiques', 'telabotanica'),
      ] ); ?>

      <div class="layout-content-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
            <?php the_telabotanica_module('button-top'); ?>
          </aside>
          <div class="layout-content">
            <?php
						$breadcrumbs_items = [ 'home' ];

						$breadcrumbs_items[] = [ 'text' => __('Thématiques', 'telabotanica') ];

						the_telabotanica_module('breadcrumbs', [
							'items' => $breadcrumbs_items
						]);

						if ( have_posts() ) : ?>
              <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <?php
									the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
									the_excerpt();
									?>
                </article>
              <?php endwhile;

              the_posts_pagination( [
        				'prev_text'          => __( 'Page précédente', 'telabotanica' ),
        				'next_text'          => __( 'Page suivante', 'telabotanica' ),
        				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'telabotanica' ) . ' </span>',
        			] );
              ?>
            <?php else :
              echo '<p>' . __( 'Aucun moyen de participer.', 'telabotanica' ) . '</p>';
            endif; ?>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
