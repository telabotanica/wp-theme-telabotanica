<?php

function telabotanica_block_list_projects($data)
{
    $defaults = [
		'background_color' => get_sub_field('background_color'),
		'query'            => [
			'type'       => 'random',
			'group_type' => get_sub_field('category')->name,
			'max'        => 4,
		],
		'modifiers' => [],
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-list-projects'], $data->modifiers);

    printf(
		'<div class="%s" style="background-color: %s">',
		implode(' ', $data->modifiers),
		$data->background_color
	);

    echo '<div class="layout-wrapper">';
    echo '<ul class="block-list-projects-items">';

    if (bp_has_groups($data->query)) :

				while (bp_groups()) : bp_the_group();

    the_telabotanica_module('card-project', [
						'tag'       => 'li',
						'meta'      => false,
						'modifiers' => 'with-large-cover',
					]);

    endwhile;

    endif;

    echo '</ul>';
    echo '</div>';

    echo '</div>';
}
