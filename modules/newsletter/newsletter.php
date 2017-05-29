<?php

function telabotanica_module_newsletter($data)
{
    $defaults = [
		'modifiers' => [],
		'button'    => true,
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('newsletter', $data->modifiers);

    printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);

    printf(
			'<div class="newsletter-title">%s</div>',
			__("Recevoir la lettre d'actualités", 'telabotanica')
		);

    printf(
			'<p class="newsletter-text">%s</p>',
			__("Chaque jeudi, recevez un condensé de l'actualité du réseau, les évènements et les offres d'emplois directement dans votre boîte mail.", 'telabotanica')
		);

    if ($data->button) {
        the_telabotanica_module('button', [
				'href' => is_user_logged_in() ? bp_loggedin_user_domain().'profile/edit' : bp_get_signup_page(),
				'text' => __("S'abonner", 'telabotanica'),
			]);
    }

    echo '</div>';
}
