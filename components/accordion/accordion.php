<?php function telabotanica_component_accordion($data) {
  if (!isset($data->title_level)) $data->title_level = get_sub_field('title_level');
  if (!isset($data->items)) $data->items = get_sub_field('items');

  echo '<div class="component component-accordion js-accordion" data-accordion-prefix-classes="component-accordion">';

  if ( $data->items ):

      foreach ($data->items as $item) :

        echo '<div class="js-accordion__panel component-accordion__panel">';

        $item = (object) $item;

        echo sprintf(
          '<h%s class="js-accordion__header component-accordion__header">%s</h%s>',
          $data->title_level,
          $item->title,
          $data->title_level
        );

        echo $item->content;

        echo '</div>';

      endforeach;

  endif;

  echo '</div>';
}
