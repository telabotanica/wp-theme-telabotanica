<?php function telabotanica_component_button($data) {
  if (!isset($data->href)) {
    $link = get_sub_field('link');
    $data->href = $link['url'];
    $data->target = $link['target'];
    $data->title = $link['title'];
  }
  if (!isset($data->text)) $data->text = get_sub_field('text');

  echo '<div class="component component-button">';

  the_telabotanica_module('button', $data);

  echo '</div>';
}
