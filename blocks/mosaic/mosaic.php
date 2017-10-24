<?php

function telabotanica_block_mosaic_item($item) {
	if ( is_array($item) ) $item = (object) $item;

	echo '<li class="block-mosaic-item">';
		echo '<div class="block-mosaic-item-content-wrapper">';
			echo '<div class="block-mosaic-item-content">';

				echo '<h3 class="block-mosaic-item-title">' . $item->title . '</h3>';

				echo '<p class="block-mosaic-item-text">' . $item->text . '</p>';

				// forcer le bouton à s'afficher en mode "block"
				if ( empty($item->button['modifiers']) || !is_array( $item->button['modifiers'] ) ) $item->button['modifiers'] = [];
				if ( is_array($item->button['modifiers']) && !in_array( 'block', $item->button['modifiers'] ) ) $item->button['modifiers'][] = 'block';
				if ( $item->i % 2 === 1 ) $item->button['modifiers'][] = 'orange';
				$item->button['text'] = $item->button_text;
				$item->button['href'] = $item->button['url'];
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
}

function telabotanica_block_mosaic($data) {
	$defaults = [
		'items' => get_sub_field('items'),
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-mosaic'], $data->modifiers);

	$images_per_item = 4;
	$images_count = count($data->items) * $images_per_item;

	if ( false === ( $images = get_transient( 'module_mosaic_images' ) ) ) {
		$images_feed = json_decode(file_get_contents('http://api.tela-botanica.org/service:del:0.1/observations?navigation.depart=0&navigation.limite=' . $images_count . '&masque.type=adeterminer&masque.pninscritsseulement=1&tri=date_transmission&ordre=desc'));
		$images = array_map(function($resultat) {
			return (object) [
				'href' => 'http://www.tela-botanica.org/appli:identiplante#obs~' . $resultat->id_observation,
				'src' => str_replace('XL.', 'CRS.', $resultat->images[0]->{'binaire.href'}),
				'alt' => @$resultat->{'determination.ns'} ?: __( 'Indéterminé', 'telabotanica' )
			];
		}, $images_feed->resultats);
		set_transient( 'module_mosaic_images', $images, 1 * HOUR_IN_SECONDS );
	}

	$images = array_chunk($images, $images_per_item);

	printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);

	echo '<ul class="block-mosaic-items">';

		foreach ($data->items as $i => $item) :

			$item['i'] = $i;
			$item['images'] = $images[$i];
			telabotanica_block_mosaic_item($item);

		endforeach;

	echo '</ul>';

	echo '</div>';
}
