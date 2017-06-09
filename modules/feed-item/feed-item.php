<?php

function telabotanica_module_feed_item($data)
{
    global $pug;

    $defaults = [
		'article'   => false,
		'image'     => false,
		'images'    => false,
		'href'      => false,
		'target'    => false,
		'title'     => '',
		'text'      => '',
		'meta'      => false,
		'modifiers' => []
	];

    $data = telabotanica_styleguide_data($defaults, $data);

    echo $pug->render(__DIR__ . '/feed-item.pug', [
		'data' => $data
	]);
}
