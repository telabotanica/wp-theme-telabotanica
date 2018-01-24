<?php
function telabotanica_module_cover_member($data) {

	$defaults = [
		'back' => [
			'href' => bp_get_members_directory_permalink(),
			'text' => __( "Retour à l'annuaire", 'telabotanica' )
		],
		'button' => [
			'href' => '#', // TODO
			'text' => __( 'Envoyer un message', 'telabotanica' ),
			'icon_before' => 'mail'
		],
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('cover-member', $data->modifiers);

	printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);

		$cover_image_url = bp_attachments_get_attachment('url', array(
			'object_dir' => 'members',
			'item_id' => bp_displayed_user_id(),
		));
		printf(
			'<div class="cover-member-image" style="background-image: url(%s);"></div>',
			$cover_image_url
		);

		// TODO: enlever le `@` et comprendre pourquoi BuddyPress affiche des `notice`
		@bp_member_avatar( 'type=full&width=90&height=90' );

		echo '<h1 class="cover-member-title">' . bp_get_displayed_user_fullname() . '</h1>';

		$data->back['modifiers'] = 'cover-member-back white link back';
		the_telabotanica_module('button', $data->back);

		echo '<div class="cover-member-meta">';

			if($data->button == $defaults['button']){
				$button_href =  bp_loggedin_user_domain() .  bp_get_messages_slug();
				$button_href .= '/compose/?r=' . bp_get_displayed_user_fullname();
				$button_href = wp_nonce_url($button_href);
				$data->button['href'] = $button_href;
			}
			$data->button['modifiers'] = 'outline';
			the_telabotanica_module('button', $data->button);
			
		echo '</div>';

	echo '</div>';

}
