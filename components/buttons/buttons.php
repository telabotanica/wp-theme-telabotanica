<?php function telabotanica_component_buttons($data) {
  if (!isset($data->items)) $data->items = get_sub_field('items');

  echo '<div class="component component-buttons">';

  if ( $data->items ):

    foreach ($data->items as $item) :

      $item = (object) $item;

      if (!isset($item->href)) {
        $link = get_sub_field('link');
        $item->href = $link['url'];
        $item->target = $link['target'];
        $item->title = $link['title'];
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
