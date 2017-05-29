<?php

function telabotanica_module_header_dashboard($data)
{
    $defaults = [
		'title'     => '',
		'message'   => false,
		'modifiers' => [],
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('header-dashboard', $data->modifiers);

    printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);

    printf(
		'<h1 class="header-dashboard-title">%s</h1>',
		$data->title
	);

    if ($data->message) :
		printf(
			'<div class="header-dashboard-message">%s</div>',
			$data->message
		);
    endif;

    echo '</div>';
}
