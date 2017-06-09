<?php

function telabotanica_component_text($data)
{
    $defaults = [
		'text'      => get_sub_field('text'),
		'modifiers' => []
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-text'], $data->modifiers);

    echo '<div class="' . implode(' ', $data->modifiers) . '">';
    echo $data->text;
    echo '</div>';
}
