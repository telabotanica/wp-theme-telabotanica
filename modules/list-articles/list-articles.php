<?php function telabotanica_module_list_articles($data) {
  $defaults = [
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('list-articles', $data->modifiers);

  $category = get_category( get_query_var('cat') );
  $category_evenements = get_category_by_slug( 'evenements' );
  $is_category_events = is_category( $category_evenements ) || cat_is_ancestor_of( $category_evenements, $category );
  if ($is_category_events) $data->modifiers[] = 'only-events';

  printf(
    '<div class="%s">',
    implode(' ', $data->modifiers)
  );

  // When displaying events have_posts() loop, order events by event-date
  if($is_category_events) :

    $paged = get_query_var( 'paged' );

    // TODO : pagination is incorrectly synchronized with $sort_events WP_Query for now,
    // if ever post_per_page is set to less than 10 (default value), pagination could malfunction :
    // pagination shows the right number of pages, but beyond initial page count (with default values) page links return 404
    $args = array(
      'meta_query' => [
        [
          'key' => 'date',
          'compare' => '>',
          'value' => date('Ymd'),
          'type' => 'DATE'
        ]
      ],
      'orderby' => 'meta_value_num',
      'meta_key' => 'date',
      'order' => 'ASC',
    );

    // Running WP_Query to get 'found_posts' and 'posts_per_page' values
    $query = new WP_Query($args);
    wp_reset_postdata();
    wp_reset_query();
    $args['max_num_pages'] = (int) ceil($query->found_posts / $query->query_vars['posts_per_page']);
    $args['paged'] = $paged;
    $args['is_paged'] = true;

    // Making $sort_events query global to get the 'max_num_pages' and assign it to the_posts_pagination(['total')) in pagination.php
    global $sort_events;

    // Running $sort_events WP_Query with all datas needed for the have_posts() loop
    $sort_events = new WP_Query($args);
    if ( $sort_events->have_posts() ) :
      while ( $sort_events->have_posts() ) : $sort_events->the_post();
        if(get_post_status(get_the_ID()) === 'publish') :
          the_telabotanica_module('list-articles-item');
        endif;
      endwhile;

      the_telabotanica_module('pagination');

      wp_reset_postdata();
      wp_reset_query();

    else :
      echo '<p>' . __( 'Aucun évènement.', 'telabotanica' ) . '</p>';
    endif;

  elseif ( have_posts() ) :
    while ( have_posts() ) : the_post();
      if(get_post_status(get_the_ID()) === 'publish') :
        the_telabotanica_module('list-articles-item');
      endif;
    endwhile;

    the_telabotanica_module('pagination');
  else :
    echo '<p>' . __( 'Aucune actualité dans cette catégorie.', 'telabotanica' ) . '</p>';
  endif;

  echo '</div>';

}
