<?php function telabotanica_component_title($data) {
  if (!isset($data->level)) $data->level = get_sub_field('level');
  if (!isset($data->anchor)) $data->anchor = get_sub_field('anchor');
  if (!isset($data->title)) $data->title = get_sub_field('title');

  echo '<div class="component component-title level-' . $data->level . '">';

  echo '<h' . $data->level . ' id="' . $data->anchor . '">';
  echo $data->title;
  echo '</h' . $data->level . '>';

  echo '</div>';
}
