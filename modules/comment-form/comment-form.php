<?php

function telabotanica_module_comment_form($data)
{
    $defaults = [
		'modifiers' => [],
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('comment-form', $data->modifiers);

    printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);

    comment_form([
			'class_submit' => 'button',
			'label_submit' => __('Publier', 'telabotanica'),
		]);

    echo '</div>';
}
