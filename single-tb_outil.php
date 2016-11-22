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

      <?php
      $cover_buttons = get_field('cover_buttons');

      if ( $cover_buttons ) :
        $cover_buttons['display'] = 'seamless';
        $cover_content = get_telabotanica_component( 'buttons', $cover_buttons );
      endif;

      the_telabotanica_module('cover', [
        'content' => $cover_content,
        'modifiers' => 'tall'
      ]); ?>

      <div class="layout-full-width">
        <div class="layout-wrapper">
          <p>TODO</p>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
