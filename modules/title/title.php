<?php function telabotanica_module_title($data) {

	$defaults = [
		'title' => 'Titre',
		'level' => 1,
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('title', $data->modifiers);

	printf(
		'<h%s class="%s">%s</h%s>',
		$data->level,
		implode(' ', $data->modifiers),
		$data->title,
		$data->level
	);

}
