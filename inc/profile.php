<?php

/**
 * Redirect users to their BP profile if they're trying to view their WP profile
 * https://buddydev.com/buddypress/playing-with-buddypress-and-wordpress-some-codes-for-the-site-admins/
 */
add_action("admin_init","tb_redirect_user_to_bp_profile");
function tb_redirect_user_to_bp_profile(){
	if ( !defined('IS_PROFILE_PAGE') )
	return false;//if this is not the profile page, do not do anything

	$current_user = wp_get_current_user();
	$bp_profile_link=bp_core_get_user_domain( $current_user->ID);
	bp_core_redirect($bp_profile_link);
}

/**
 * Enlève le champ "pseudo" (BP "name") de la page d'inscription; seul le champ
 * WP "user_login" reste, car il est obligatoire, et celui-ci est copié dans le
 * pseudo BP
 */
add_filter( 'xprofile_group_fields', 'tb_bp_remove_xprofile_fullname_field', 10, 2 );
function tb_bp_remove_xprofile_fullname_field( $fields ) {
		if( ! bp_is_register_page() ) {
		return $fields;
	}
	// Remove item from array.
	foreach ($fields as $key => $value ) {
	if ( $value->id == 1 ) {
		// produit des "notice" dans le formulaire, mais pas trouvé comment
		// faire mieux
		$fields[$key] = array();
	}
	}
	// Return the fields
	return $fields;
}

/**
 * Ajoute un champ caché "pseudo" (BP "name") dans lequel sera copié la valeur
 * saisie à l'inscription dans le champ WP "user_login"; pour avoir un vrai
 * pseudo, il faudra aller le changer ensuite dans son profil
 */
add_action( 'bp_after_signup_profile_fields', 'tb_bp_add_xprofile_fullname_field_hidden' );
function tb_bp_add_xprofile_fullname_field_hidden(){
	if( ! bp_is_register_page() ) {
	return;
}
	echo '<input type="hidden" name="field_1" id="field_1" value=""/>';
}

/**
 * Recopie la valeur de l'identifiant WP (user_login) dans le champ "pseudo"
 * (BP "name")
 */
add_action( 'bp_core_signup_user', 'tb_bp_core_signup_user', 10, 1 );
function tb_bp_core_signup_user( $user_id ) {
	$user = get_userdata( $user_id );
	xprofile_set_field_data( BP_XPROFILE_FULLNAME_FIELD_NAME, $user_id, $user->user_login );
	$userdata = array(
	'ID' => $user_id,
	'user_nicename' => $user->user_login,
	'display_name' => $user->user_login,
	'nickname' => $user->user_login
	);
	wp_update_user( $userdata );
}

/**
 * Recopie la valeur du nom et du prénom BP (champs perso TB "Prénom" et "Nom")
 * dans les champs WP "first_name" et "last_name", lorsque le profil est modifié
 *
 * @WARNING penser à *désactiver* "Synchronisation des profils" dans Réglages >
 * BuddyPress > Options, sans quoi les valeurs seront écrasées par la suite
 */
add_action('xprofile_data_after_save', 'tb_bp_xprofile_save_sync_first_and_last_name');
function tb_bp_xprofile_save_sync_first_and_last_name( $xprofileData ) {
	$champ = xprofile_get_field($xprofileData->field_id);
	if ($champ->name == "Prénom") {
		update_user_meta(
			$xprofileData->user_id,
			'first_name',
			$xprofileData->value
		);
	}
	if ($champ->name == "Nom") {
		update_user_meta(
			$xprofileData->user_id,
			'last_name',
			$xprofileData->value
		);
	}
}

/**
 * Recopie la valeur du pseudo BP (champ BP "name") dans les champs WP
 * "user_nicename", "nickname" et "display_name", lorsque le profil est modifié
 *
 * @WARNING penser à *désactiver* "Synchronisation des profils" dans Réglages >
 * BuddyPress > Options, sans quoi les valeurs seront écrasées par la suite
 */
add_action('xprofile_data_after_save', 'tb_bp_xprofile_save_sync_pseudo');
function tb_bp_xprofile_save_sync_pseudo( $xprofileData ) {
	if ($xprofileData->field_id == 1) { // le champs BP "name" (pseudo) est toujours le n°1
		// le "user_nicename" détermine l'URL du profil; il doit être unique
		// mais néanmoins être changeable, par respect de la vie privée
		$new_nicename = $xprofileData->value;
		$existing_id = bp_core_get_userid_from_nicename($new_nicename);
		// on ne suffixe pas le nicename si c'est l'utilisateur en cours qui le porte déjà
		$current_user_id = get_current_user_id();
		if ($existing_id != null) {
			if ($existing_id != $current_user_id) {
				$current_user = new WP_User($current_user_id);
				// si le nicename courant est déjà un suffixe du nicename demandé,
				// on le conserve pour éviter des suffixages en boucle ou inutiles
				$motif = '/^' . $new_nicename . '-[0-9]+/i';
				if ((! isset($current_user->data->user_nicename)) || (! preg_match($motif, $current_user->data->user_nicename))) {
					// sinon, on suffixe
					while ($existing_id != null) {
						$new_nicename = $xprofileData->value . '-' . rand(0, 1000);
						$existing_id = bp_core_get_userid_from_nicename($new_nicename);
					}
				} else {
					// ça matche, on garde le suffixe actuel
					$new_nicename = $current_user->data->user_nicename;
				}
			}
		}
		// mise à jour
		$userdata = array(
			'ID' => $xprofileData->user_id,
			'user_nicename' => $new_nicename,
			'display_name' => $xprofileData->value,
			'nickname' => $xprofileData->value
		);
		wp_update_user( $userdata );
	}
}

/**
 * Si le display_name WP a changé suite à un changement de pseudo BP (fonction
 * ci-dessus), l'URL du profil change et on se prend une 404 après traitement du
 * formulaire
 */
add_action( 'xprofile_updated_profile', 'tb_bp_xprofile_updated_profile_redirection', 10, 1 );
function tb_bp_xprofile_updated_profile_redirection( $user_id ) {
	$user = new WP_User($user_id);
	$url_profil = site_url() . '/' . bp_get_members_root_slug() . '/' . $user->data->user_nicename . '/profile/edit';
	wp_redirect($url_profil);
	exit;
}

/**
 * Empêche un utilisateur non identifié d'accéder à des pages membres
 * @TODO comprendre pourquoi ce test et pourquoi 2 hooks
 */
if (function_exists('bp_is_register_page') && function_exists('bp_is_activation_page')) {
	add_action('wp','members_page_only_for_logged_in_users');
} else {
	add_action('wp_head','members_page_only_for_logged_in_users');
}

/**
 * Interdit l'accès la page associée au composant Buddypress/membres et à toutes
 * ses sous-pages, si l'utilisateur n'est pas connecté
 */
function members_page_only_for_logged_in_users() {
	if (is_front_page()) {
		return;
	}
	if (function_exists('bp_is_register_page') && function_exists('bp_is_activation_page')) {
		if (bp_is_register_page() || bp_is_activation_page())	{
			return;
		}
	}
	$current_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	// nom (slug) de la page associée au composant "membres" de Buddypress
	$pagesBP = get_option('bp-pages');
	$nomPageMembres = get_post_field('post_name', $pagesBP['members']);

	if (is_user_logged_in() == false && strpos($current_url, '/' . $nomPageMembres . '/') !== false) {
		$redirect_url = wp_login_url();
		header('Location: ' . $redirect_url);
		die();
	}
}
