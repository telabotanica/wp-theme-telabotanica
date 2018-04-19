<?php function telabotanica_module_nav_dashboard($data) {
  $defaults = [
    'items' => [],
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('nav-dashboard', $data->modifiers);

  printf(
    '<div class="%s">',
    implode(' ', $data->modifiers)
  );

    echo '<ul class="nav-dashboard-items">';

    $item_defaults = [
      'modifiers' => []
    ];

    foreach ( $data->items as $item ) :

      $item = telabotanica_styleguide_data($item_defaults, $item);
      $item->modifiers = telabotanica_styleguide_modifiers_array('nav-dashboard-item', $item->modifiers);

      if ( isset( $item->current ) && $item->current === true ) {
        $item->modifiers[] = 'is-current';
      }
      if ( isset( $item->dot ) && $item->dot === true ) {
        $item->modifiers[] = 'with-dot';
      }

      printf(
        '<li class="%s">',
        implode(' ', $item->modifiers)
      );
        printf(
          '<a href="%s">%s<span class="nav-dashboard-item-text">%s</span></a>',
          $item->href,
          get_telabotanica_module('icon', ['icon' => $item->icon]),
          $item->text
        );
      echo '</li>';

    endforeach;

    echo '</ul>';
  echo '</div>';

}
