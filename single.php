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
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                  <?php the_content(); ?>
                </article>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      <?php endif; ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
