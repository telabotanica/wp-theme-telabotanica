<?php function telabotanica_component_tools($data) {
  if (!isset($data->items)) $data->items = get_sub_field('items');

  echo '<div class="component component-tools">';

  if ( $data->items ):

      echo '<ul class="component-tools-items">';

      foreach ($data->items as $item) :

        $item = (object) $item;

        $link = get_permalink($item);
        $name = $item->post_title;

        $fields = (object) get_fields($item->ID);
        // affiche en gras le nom et l'abbréviation
        $fields->short_description = str_replace($name, '<strong>' . $name . '</strong>', $fields->short_description);
        $fields->short_description = str_replace($fields->abbr, '<strong>' . $fields->abbr . '</strong>', $fields->short_description);

        echo '<li class="component-tools-item">';
          echo '<a href="' . $link . '" class="component-tools-item-icon" style="color: ' . $fields->color . '"><img src="' . $fields->icon . '" alt="Icône de ' . $name . '" class="style-svg" /></a>';
          echo '<h4 class="component-tools-item-title"><a href="' . $link . '">' . $name . '</a></h4>';
          echo '<div class="component-tools-item-description">' . $fields->short_description . '</div>';
          echo '<div class="component-tools-item-link"><a href="' . $link . '" style="color: ' . $fields->color . '">' . $fields->link_text . ' &rsaquo;</a></div>';
        echo '</li>';

      endforeach;

      echo '</ul>';

  endif;

  echo '</div>';
}
