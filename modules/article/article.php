<?php

function telabotanica_module_article($data)
{
    $defaults = [
		'tag'         => 'article',
		'href'        => get_the_permalink(),
		'title'       => get_the_title(),
		'title_level' => 1,
		'thumbnail'   => false,
		'image'       => false,
		'intro'       => '',
		'text'        => '',
		'modifiers'   => []
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('article', $data->modifiers);

    echo '<' . $data->tag . ' class="' . implode(' ', $data->modifiers) . '">';

    if ($data->thumbnail) :
			printf(
				'<a href="%s" class="article-thumbnail" style="background-image: url(%s)"></a>',
				esc_url($data->href),
				is_array($data->thumbnail) ? $data->thumbnail['sizes']['thumbnail'] : $data->thumbnail
			);
    endif;

    echo '<div class="article-content">';

    printf(
			'<h%s class="article-title"><a href="%s">%s</a>%s</h%s>',
			$data->title_level,
			esc_url($data->href),
			$data->title,
			in_array('is-small', $data->modifiers) ? get_telabotanica_module('icon', ['icon' => 'angle-right', 'color' => 'orange']) : '',
			$data->title_level
		);

    if ($data->image) :
			printf(
				'<a href="%s" class="article-image">%s</a>',
				esc_url($data->href),
				$data->image
			);
    endif;

    if ($data->intro) :
			the_telabotanica_component('intro', [
				'text' => $data->intro
			]);
    endif;

    if ($data->text) :
			the_telabotanica_component('text', [
				'text' => $data->text
			]);
    endif;

    echo '</div>';

    echo '</' . $data->tag . '>';
}
