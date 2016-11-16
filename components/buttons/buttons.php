<?php function telabotanica_component_buttons($data) {
  if (!isset($data->items)) $data->items = get_sub_field('items');

  echo '<div class="component component-buttons">';

  if ( $data->items ):

    foreach ($data->items as $item) :

      $item = (object) $item;

      if (!isset($item->href)) {
        $item->href = $item->link['url'];
        $item->target = $item->link['target'];
        $item->title = $item->link['title'];
        unset($item->link);
      }
      if (!isset($item->text)) $item->text = get_sub_field('text');
      if (!isset($item->modifiers)) {
        $item->modifiers = get_sub_field('modifiers');
      }

      the_telabotanica_module('button', $item);

    endforeach;

  endif;

  echo '</div>';
}
