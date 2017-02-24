<?php function telabotanica_component_title($data) {

	$defaults = [
		'level' => get_sub_field('level'),
		'anchor' => get_sub_field('anchor'),
		'title' => get_sub_field('title'),
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-title'], $data->modifiers);

	$modifiers[] = 'level-' . $data->level;

	echo '<div class="' . implode(' ', $data->modifiers) . '">';

		printf(
			'<h%s id="%s">%s</h%s>',
			$data->level,
			$data->anchor,
			$data->title,
			$data->level
		);

	echo '</div>';
}
