<?php

$search_query = get_search_query();
$search_query = sanitize_text_field($search_query);
$search_query = str_replace(" ", "%20", $search_query);

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

// Force a small header (without use cases navigation)
$header_small = true;
get_header();

?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main">

      <?php
      // WordPress standard search results
      the_telabotanica_module('cover-search');
      ?>

      <div class="layout-central-col is-wide adjacent-top">
        <div class="layout-wrapper">
          <div class="layout-content">
            <?php
            if ( have_posts() ) :
              while ( have_posts() ) :
                the_post();
                the_telabotanica_module('list-articles-item', [
                  'post_id' => get_the_ID(),
                  'title' => get_the_title(),
                  'excerpt' => get_the_excerpt(),
                  'url' => get_permalink(),
                  'date' => get_the_date('U')
                ]);
              endwhile;
              the_posts_pagination();
            else :
              ?>
              <p><?php _e('No results found.', 'telabotanica'); ?></p>
              <?php
            endif;
            ?>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
