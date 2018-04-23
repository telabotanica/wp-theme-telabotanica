<?php function telabotanica_component_buttons($data) {

  $defaults = [
    'items' => get_sub_field('items'),
    'display' => get_sub_field('display'),
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-buttons'], $data->modifiers);

  if (empty($data->display)) $data->display = 'buttons';

  if ( $data->display === 'links' || ( is_array( $data->display ) && in_array('links', $data->display) ) ) $data->modifiers[] = 'as-links';

  echo '<div class="' . implode(' ', $data->modifiers) . '">';

  if ( $data->items ):

    foreach ($data->items as $item) :

      $item = (object) $item;

      if (!isset($item->href)) {
        $item->href = $item->link['url'];
        if (array_key_exists('target', $item->link)) $item->target = $item->link['target'];
        if (array_key_exists('title', $item->link)) $item->title = $item->link['title'];
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
