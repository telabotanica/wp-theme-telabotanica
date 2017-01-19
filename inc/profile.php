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
