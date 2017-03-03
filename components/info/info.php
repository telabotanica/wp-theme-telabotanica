<?php function telabotanica_component_info($data) {

	$defaults = [
		'modifiers' => [],
		'items' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-info'], $data->modifiers);

	echo '<div class="' . implode(' ', $data->modifiers) . '">';
		printf(
			'<h2 class="component-info-title"><span>%s</span></h2>',
			__( 'Infos pratiques', 'telabotanica' )
		);

		if ( $data->items ):
			echo '<dl class="component-info-items">';

			foreach ($data->items as $item) :

				$item = (object) $item;

				printf(
					'<dt class="component-info-item-title">%s</dt><dd class="component-info-item-text">%s</dd>',
					$item->title,
					$item->text
				);

			endforeach;

			echo '</dl>';
		endif;

	echo '</div>';

}
