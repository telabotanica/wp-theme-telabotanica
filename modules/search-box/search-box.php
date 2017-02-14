<?php function telabotanica_module_search_box($data) {
	if (!isset($data->autocomplete)) $data->autocomplete = true;
	if (!isset($data->value)) $data->value = get_search_query();
	if (!isset($data->suggestions)) $data->suggestions = false;

	echo '<div class="search-box large" data-autocomplete="' . var_export($data->autocomplete, true) . '">';
		echo '<form role="search" method="get" action="' . esc_url( home_url( '/' ) ) . '" class="search-box-wrapper">';
		printf(
			'<input name="s" class="search-box-input" placeholder="%s" value="%s" />',
			__('Rechercher une plante, un projet, un mot clé...', 'telabotanica'),
			$data->value
		);
		echo '<button type="submit" class="search-box-button">' . get_telabotanica_module('icon', ['icon' => 'search']) . '</button>';
		echo '</form>';

		if ( $data->suggestions ) :
			$suggestions = array_map(function($suggestion) {
				return sprintf(
					'<a href="%s">%s</a>',
					'#' . $suggestion, // TODO compose URL to search results
					$suggestion
				);
			}, $data->suggestions);

			printf(
				'<div class="search-box-suggestions">%s</div>',
				sprintf(
					__('Par exemple : %s...', 'telabotanica'),
					implode($suggestions, ', ')
				)
			);
		endif;

	echo '</div>';
}
