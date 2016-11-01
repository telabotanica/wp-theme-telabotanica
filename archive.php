<?php
/**
 * Page d'accueil
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php
      the_telabotanica_module('cover', array(
        'title' => __('Actualités', 'telabotanica'),
        'subtitle' => sprintf(
          __('Toute l\'<a href="%s">actualité</a>, les <a href="%s">offres d\'emploi</a> et les <a href="%s">évènements</a>', 'telabotanica'),
          get_category_link( get_cat_ID( 'Actualités' ) ),
          get_category_link( get_cat_ID( 'Offres d\'emploi' ) ),
          get_category_link( get_cat_ID( 'Évènements' ) )
        ),
        'image' => get_field( 'cover_image', get_queried_object() )
      )); ?>

      <div class="layout-left-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
            <?php the_telabotanica_module('categories', array()); ?>
          </aside>
          <div class="layout-content">
            <?php if ( have_posts() ) : ?>
              <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
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
              echo '<p>' . __( 'Aucune actualité dans cette catégorie.', 'telabotanica' ) . '</p>';
            endif; ?>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
