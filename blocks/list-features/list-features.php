<?php function telabotanica_block_list_features($data) {
  $defaults = [
    'background_color' => get_sub_field('background_color'),
    'title' => get_sub_field('title'),
    'items' => get_sub_field('items'),
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-list-features'], $data->modifiers);

  printf(
    '<div class="%s" style="background-color: %s">',
    implode(' ', $data->modifiers),
    $data->background_color
  );

    echo '<h2 class="block-list-features-title">' . $data->title . '</h2>';

    if ( $data->items ):

      echo '<div class="layout-wrapper">';
      echo '<ul class="block-list-features-items">';

      foreach ($data->items as $item) :

        $item = (object) $item;

        echo '<li class="block-list-features-item">';
          if ( isset( $item->icon ) && !empty( $item->icon ) ) :
            echo '<div class="block-list-features-item-icon" style="color: ' . $item->color . '">';
            echo '<img src="' . $item->icon . '" alt="' . sprintf( __('Icône de %s', 'telabotanica'), $item->title ) . '" class="style-svg" />';
            echo '</div>';
          endif;
          echo '<h3 class="block-list-features-item-title">' . $item->title . '</h3>';
          echo '<div class="block-list-features-item-description">' . $item->text . '</div>';
        echo '</li>';

      endforeach;

      echo '</ul>';
      echo '</div>';

    endif;

  echo '</div>';
}
