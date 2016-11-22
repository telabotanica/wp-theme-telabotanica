<?php
/**
 * Page
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php if ( have_posts() ) :
        while ( have_posts() ) : the_post();

          if ( !(
            bp_is_group() ||
            bp_is_groups_directory()
          ) ) :
            the_title( '<h1>', '</h1>' );
          endif;

      		the_content();

        endwhile;
      endif; ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
