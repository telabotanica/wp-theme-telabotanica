<?php function telabotanica_module_cover($data) {

	$defaults = [
		'image' => get_field('cover_image'),
		'title' => get_the_title(),
		'subtitle' => get_field('cover_subtitle'),
		'content' => false,
		'search' => false,
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('cover', $data->modifiers);

	printf(
		'<div class="%s" style="background-image: url(%s);">',
		implode(' ', $data->modifiers),
		$data->image['url']
	);

		echo '<div class="layout-wrapper">';

			if ($data->search) :
				$data->search['autocomplete'] = false;
				printf(
					'<div class="cover-search-box">%s</div>',
					get_telabotanica_module('search-box', $data->search)
				);
			endif;

			printf(
				'<h1 class="cover-title">%s</h1>',
				$data->title
			);

			if ($data->subtitle) :
				printf(
					'<div class="cover-subtitle">%s</div>',
					$data->subtitle
				);
			endif;

			if ($data->content) :
				printf(
					'<div class="cover-content">%s</div>',
					$data->content
				);
			endif;

		echo '</div>';

		if ( $data->image ) :
			$credits = get_fields( $data->image['ID'] );
			if ( $credits ) :
				echo '<div class="cover-credits">';
				if ($credits['link']) {
					echo sprintf(__('%s par %s', 'telabotanica'), '<a href="' . $credits['link'] . '" target="_blank">' . $data->image['title'] . '</a>', $credits['author']);
				} else {
					echo sprintf(__('%s par %s', 'telabotanica'), $data->image['title'], $credits['author']);
				}
				echo '</div>';
			endif;
		endif;

	echo '</div>';

}
