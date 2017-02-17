<?php function telabotanica_module_icon($data) {
	global $pug;

	$defaults = [
		'color' => false
	];

	$data = (object) array_merge((array) $defaults, (array) $data);

	echo $pug->render(__DIR__ . '/icon.pug', [
		'data' => $data
	]);
}
