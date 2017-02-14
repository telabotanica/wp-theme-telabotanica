<?php
// Force a small header (without use cases navigation)
$header_small = true;
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
      the_telabotanica_module('cover-search');
			?>

      <article class="article">

        SEARCH

      </article>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
