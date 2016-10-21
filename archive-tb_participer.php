<?php
/**
 * Page d'accueil
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php the_telabotanica_module('cover', array(
        'titre' => __('Comment participer ?', 'telabotanica'),
      )); ?>

      <div class="layout-left-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
          </aside>
          <div class="layout-content">
            <?php if ( have_posts() ) : ?>
              <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
                  <?php the_excerpt(); ?>
                </article>
              <?php endwhile;

              the_posts_pagination( array(
        				'prev_text'          => __( 'Page précédente', 'telabotanica' ),
        				'next_text'          => __( 'Page suivante', 'telabotanica' ),
        				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'telabotanica' ) . ' </span>',
        			) );
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
