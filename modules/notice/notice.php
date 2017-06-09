<?php

function telabotanica_module_notice($data)
{
    global $pug;

    $defaults = [
		'type' => 'info'
	];

    $data = telabotanica_styleguide_data($defaults, $data);

    echo $pug->render(__DIR__ . '/notice.pug', [
		'data' => $data
	]);
}
