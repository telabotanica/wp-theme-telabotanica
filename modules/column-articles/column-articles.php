<?php

function telabotanica_module_column_articles_item($item) {
	$item = (object) $item;

	echo '<li class="column-articles-item">';

		echo sprintf(
			'<a href="%s" class="column-articles-item-link">',
			esc_url( $item->href )
		);

			echo sprintf(
				'<div class="column-articles-item-image" style="background-image: url(%s);"></div>',
				$item->image
			);

			echo sprintf(
				'<h3 class="column-articles-item-title"><span>%s</span></h3>',
				$item->title
			);

			echo sprintf(
				'<div class="column-articles-item-text">%s</div>',
				wp_trim_words($item->text, 18)
			);

		echo '</a>';

		echo '<div class="column-articles-item-meta">';
			echo sprintf(
				'<div class="column-articles-item-date" title="%s">%s <time datetime="%s">%s</time></span>',
				sprintf( _x( '%s à %s', '%s = date et %s = heure', 'telabotanica' ),
					date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ),
					date_i18n( get_option( 'time_format' ), get_the_time( 'U' ) )
				),
				get_telabotanica_module('icon', ['icon' => 'clock']),
				get_the_time( 'Y-m-d\\TG:i:s\\Z' ),
				sprintf( _x( 'il y a %s', '%s = intervalle de temps', 'telabotanica' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) )
			);
		echo '</div>';

	echo '</li>';
}

function telabotanica_module_column_articles($data) {

	$defaults = [
		'query' => false,
		'items' => [],
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('column-articles', $data->modifiers);

  echo '<div class="' . implode(' ', $data->modifiers) . '">';

	  echo '<ul class="column-articles-items">';

		if ( $data->query && get_class($data->query) === 'WP_Query' ) :

			while ( $data->query->have_posts() ) :

				$data->query->the_post();
				$item = [
					'title' => get_the_title(),
					'text' => get_the_excerpt(),
					'href' => get_the_permalink(),
					'image' => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'post-thumbnail' ) : '',
				];
				telabotanica_module_column_articles_item($item);

			endwhile;

		elseif ( !empty($data->items) ) :

	    foreach ($data->items as $item) :

				telabotanica_module_column_articles_item($item);

	    endforeach;

	  endif;

	  echo '</ul>';
  echo '</div>';
}
