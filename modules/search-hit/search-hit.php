<?php function telabotanica_module_search_hit($data) {
	global $pug;

	$defaults = [
	];

	$data = telabotanica_styleguide_data($defaults, $data);

	echo $pug->render(__DIR__ . '/search-hit.pug', [
		'data' => $data
	]);
}
