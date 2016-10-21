<?php function telabotanica_component_tools($data) {
  if (!isset($data->items)) $data->items = get_sub_field('tools');

  echo '<div class="component component-tools">';

  if ( $data->items ):

      echo '<ul class="component-tools-items">';

      foreach ($data->items as $item) :

        $item = (object) $item;

        echo '<li class="component-tools-item">';
        echo '<div class="component-tools-item-icon"></div>';
        echo '<h4 class="component-tools-item-title">' . $item->title . '</h4>';
        echo '<div class="component-tools-item-description">' . $item->description . '</div>';
        echo '<div class="component-tools-item-link"><a href="' . $item->link . '">' . $item->link_text . ' &rsaquo;</a></div>';
        echo '</li>';

      endforeach;

      echo '</ul>';

  endif;

  echo '</div>';
}
