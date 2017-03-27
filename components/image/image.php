<?php function telabotanica_component_image($data) {

	$defaults = [
		'alt' => get_sub_field('alt'),
		'image' => '',
		'srcset' => '',
		'sizes' => '',
		'modifiers' => [ get_sub_field('modifiers') ]
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-image'], $data->modifiers);

	if (empty($data->image)) {
		$image = get_sub_field('image') ?: get_field('image');
		$data->image = $image['sizes']['large'];

		// Le srcset est analysé selon les tailles proposées.
		// La taille est fixe sur desktop (max-width du conteneur des composants)
		// et fluide sur mobile (proche de toute la largeur, donc 100vw)
		// cf. https://ericportis.com/posts/2014/srcset-sizes/
		$srcset = [];
		foreach (['medium', 'large'] as $size) {
			$srcset[$image['sizes'][$size . '-width']] = $image['sizes'][$size] . ' ' . $image['sizes'][$size . '-width'] . 'w';
		}

		$components_width = is_page() ? 620 : 700;

		if ($image['width'] > $components_width) {
			$data->srcset = implode($srcset, ', ');
			$data->sizes = '(min-width: 1160px) ' . $components_width . 'px, 100vw';
		}

		if (empty($data->alt)) $data->alt = $image['title'];
	}

	echo '<div class="' . implode(' ', $data->modifiers) . '">';

		printf(
			'<img src="%s" srcset="%s" sizes="%s" alt="%s" />',
			$data->image,
			$data->srcset,
			$data->sizes,
			$data->alt
		);

		if ( $data->image ) :
			$credits = get_fields( $image['ID'] );
			if ( $credits ) :
				echo '<div class="component-image-credits">';
				$caption = $image['caption'];
				if ( empty( $caption ) ) $caption = $image['title'];
				if ( $credits['link'] ) {
					$caption = sprintf(
						'<a href="%s" target="_blank" class="component-image-credits-title">%s</a>',
						$credits['link'],
						$caption
					);
				} else {
					$caption = sprintf(
						'<span class="component-image-credits-title">%s</span>',
						$caption
					);
				}

				if ($credits['author']) {
					printf(
						__('%s par %s', 'telabotanica'),
						$caption,
						$credits['author']
					);
				} else {
					echo $title;
				}

				echo '</div>';
			endif;
		endif;

	echo '</div>';
}
