<?php
/**
 * Redirects non-admins to the homepage after logging into the site, unless the
 * $redirect_to string is set
 */
function tb_login_redirect( $redirect_to, $request, $user ) {

	$url = $redirect_to;
	if (empty($redirect_to) || (admin_url() == $redirect_to)) {
		if (! is_wp_error($user)) {
			if ( ! is_array( $user->roles ) || ! in_array( 'administrator', $user->roles ) ) {
				$url = site_url();
			}
		}
	}
	return $url;
}
add_filter( 'login_redirect', 'tb_login_redirect', 10, 3 );
