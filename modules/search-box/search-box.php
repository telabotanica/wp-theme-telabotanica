<?php function telabotanica_module_search_box($data) {
	echo '<div class="search-box large">';
		echo '<div class="search-box-wrapper">';
		printf(
			'<input name="s" class="search-box-input" placeholder="%s" />',
			__('Rechercher une plante, un projet, un mot clé...', 'telabotanica')
		);
		echo '<button type="submit" class="search-box-button">' . get_telabotanica_module('icon', ['icon' => 'search']) . '</button>';
		echo '</div>';

		$suggestions = ['coquelicot', 'quercus ilex', 'végétation', 'mooc'];

		$suggestions = array_map(function($suggestion) {
			return sprintf(
				'<a href="%s">%s</a>',
				'#' . $suggestion,
				$suggestion
			);
		}, $suggestions);

		printf(
			'<div class="search-box-suggestions">%s</div>',
			sprintf(
				__('Par exemple : %s...', 'telabotanica'),
				implode($suggestions, ', ')
			)
		);
	echo '</div>';
}
