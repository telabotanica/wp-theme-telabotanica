<?php function telabotanica_module_search_filters($data) {
	$defaults = [
		'filters' => [],
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('search-filters', $data->modifiers);

	printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);
		the_telabotanica_module('title', [
			'title' => __('Filtrer les résultats', 'telabotanica'),
			'level' => 2,
			'modifiers' => ['search-filters-title', 'with-border-bottom']
		]);
		echo '<ul class="search-filters-items" id="search-filters">';

			foreach ($data->filters as $id => $filter) {
				printf( '<li class="search-filters-item" id="search-filter-%s"></li>',
					$id
				);
			}

		echo '</ul>';
	echo '</div>';
}
