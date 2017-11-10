<?php function telabotanica_module_categories_labels($data) {
	global $pug;

	$defaults = [
		'items' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);

	if ( empty($data->items) ) {
		foreach ( get_the_category() as $category ) {
			$data->items[] = [
				'href' => get_category_link( $category->term_id ),
				'text' => $category->name
			];
		}
	}

	echo $pug->renderFile(__DIR__ . '/categories-labels.pug', [
		'data' => $data
	]);
}
