<?php function telabotanica_module_block_dashboard($data) {
	$defaults = [
		'title' => [],
		'message' => false,
		'modifiers' => [],
		'is_empty' => false
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('block-dashboard', $data->modifiers);

	if ( $data->is_empty === true ) :
		$data->modifiers[] = 'is-empty';
	endif;

	printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
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
