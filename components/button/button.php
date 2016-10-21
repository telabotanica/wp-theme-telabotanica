<?php function telabotanica_component_button($data) {
  if (!isset($data->href)) $data->href = get_sub_field('internal_link');
  if (!isset($data->text)) $data->text = get_sub_field('text');

  echo '<div class="component component-button">';

  the_telabotanica_module('button', $data);

  echo '</div>';
}
