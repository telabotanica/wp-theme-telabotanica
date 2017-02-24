<?php function telabotanica_module_button($data) {

	$defaults = [
		'href' => '#',
		'target' => '',
		'text' => 'Bouton',
		'title' => '',
		'icon_before' => false,
		'icon_after' => false,
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('button', $data->modifiers);

  if ( $data->modifiers && in_array('back', $data->modifiers) ) $data->icon_before = 'arrow-left';

  echo sprintf(
    '<a href="%s" class="%s" target="%s" title="%s">%s<span class="button-text">%s<span>%s</a>',
    $data->href,
    implode($data->modifiers, ' '),
    $data->target,
    $data->title,
    $data->icon_before ? get_telabotanica_module('icon', ['icon' => $data->icon_before]) : '',
    $data->text,
    $data->icon_after ? get_telabotanica_module('icon', ['icon' => $data->icon_after]) : ''
  );
}
