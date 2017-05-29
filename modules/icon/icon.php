<?php

function telabotanica_module_icon($data)
{
    global $pug;

    $defaults = [
		'color' => false,
	];

    $data = telabotanica_styleguide_data($defaults, $data);

    echo $pug->render(__DIR__.'/icon.pug', [
		'data' => $data,
	]);
}
