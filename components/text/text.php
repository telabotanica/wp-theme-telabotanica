<?php function telabotanica_component_text($data) {
  if (!isset($data->text)) $data->text = get_sub_field('text');

  echo '<div class="component component-text">';

  echo $data->text;

  echo '</div>';
}
