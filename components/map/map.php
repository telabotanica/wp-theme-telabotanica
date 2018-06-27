<?php function telabotanica_component_map($data) {
  $defaults = [
    'place' => get_field('place'),
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-map'], $data->modifiers);

  if ($data->place) {
    printf(
      '<div class="%s"%s>',
      implode(' ', $data->modifiers),
      $data->place ? ' data-center="' . esc_attr( json_encode($data->place->latlng) ) . '"' : ''
    );

      echo '<div class="component-map-map"></div>';

    echo '</div>';
  }
}
