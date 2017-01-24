<?php

/**
 * redirect user to their buddypress profile if they are trying to view their wp profile
 * https://buddydev.com/buddypress/playing-with-buddypress-and-wordpress-some-codes-for-the-site-admins/
 * 
 */
 
add_action("admin_init","bpdev_redirect_user_to_bp_profile");
 
function bpdev_redirect_user_to_bp_profile(){
	if ( !defined('IS_PROFILE_PAGE') )
	return false;//if this is not the profile page, do not do anything
	 
	$current_user = wp_get_current_user();
	$bp_profile_link=bp_core_get_user_domain( $current_user->ID);
	bp_core_redirect($bp_profile_link);
}

/**
 * Enléve le champ pseudo de la page d'inscription
 *
 * @return string
 */
 // supprime le champ
add_filter( 'xprofile_group_fields', 'dk_bp_remove_xprofile_fullname_field', 10, 2 );
function dk_bp_remove_xprofile_fullname_field( $fields ){
    if( ! bp_is_register_page() )
		return $fields;
    // Remove item from array.
    foreach ($fields as $key => $value ) {
		if ( $value->id == 1 ) {
			$fields[ $key ] = array();
		}
    }
    // Return the fields
    return $fields;
}

//ajoute un champ caché
add_action( 'bp_after_signup_profile_fields', 'dk_bp_add_xprofile_fullname_field_hidden' );
function dk_bp_add_xprofile_fullname_field_hidden(){
    if( ! bp_is_register_page() )
		return;

    echo '<input type="hidden" name="field_1" id="field_1" value="x"/>';
}

add_action( 'bp_core_signup_user', 'dk_bp_core_signup_user' );
function dk_bp_core_signup_user( $user_id ) {
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

// Empêche un utilisateur non identifié d'accéder à des pages membres
// @TODO comprendre pourquoi ce test et pourquoi 2 hooks
if (function_exists('bp_is_register_page') && function_exists('bp_is_activation_page')) {
	add_action('wp','members_page_only_for_logged_in_users');
} else {
	add_action('wp_head','members_page_only_for_logged_in_users');
}

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

	if (is_user_logged_in() == false && (
		bp_is_activity_component() ||
		//bp_is_groups_component() || // on souhaite pouvoir voir les groupes publics
		bp_is_forums_component() ||
		bp_is_blogs_component() ||
		bp_is_members_component() || // marche pas :-/
		strpos($current_url,'/profile/') == true ||
		strpos($current_url,'/friends/') == true ||
		strpos($current_url,'/following/') == true ||
		strpos($current_url,'/followers/') == true)) {

		$redirect_url = wp_login_url();
		header('Location: ' . $redirect_url);
		die();
	}
}
