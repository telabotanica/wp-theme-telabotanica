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

  if($is_category_events) :
    // order events by event-date
    // TODO : find out what to do whith obsolete events
    $sort_events = new WP_Query(array(
      'post_type'     => 'post',
      'meta_key'      => 'date',
      'orderby'     => 'meta_value',
      'order'       => 'DESC'
    ));

    if ( $sort_events->have_posts() ) :
      while ( $sort_events->have_posts() ) : $sort_events->the_post();
        if(get_post_status(get_the_ID()) === 'publish') :
          the_telabotanica_module('list-articles-item');
        endif;
      endwhile;

      the_telabotanica_module('pagination');
    else :
      echo '<p>' . __( 'Aucun évènement.', 'telabotanica' ) . '</p>';
    endif;

    wp_reset_query();

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
