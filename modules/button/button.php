<?php function telabotanica_module_button($data) {
  if (!isset($data->href)) $data->href = '#';
  if (!isset($data->modifiers)) $data->modifiers = [];
  if (!isset($data->target)) $data->target = '';
  if (!isset($data->text)) $data->text = 'Bouton';
  if (!isset($data->title)) $data->title = '';
  if (!isset($data->icon_before)) $data->icon_before = false;
  if (!isset($data->icon_after)) $data->icon_after = false;

  if ( !empty($data->modifiers) && !is_array($data->modifiers) ) $data->modifiers = explode(' ', $data->modifiers);

  if ( $data->modifiers && in_array('back', $data->modifiers) ) $data->icon_before = 'arrow-left';

  echo sprintf(
    '<a href="%s" class="button %s" target="%s" title="%s">%s<span class="button-text">%s<span>%s</a>',
    $data->href,
    is_array($data->modifiers) ? implode($data->modifiers, ' ') : $data->modifiers,
    $data->target,
    $data->title,
    $data->icon_before ? get_telabotanica_module('icon', ['icon' => $data->icon_before]) : '',
    $data->text,
    $data->icon_after ? get_telabotanica_module('icon', ['icon' => $data->icon_after]) : ''
  );
}
