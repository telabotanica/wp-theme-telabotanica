<?php
/**
 * Redirects non-admins to the homepage after logging into the site
 */
function tb_login_redirect( $redirect_to, $request, $user ) {

	$url = admin_url();
	if (! is_wp_error($user)) {
		if ( ! is_array( $user->roles ) || ! in_array( 'administrator', $user->roles ) ) {
			$url = site_url();
		}
	}
	return $url;
}
add_filter( 'login_redirect', 'tb_login_redirect', 10, 3 );
