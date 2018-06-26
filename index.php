<?php
// Are we searching in a specific index?
$current_index = sanitize_key( get_query_var( 'in', false ) );

// Redirect some indices to the category or page, while preserving the query
switch ($current_index) {
  case 'actualites':
    $redirect_url = get_category_link( get_category_by_slug( 'actualites' ) );
    break;

  case 'evenements':
    $redirect_url = get_category_link( get_category_by_slug( 'evenements' ) );
    break;

  case 'projets':
    $redirect_url = get_permalink( get_option('bp-pages')['groups'] );
    break;
}

if ( isset($redirect_url) ) {
  wp_redirect( $redirect_url . '?q=' . $search_query );
  exit;
}

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
