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

  if ( have_posts() ) :
    while ( have_posts() ) : the_post();
      the_telabotanica_module('list-articles-item');
    endwhile;

    the_telabotanica_module('pagination');
  else :
    echo '<p>' . __( 'Aucune actualité dans cette catégorie.', 'telabotanica' ) . '</p>';
  endif;

  echo '</div>';

}
