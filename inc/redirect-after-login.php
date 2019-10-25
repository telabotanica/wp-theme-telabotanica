<?php
/**
 * Redirects non-admins to the homepage after logging into the site, unless the
 * $redirect_to string is set
 * Third param $user can be a WP_Error with login errors
 */
function tb_login_redirect( $redirect_to, $request, $user ) {

  $url = $redirect_to;

  // Ex-telabotaniste ('deleted_tb_user' role user) can't login
  if (! is_wp_error($user)) {
    if (is_array( $user->roles ) && in_array( 'deleted_tb_user', $user->roles)) {
      wp_logout();
      $url = site_url();
    }
  }

  if (empty($redirect_to) || (admin_url() == $redirect_to)) {
    if (! is_wp_error($user)) {
      if ( ! is_array( $user->roles ) || ! in_array( 'administrator', $user->roles) ) {
        $url = site_url();
      }
    }
  }
  return $url;
}
add_filter( 'login_redirect', 'tb_login_redirect', 10, 3 );
