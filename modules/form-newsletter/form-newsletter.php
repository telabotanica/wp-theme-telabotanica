<?php function telabotanica_module_form_newsletter($data) {

	$defaults = [
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('form-newsletter', $data->modifiers);

	printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);

		printf(
			'<div class="form-newsletter-title">%s</div>',
			__( "Recevoir la lettre d'actualités", 'telabotanica' )
		);

		printf(
			'<p class="form-newsletter-text">%s</p>',
			__( "Chaque jeudi, recevez un condensé de l'actualité du réseau, les évènements et les offres d'emplois directement dans votre boîte mail.", 'telabotanica' )
		);

		the_telabotanica_module('button', [
			'href' => is_user_logged_in() ? '#' : '#', // TODO
			'text' => __( "S'abonner", 'telabotanica' )
		] );

	echo '</div>';
}
