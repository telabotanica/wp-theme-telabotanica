<?php
/**
 * Page
 */

if (bp_is_group_create()) {
	// Force a small header (without use cases navigation) on group creation pages
	$header_small = true;
}

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

      <?php if ( have_posts() ) :
        while ( have_posts() ) : the_post();

          /*if ( !(
            bp_is_group() ||
            bp_is_groups_directory()
          ) ) :
            the_title( '<h1>', '</h1>' );
          endif;*/

      		the_content();

        endwhile;
      endif; ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php
	$footer_newsletter_no_subscription = bp_is_register_page();
	get_footer();
?>
