<?php function telabotanica_component_intro($data) {
  if (!isset($data->text)) $data->text = get_sub_field('intro');

  echo '<div class="component component-intro">';

  echo $data->text;

  echo '</div>';
}
