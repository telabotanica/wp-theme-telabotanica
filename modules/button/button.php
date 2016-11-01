<?php function telabotanica_module_button($data) {
  if (!isset($data->href)) $data->href = '#';
  if (!isset($data->modifiers)) $data->modifiers = '';
  if (!isset($data->target)) $data->target = '';
  if (!isset($data->text)) $data->text = 'Bouton';
  if (!isset($data->title)) $data->title = '';

  echo '<a href="' . $data->href . '" class="button ' . $data->modifiers . '" target="' . $data->target . '" title="' . $data->title . '">' . $data->text . '</a>';
}
