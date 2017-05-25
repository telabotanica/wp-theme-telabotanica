<?php function telabotanica_module_block_dashboard($data) {
	$defaults = [
		'title' => [],
		'message' => false,
		'modifiers' => [],
		'html_content' => '',
		'extra_attributes' => [],
		'is_empty' => false
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('block-dashboard', $data->modifiers);

	if ( $data->is_empty === true ) :
		$data->modifiers[] = 'is-empty';
	endif;

	$extra_attributes = '';
	foreach ($data->extra_attributes as $name => $value) {
		$extra_attributes .= sprintf('%s="%s" ', $name, $value);
	}

	printf(
		'<div class="%s" %s>',
		implode(' ', $data->modifiers),
		$extra_attributes
	);

		$data->title['level'] = 2;
		the_telabotanica_module('title', $data->title);

		echo '<div class="block-dashboard-content">';

		if ( $data->is_empty === true ) :

			the_telabotanica_module('icon', [
				'icon' => $data->empty['icon']
			]);

			printf(
				'<div class="block-dashboard-empty-text">%s</div>',
				$data->empty['text']
			);

			the_telabotanica_module('button', $data->empty['button']);

		else :

			if ( $data->html_content ) {
				echo $data->html_content;
			}

			echo '<div class="block-dashboard-footer">';

				if ( $data->button ) {
					the_telabotanica_module('button', $data->button);
				}

			echo '</div>';

		endif;

		echo '</div>';

	echo '</div>';

}
