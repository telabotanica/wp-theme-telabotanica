<?php

function telabotanica_module_feed($data)
{
    $defaults = [
		'text'      => '',
		'modifiers' => []
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('feed', $data->modifiers);

    echo '<div class="' . implode(' ', $data->modifiers) . '">';

    if ($data->title) {
        the_telabotanica_module('title', $data->title);
    }

    echo '<ol class="feed-items">';

    if (!empty($data->items)) :

			foreach ($data->items as $item) :

				$item = (object) $item;

    the_telabotanica_module($item->type, $item);

    endforeach;

    endif;

    echo '</ol>';
    echo '</div>';
}
