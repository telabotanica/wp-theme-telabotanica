<?php function telabotanica_module_article($data) {

	$defaults = [
		'href' => '',
		'title' => '',
		'image' => false,
		'text' => '',
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('article', $data->modifiers);

	echo '<div class="' . implode(' ', $data->modifiers) . '">';

		printf(
			'<h%s class="article-title"><a href="%s">%s</a></h%s>',
			1,
			esc_url( $data->href ),
			$data->title,
			1
		);

		if ( $data->image ) :
			echo sprintf(
				'<a href="%s" class="article-image">%s</a>',
				esc_url( $data->href ),
				$data->image
			);
		endif;

		the_telabotanica_component('intro', [
			'text' => $data->text
		]);

	echo '</div>';

}
