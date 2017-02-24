<?php function telabotanica_module_article($data) {

	$defaults = [
		'href' => get_permalink(),
		'title' => get_the_title(),
		'image' => has_post_thumbnail() ? get_the_post_thumbnail( null, 'post-thumbnail' ) : null,
		'intro' => get_the_excerpt()
	];

	$data = telabotanica_styleguide_data($defaults, $data);

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
		'text' => $data->intro
	]);

}
