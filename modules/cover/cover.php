<?php

function telabotanica_module_cover($data)
{
    $defaults = [
		'image'     => get_field('cover_image'),
		'title'     => get_the_title(),
		'subtitle'  => get_field('cover_subtitle'),
		'content'   => false,
		'search'    => false,
		'modifiers' => [],
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('cover', $data->modifiers);

	// Définir une image au hasard si aucune n'est présente
	if (empty($data->image['url'])) :
		$cover_image_query = new WP_Query([
			'post_status' => 'any',
			'post_type'   => 'attachment',
			'tax_query'   => [
				[
					'taxonomy' => 'media_category',
					'field'    => 'slug',
					'terms'    => 'imgbandeau',
				],
			],
			'orderby'        => 'rand',
			'posts_per_page' => 1,
		]);
    if ($cover_image_query->have_posts()) :
			while ($cover_image_query->have_posts()) :
				$cover_image_query->the_post();
    $data->image = [
					'ID'    => get_the_ID(),
					'url'   => wp_get_attachment_url(get_the_ID()),
					'title' => get_the_title(),
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

    telabotanica_image_credits($data->image, 'cover');

    echo '</div>';
}
