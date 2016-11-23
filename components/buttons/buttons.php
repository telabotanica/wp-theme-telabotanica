<?php function telabotanica_component_buttons($data) {
  if (!isset($data->items)) $data->items = get_sub_field('items');
  if (!isset($data->display)) $data->display = get_sub_field('display');
  if (empty($data->display)) $data->display = 'buttons';

  $data->modifiers = [ 'component', 'component-buttons' ];
  if ( $data->display === 'links' || ( is_array( $data->display ) && in_array('links', $data->display) ) ) $data->modifiers[] = 'as-links';
  if ( $data->display === 'seamless' || ( is_array( $data->display ) && in_array('seamless', $data->display) ) ) $data->modifiers[] = 'as-seamless';

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

      if ( in_array('as-links', $data->modifiers ) ) {
        $item->modifiers[] = 'link';
      }

      the_telabotanica_module('button', $item);

    endforeach;

  endif;

  echo '</div>';
}
