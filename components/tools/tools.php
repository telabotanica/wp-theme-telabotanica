<?php function telabotanica_component_tools($data) {

  $defaults = [
    'items' => get_sub_field('items'),
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-tools'], $data->modifiers);

  echo '<div class="' . implode(' ', $data->modifiers) . '">';

  if ( $data->items ) :

      echo '<ul class="component-tools-items">';

      foreach ($data->items as $item) :

        // Tableau d'objets Outil
        if (gettype($item) === 'object' && get_class($item) === 'WP_Post') :

          $item->title = $item->post_title;

          $fields = (object) get_fields($item->ID);
          $fields = $fields ?: (object) [];
          $item->description = isset($fields->short_description) ? $fields->short_description : '';
          // affiche en gras l'abbréviation
          if (isset($fields->abbr)) $item->description = str_replace($fields->abbr, '<strong>' . $fields->abbr . '</strong>', $item->description);
          $item->color = isset($fields->color) ? $fields->color : '#666';
          $item->icon = isset($fields->icon) && !empty($fields->icon) ? $fields->icon : get_template_directory_uri() . '/components/tools/default-icon.svg';
          $item->link_text = isset($fields->link_text) ? $fields->link_text : __('Accéder à cet outil', 'telabotanica');

          if (
            isset($fields->has_page)
            && $fields->has_page === false
            && isset($fields->redirect)
            && is_array($fields->redirect)
          ) {
            $item->link = $fields->redirect['url'] ?? '';
            $item->link_target = $fields->redirect['target'] ?? '';
          } else {
            $item->link = get_permalink($item);
            $item->link_target = '';
          }

        // Tableau simple
        elseif (gettype($item) === 'array') :

          $item = (object) $item;
          if (!isset($item->icon)) $item->icon = get_template_directory_uri() . '/components/tools/default-icon.svg';
          if (!isset($item->link_target)) $item->link_target = '';

        endif;

        // affiche en gras le nom
        $item->description = str_replace($item->title, '<strong>' . $item->title . '</strong>', $item->description);

        echo '<li class="component-tools-item">';
          echo '<a href="' . $item->link . ($item->link_target ? "\" target=\"$item->link_target" : "") . '" class="component-tools-item-icon" style="color: ' . $item->color . '">';
          if ($item->icon) echo '<img src="' . $item->icon . '" alt="' . sprintf( __('Icône de %s', 'telabotanica'), $item->title ) . '" class="style-svg" />';
          echo '</a>';
          echo '<h4 class="component-tools-item-title"><a href="' . $item->link . ($item->link_target ? "\" target=\"$item->link_target" : "") . '">' . $item->title . '</a></h4>';
          echo '<div class="component-tools-item-description">' . $item->description . '</div>';
          echo '<div class="component-tools-item-link"><a href="' . $item->link . ($item->link_target ? "\" target=\"$item->link_target" : "") . '" style="color: ' . $item->color . '"><span>' . $item->link_text . '</span></a></div>';
        echo '</li>';

      endforeach;

      echo '</ul>';

  endif;

  echo '</div>';
}
