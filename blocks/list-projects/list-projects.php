<?php function telabotanica_block_list_projects($data) {
  $category = function_exists('get_sub_field') ? get_sub_field('category') : null;
  $group_type = ( is_object($category) && isset($category->name) ) ? $category->name : ( is_array($category) && isset($category['name']) ? $category['name'] : '' );

  $defaults = [
    'background_color' => function_exists('get_sub_field') ? get_sub_field('background_color') : '',
    'query' => [
      'type' => 'random',
      'group_type' => $group_type,
      'max' => 4
    ],
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-list-projects'], $data->modifiers);

  printf(
    '<div class="%s" style="background-color: %s">',
    implode(' ', $data->modifiers),
    $data->background_color
  );

    echo '<div class="layout-wrapper">';
      echo '<div class="block-list-projects-items">';

      if ( function_exists('bp_has_groups') && function_exists('bp_groups') && function_exists('bp_the_group') && bp_has_groups($data->query) ) :

        while ( bp_groups() ) : bp_the_group();

          the_telabotanica_module('card-project', [
            'meta' => false,
            'modifiers' => 'with-large-cover'
          ]);

        endwhile;

      endif;

      echo '</div>';
    echo '</div>';

  echo '</div>';
}
