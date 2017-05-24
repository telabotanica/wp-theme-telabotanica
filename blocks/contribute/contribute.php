<?php

function telabotanica_block_contribute_item($item) {
	if ( is_array($item) ) $item = (object) $item;

	echo '<li class="block-contribute-item">';

		printf(
			'<a href="%s" target="%s" class="block-contribute-item-link">',
			esc_url( $item->href ),
			$item->target
		);

			if ( $item->image ) {
				printf(
					'<div class="block-contribute-item-image" style="background-image: url(%s);"></div>',
					esc_url( $item->image )
				);
			}

			printf(
				'<h3 class="block-contribute-item-title"><span>%s</span></h3>',
				$item->title
			);

			printf(
				'<div class="block-contribute-item-text">%s</div>',
				wp_trim_words( $item->text, 18 )
			);

			printf(
				'<div class="block-contribute-item-button">%s</div>',
				$item->button_text
			);

		echo '</a>';

	echo '</li>';
}

function telabotanica_block_contribute($data) {
	$defaults = [
		'query' => false,
		'background_color' => get_sub_field('background_color'),
		'title' => get_sub_field('title'),
		'items' => get_sub_field('items'),
		'buttons' => get_sub_field('buttons'),
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-contribute'], $data->modifiers);

	printf(
		'<div class="%s" style="background-color: %s">',
		implode(' ', $data->modifiers),
		$data->background_color
	);

		echo '<div class="block-contribute-header">';

			echo '<h2 class="block-contribute-title">' . $data->title . '</h2>';

		echo '</div>';

		echo '<div class="block-contribute-content">';

			echo '<div class="layout-wrapper">';
				echo '<ul class="block-contribute-items">';

				$items_id = [];

				if ( !empty($data->items) ) :

					foreach ($data->items as $item) :

						// Tableau d'objets Moyens de participer
						if (gettype($item) === 'object' && get_class($item) === 'WP_Post') :

							$items_id[] = $item->ID;
							$item->title = $item->post_title;
							$fields = (object) get_fields($item->ID);
							$item->text = isset($fields->short_description) ? $fields->short_description : '';
							$item->button_text = isset($fields->button_text) ? $fields->button_text : __( 'Commencer', 'telabotanica' );
							$item->href = $fields->destination['url'];
							$item->target = $fields->destination['target'];
							$item->image = $fields->image['sizes']['medium_square'];

						endif;

						telabotanica_block_contribute_item($item);

					endforeach;

				endif;

				// S'il y a moins de 3 items sélectionnés, on en ajoute pour arriver à 3
				$items_count = count($items_id);
				if ($items_count < 3) {
					$data->query = new WP_Query([
						'post_type' => 'tb_participer',
						'posts_per_page' => 3 - $items_count,
						'post__not_in' => $items_id,
						'orderby' => 'rand'
					]);
				}

				if ( $data->query && get_class($data->query) === 'WP_Query' ) :

					while ( $data->query->have_posts() ) : $data->query->the_post();

						$destination = get_field('destination');
						$item = [
							'title' => get_the_title(),
							'text' => get_field('short_description'),
							'button_text' => get_field('button_text'),
							'href' => $destination['url'],
							'target' => $destination['target'],
							'image' => get_field('image')['sizes']['medium']
						];
						telabotanica_block_contribute_item($item);

					endwhile;

				endif;

				echo '</ul>';
			echo '</div>';

			if ( $data->buttons ) :

				$data->buttons['display'] = [ $data->buttons['display'], 'seamless' ];
				the_telabotanica_component( 'buttons', $data->buttons );

			endif;

		echo '</div>';

	echo '</div>';

	wp_reset_postdata();
}
