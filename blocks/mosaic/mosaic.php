<?php

function telabotanica_block_mosaic($data) {
	$defaults = [
		'items' => [],
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-mosaic'], $data->modifiers);

	printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);

	echo '<ul class="block-mosaic-items">';

	foreach ($data->items as $item) :

		$item = (object) $item;

		echo '<li class="block-mosaic-item">';
			echo '<div class="block-mosaic-item-content-wrapper">';
				echo '<div class="block-mosaic-item-content">';

					echo '<h3 class="block-mosaic-item-title">' . $item->title . '</h3>';

					echo '<p class="block-mosaic-item-text">' . $item->text . '</p>';

					// forcer le bouton à s'afficher en mode "block"
					if ( empty($item->button['modifiers']) || !is_array( $item->button['modifiers'] ) ) $item->button['modifiers'] = [];
					if ( is_array($item->button['modifiers']) && !in_array( 'block', $item->button['modifiers'] ) ) $item->button['modifiers'][] = 'block';
					the_telabotanica_module('button', $item->button);

				echo '</div>';
			echo '</div>';

			echo '<ul class="block-mosaic-item-images">';
				foreach ($item->images as $image) :
					$image = (object) $image;

					printf(
						'<li class="block-mosaic-item-image"><a href="%s" target="_blank" title="%s"><img src="%s" alt="%s" /></a></li>',
						$image->href,
						@$image->title ?: '',
						$image->src,
						@$image->alt ?: ''
					);

				endforeach;
			echo '</ul>';
		echo '</li>';

	endforeach;

	echo '</ul>';

	echo '</div>';
}
