<?php
/**
 * Page Outil
 */

$fields = (object) get_fields( get_the_ID() );

// Si une redirection est définie, la suivre
if ( isset($fields->has_page) && $fields->has_page === false
  && isset($fields->redirect) ) {
  wp_redirect( $fields->redirect['url'] );
  exit;
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php the_telabotanica_module('cover', array()); ?>

      <div class="layout-left-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
          </aside>
          <div class="layout-content">
            <p>TODO</p>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
