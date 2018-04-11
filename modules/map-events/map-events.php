<?php function telabotanica_module_map_events($data) {

  $defaults = [
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('map-events', $data->modifiers);

  $url_map_events = '#'; // TODO

  printf(
    '<div class="%s">',
    implode(' ', $data->modifiers)
  );

    printf(
      '<a href="%s" class="map-events-map"><img src="%s" alt="" /></a>',
      $url_map_events,
      get_template_directory_uri() . '/modules/map-events/map.png'
    );

    echo '<div class="map-events-button">';
      the_telabotanica_module('button', [
        'href' => $url_map_events,
        'text' => __( 'Carte des évènements', 'telabotanica' ),
        'modifiers' => 'block orange'
      ] );
    echo '</div>';

  echo '</div>';

}
