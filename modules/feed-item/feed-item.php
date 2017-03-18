<?php
function telabotanica_module_feed_item_meta($meta) {
	$meta = (object) $meta;

	echo '<div class="feed-item-meta">';

		if ( isset($meta->place) ) {
			echo $meta->place;
			the_telabotanica_module('icon', ['icon' => 'marker']);
		}

		if ( isset($meta->text) ) {
			echo $meta->text;
		}

	echo '</div>';
}

function telabotanica_module_feed_item($data) {

	$defaults = [
		'article' => false,
		'image' => false,
		'images' => false,
		'href' => false,
		'title' => '',
		'text' => '',
		'meta' => false,
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('feed-item', $data->modifiers);

	if ( $data->image ) $data->modifiers[] = 'has-image';
	if ( $data->images ) $data->modifiers[] = 'has-images';
	if ( $data->href ) $data->modifiers[] = 'has-link';
	if ( $data->article ) $data->modifiers[] = 'is-article';
	if ( $data->text && !$data->image && !$data->title && !$data->meta && !$data->href ) $data->modifiers[] = 'has-only-text';

	echo '<div class="' . implode(' ', $data->modifiers) . '">';

		if ( $data->href ) :
			printf(
				'<a href="%s" class="feed-item-link">',
				$data->href
			);
		endif;

		if ( $data->image ) :
			if ( $data->article ) :
				printf(
					'<div class="feed-item-image" style="background-image: url(%s)">%s</div>',
					$data->image,
					get_telabotanica_module('icon', ['icon' => 'news'])
				);
			else :
				printf(
					'<img src="%s" alt="%s" class="feed-item-image" />',
					$data->image,
					''
				);
			endif;
		endif;

		if ( $data->images ) :
			echo '<div class="feed-item-images">';
			foreach ( $data->images as $image ) :
				printf(
					'<img src="%s" alt="%s" />',
					$image,
					''
				);
			endforeach;
			echo '</div>';
		endif;

		if ( $data->title ) :
			printf(
				'<h3 class="feed-item-title">%s</h3>',
				$data->title
			);
		endif;

		if ( $data->text ) :
			printf(
				'<div class="feed-item-text">%s</div>',
				$data->text
			);
		endif;

		if ( $data->meta ) :
			telabotanica_module_feed_item_meta($data->meta);
		endif;

		if ( $data->href ) :
			echo '</a>';
		endif;

	echo '</div>';

}
