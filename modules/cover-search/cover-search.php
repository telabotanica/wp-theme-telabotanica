<?php function telabotanica_module_cover_search($data) {
	global $wp_query;

	$defaults = [
		'image' => get_field('cover_image'),
		'total_results' => $wp_query->found_posts,
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array(['cover', 'cover-search'], $data->modifiers);

	printf(
		'<div class="%s" style="background-image: url(%s);">',
		implode(' ', $data->modifiers),
		$data->image['url']
	);

		echo '<div class="layout-wrapper">';
			echo '<div class="cover-search-content">';

			the_telabotanica_module('search-box', [
				'autocomplete' => false
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

		if ( $data->image ) :
			$credits = get_fields( $data->image['ID'] );
			if ( $credits ) :
				echo '<div class="cover-credits">';
				if ($credits['link']) {
					printf(__('%s par %s', 'telabotanica'), '<a href="' . $credits['link'] . '" target="_blank">' . $data->image['title'] . '</a>', $credits['author']);
				} else {
					printf(__('%s par %s', 'telabotanica'), $data->image['title'], $credits['author']);
				}
				echo '</div>';
			endif;
		endif;

	echo '</div>';
}
