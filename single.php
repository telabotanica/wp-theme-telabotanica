<?php
/**
 * Post
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php if ( have_posts() ) : ?>
        <div class="layout-central-col">
          <div class="layout-wrapper">
            <?php while ( have_posts() ) : the_post(); ?>
              <aside class="layout-aside">
                <?php the_telabotanica_module('meta-news'); ?>
              </aside>
              <div class="layout-content">
                <?php the_telabotanica_module('breadcrumbs'); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?>>
                  <?php

                  the_title( '<h1 class="article-title">', '</h1>' );

                  if ( get_field('intro') ) :

                    the_telabotanica_component('intro', [
                      'text' => get_field('intro')
                    ]);

                  endif;

                  if ( get_field('description') ) :

                    the_telabotanica_component('text', [
                      'text' => get_field('description')
                    ]);

                  endif;

                  if ( !empty( get_the_content() ) ) :

                    the_telabotanica_component('text', [
                      'text' => apply_filters('the_content', get_the_content())
                    ]);

                  endif;

                  // Si la page utilise des composants
                  if( have_rows('components') ):

                      // On boucle sur les composants
                      while ( have_rows('components') ) : the_row();

                        the_telabotanica_component(get_row_layout(), []);

                      endwhile;

                  else :

                      // no layouts found

                  endif;
                  ?>
                </article>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      <?php endif; ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
