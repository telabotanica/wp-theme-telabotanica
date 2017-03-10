<?php
function telabotanica_module_cover_member($data) {

	echo '<div class="cover-member">';

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

		the_telabotanica_module('button', [
			'href' => '#', // TODO
			'text' => __( "Retour à l'annuaire", 'telabotanica' ),
			'modifiers' => 'cover-member-back white link back'
		] );

		echo '<div class="cover-member-meta">';
			the_telabotanica_module('button', [
				'href' => '#', // TODO
				'text' => __( 'Envoyer un message', 'telabotanica' ),
				'icon_before' => 'mail',
				'modifiers' => 'outline'
			]);
		echo '</div>';

	echo '</div>';

}
