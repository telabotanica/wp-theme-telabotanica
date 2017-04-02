<?php function telabotanica_module_article($data) {

	$defaults = [
		'href' => get_the_permalink(),
		'title' => get_the_title(),
		'title_level' => 1,
		'image' => false,
		'intro' => '',
		'text' => '',
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('article', $data->modifiers);

	echo '<div class="' . implode(' ', $data->modifiers) . '">';

		printf(
			'<h%s class="article-title"><a href="%s">%s</a></h%s>',
			$data->title_level,
			esc_url( $data->href ),
			$data->title,
			$data->title_level
		);

		if ( $data->image ) :
			printf(
				'<a href="%s" class="article-image">%s</a>',
				esc_url( $data->href ),
				$data->image
			);
		endif;

		if ( $data->intro ) :
			the_telabotanica_component('intro', [
				'text' => $data->intro
			]);
		endif;

		if ( $data->text ) :
			the_telabotanica_component('text', [
				'text' => $data->text
			]);
		endif;

	echo '</div>';

}
