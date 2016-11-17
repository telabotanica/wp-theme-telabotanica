<?php function telabotanica_component_buttons($data) {
  if (!isset($data->items)) $data->items = get_sub_field('items');
  if (!isset($data->display)) $data->display = get_sub_field('display');
  if (empty($data->display)) $data->display = 'buttons';

  $data->modifiers = [ 'component', 'component-buttons' ];
  if ( $data->display === 'links' ) {
    $data->modifiers[] = 'as-links';
  }

  echo '<div class="' . implode($data->modifiers, ' ') . '">';

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
        $item->modifiers = [ get_sub_field('modifiers') ];
        if (empty($data->modifiers)) $data->modifiers = [];
      } else {
        $item->modifiers = [ $item->modifiers ];
      }

      if ( $data->display === 'links' ) {
        $item->modifiers[] = 'link';
      }

      the_telabotanica_module('button', $item);

    endforeach;

  endif;

  echo '</div>';
}
