<?php function telabotanica_module_button($data) {
  if (!isset($data->href)) $data->href = '#';
  if (!isset($data->modifiers)) $data->modifiers = '';
  if (!isset($data->target)) $data->target = '';
  if (!isset($data->text)) $data->text = 'Bouton';
  if (!isset($data->title)) $data->title = '';

  if ( is_array($data->modifiers) ) $data->modifiers = implode($data->modifiers, ' ');

  echo sprintf(
    '<a href="%s" class="button %s" target="%s" title="%s">%s</a>',
    $data->href,
    $data->modifiers,
    $data->target,
    $data->title,
    $data->text
  );
}
