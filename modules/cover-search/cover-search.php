<?php function telabotanica_module_cover_search($data) {
	global $wp_query;

	$defaults = [
		'image' => get_field('cover_image'),
		'total_results' => $wp_query->found_posts,
		'index' => false,
		'instantsearch' => false,
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array(['cover', 'cover-search'], $data->modifiers);

	// Définir une image au hasard si aucune n'est présente
	if ( empty( $data->image['url'] ) ) :
		$cover_image_query = new WP_Query( [
			'post_status' => 'any',
			'post_type'   => 'attachment',
			'tax_query' => [
				[
					'taxonomy' => 'media_category',
					'field'    => 'slug',
					'terms'    => 'imgbandeau',
				],
			],
			'orderby' => 'rand',
			'posts_per_page' => 1
		] );
		if ( $cover_image_query->have_posts() ) :
			while ( $cover_image_query->have_posts() ) :
				$cover_image_query->the_post();
				$data->image = [
					'ID' => get_the_ID(),
					'url' => wp_get_attachment_url( get_the_ID() ),
					'title' => get_the_title()
				];
			endwhile;
		endif;
		wp_reset_postdata();
	endif;

	printf(
		'<div class="%s" style="background-image: url(%s);">',
		implode(' ', $data->modifiers),
		$data->image['url']
	);

		echo '<div class="layout-wrapper">';
			echo '<div class="cover-search-content">';

			the_telabotanica_module('search-box', [
				'autocomplete' => false,
				'instantsearch' => $data->instantsearch,
				'index' => $data->index,
				'modifiers' => ['large', 'is-primary']
			]);

			if ( get_search_query() && !empty( $data->total_results ) ) :
				printf(
					'<h1 class="cover-search-title">%s</h1>',
					sprintf( _n(
						'%s résultat trouvé',
						'%s résultats trouvés',
						$data->total_results,
						'telabotanica'
					), number_format_i18n( $data->total_results ) )
				);
			endif;

			echo '</div>';
		echo '</div>';

		telabotanica_image_credits( $data->image, 'cover' );

	echo '</div>';
}
