<?php function telabotanica_module_feed_date($data) {

	$defaults = [
		'text' => '',
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('feed-date', $data->modifiers);

	echo '<li class="' . implode(' ', $data->modifiers) . '">';

		echo '<span class="feed-date-wrapper">';

			the_telabotanica_module('icon', ['icon' => 'clock']);
			echo $data->text;

		echo '</span>';

	echo '</li>';

}
