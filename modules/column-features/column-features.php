<?php function telabotanica_module_column_features($data) {

  $defaults = [
    'items' => [],
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('column-features', $data->modifiers);

  echo '<div class="' . implode(' ', $data->modifiers) . '">';

    echo '<ul class="column-features-items">';

    if ( !empty($data->items) ) :

      foreach ($data->items as $item) :

        $item = (object) $item;
        $item->link = (isset($item->link) && is_array($item->link)) ? $item->link : [];

        echo '<li class="column-features-item">';

          printf(
            ($item->link['target']
              ? '<a href="%s" title="%s" target="%s" class="column-features-item-link">'
              : '<a href="%s" title="%s" class="column-features-item-link">'
            ),
            esc_url( $item->link['url'] ?? '#' ),
            $item->link['title'] ?? '',
            $item->link['target'] ?? ''
          );

            if ( $item->icon ) {
              printf(
                '<div class="column-features-item-icon" style="color: %s; fill: %s">%s</div>',
                $item->color,
                $item->color,
                '<img src="' . $item->icon . '" alt="" class="style-svg" />'
              );
            }

            printf(
              '<h3 class="column-features-item-title"><span>%s</span></h3>',
              $item->title
            );

            printf(
              '<div class="column-features-item-text">%s</div>',
              wp_trim_words( $item->text, 18 )
            );

          echo '</a>';

        echo '</li>';
      endforeach;

    endif;

    echo '</ul>';
  echo '</div>';
}
