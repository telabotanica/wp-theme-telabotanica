<?php
/**
 * Redirects non-admins to the homepage after logging into the site, unless the
 * $redirect_to string is set
 */
function tb_login_redirect( $redirect_to, $request, $user ) {

  $url = $redirect_to;

  // Ex-telabotaniste ('deleted_tb_user' role user) can't login
  if ((int) $user->ID === retrieve_deleted_tb_user_id()) {
	wp_logout();
	$url = site_url();
  }

  if (empty($redirect_to) || (admin_url() == $redirect_to)) {
    if (! is_wp_error($user)) {
      if ( ! is_array( $user->roles ) || ! in_array( 'administrator', $user->roles) || ! in_array( 'deleted_tb_user', $user->roles) ) {
        $url = site_url();
      }
    }
  }
  return $url;
}
add_filter( 'login_redirect', 'tb_login_redirect', 10, 3 );
