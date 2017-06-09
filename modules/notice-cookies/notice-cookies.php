<?php

function telabotanica_module_notice_cookies($data)
{
    $defaults = [
		'text'    => __("En poursuivant votre navigation sur tela-botanica.org, vous acceptez le dépôt de cookies sur votre terminal et l'utilisation de ceux-ci à des fins statistiques.", 'telabotanica'),
		'buttons' => [
			[
				'text'             => __("J'accepte", 'telabotanica'),
				'modifiers'        => ['white'],
				'extra_attributes' => ['data-action' => 'accept-cookies']
			],
			[
				'href' => get_permalink(get_page_by_path('mentions-legales')) . '#utilisation-cookies',
				'text' => __('En savoir plus', 'telabotanica')
			]
		],
		'modifiers' => []
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('notice-cookies', $data->modifiers);

    printf(
    '<div class="%s">',
    implode($data->modifiers, ' ')
  );

    printf(
			'<div class="notice-cookies-text">%s</div>',
			$data->text
		);

    echo '<div class="notice-cookies-buttons">';
    foreach ($data->buttons as $button) {
        the_telabotanica_module('button', $button);
    }
    echo '</div>';

    echo '</div>';
}
