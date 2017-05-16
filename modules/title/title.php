<?php function telabotanica_module_title($data) {

	$defaults = [
		'title' => 'Titre',
		'level' => 1,
		'suffix' => false,
		'href' => false,
		'target' => false,
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('title', $data->modifiers);

	if ( $data->suffix ) :
		$data->title .= sprintf( '<span class="title-suffix">%s</span>', $data->suffix );
	endif;

	if ( $data->href ) :
		$data->title = sprintf(
			'<a href="%s" target="%s">%s</a>',
			$data->href,
			$data->target,
			$data->title
		);
	endif;

	printf(
		'<h%s class="%s">%s</h%s>',
		$data->level,
		implode(' ', $data->modifiers),
		$data->title,
		$data->level
	);

}
