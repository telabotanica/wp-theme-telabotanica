<?php function telabotanica_block_main_features($data) {
  $defaults = [
    'background_color' => function_exists('get_sub_field') ? get_sub_field('background_color') : '',
    'items' => function_exists('get_sub_field') ? get_sub_field('items') : null,
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-main-features'], $data->modifiers);

  printf(
    '<div class="%s" style="background-color: %s">',
    esc_attr(implode(' ', (array) $data->modifiers)),
    esc_attr($data->background_color ?? '')
  );

    if ( !empty($data->items) && is_array($data->items) ):

      echo '<div class="layout-wrapper">';
      echo '<ul class="block-main-features-items">';

      foreach ($data->items as $item) :

        if ( !is_array($item) && !is_object($item) ) continue;
        $item = (object) $item;

        echo '<li class="block-main-features-item">';
          if ( !empty( $item->icon ) ) :
            echo '<div class="block-main-features-item-icon">';
            echo '<img src="' . esc_url($item->icon) . '" alt="' . esc_attr(sprintf( __('Icône de %s', 'telabotanica'), $item->title ?? '' )) . '" class="style-svg" />';
            echo '</div>';
          endif;
          echo '<h3 class="block-main-features-item-title">' . ($item->title ?? '') . '</h3>';
          echo '<div class="block-main-features-item-description">' . ($item->text ?? '') . '</div>';
        echo '</li>';

      endforeach;

      echo '</ul>';
      echo '</div>';

    endif;

  echo '</div>';
}
