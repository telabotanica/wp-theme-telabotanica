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
                <a href="#"><?php echo __( 'Retour', 'telabotanica' ); ?></a>
                <div><?php echo sprintf( __( 'Publié le %s', 'telabotanica' ), get_the_date() ); ?></div>
                <div><?php echo sprintf( __( 'Par %s', 'telabotanica' ), get_the_author() ); ?></div>
                <?php
                if ( get_the_tags() ) :
                  echo '<div>';
                  echo __( 'Tags :', 'telabotanica' );
                  the_tags();
                  echo '</div>';
                endif; ?>
              </aside>
              <div class="layout-content">
                <?php the_telabotanica_module('breadcrumbs', []); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?>>
                  <?php

                  the_title( '<h1 class="article-title">', '</h1>' );

                  if ( get_field('intro') ) :

                    the_telabotanica_component('intro', [
                      'text' => get_field('intro')
                    ]);

                  endif;

                  the_telabotanica_component('text', [
                    'text' => get_the_content()
                  ]);

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
