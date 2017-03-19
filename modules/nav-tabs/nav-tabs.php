<?php function telabotanica_module_nav_tabs($data) {
	$defaults = [
		'label' => '',
		'items' => [],
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('nav-tabs', $data->modifiers);

	printf(
		'<div class="%s" aria-label="%s" role="navigation">',
		implode(' ', $data->modifiers),
		esc_attr( $data->label )
	);

		echo '<ul class="nav-tabs-items">';

		$item_defaults = [
			'modifiers' => []
		];

		foreach ( $data->items as $item ) :

			$item = telabotanica_styleguide_data($item_defaults, $item);
			$item->modifiers = telabotanica_styleguide_modifiers_array('nav-tabs-item', $item->modifiers);

			if ( isset( $item->current ) && $item->current === true ) {
				$item->modifiers[] = 'is-current';
			}

			printf(
				'<li class="%s">',
				implode(' ', $item->modifiers)
			);
				printf(
					'<a href="%s">%s</a>',
					$item->href,
					$item->text
				);
			echo '</li>';

		endforeach;

		echo '</ul>';
	echo '</div>';

}
