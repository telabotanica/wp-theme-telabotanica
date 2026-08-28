<?php

/*
 * Check that Algolia config is present
 */
function telabotanica_algolia_check($notice = false) {
  if ( ! (defined( 'ALGOLIA_APPLICATION_ID' ) && defined( 'ALGOLIA_SEARCH_API_KEY' ) && defined( 'ALGOLIA_ADMIN_API_KEY' ) && defined( 'ALGOLIA_PREFIX' ) ) ) {
    if ($notice) { the_telabotanica_module('notice', [
      'type' => 'alert',
      'title' => 'Erreur',
      'text' => __("Vous devez renseigner la configuration d'Algolia, cf. README du thème.", 'telabotanica')
    ]); }
    return false;
  }
  return true;
}

/*
 * Initialize the client
 */
function telabotanica_algolia_client($admin = false) {
  if ( !telabotanica_algolia_check(true) ) { return; }
  $private_config = telabotanica_algolia_config(true);

  return new \AlgoliaSearch\Client($private_config['application_id'], $admin ? $private_config['admin_api_key'] : $private_config['search_api_key']);
}

/*
 * Algolia config
 */
function telabotanica_algolia_config($private = false) {
  if ( !telabotanica_algolia_check() ) { return; }

  $config = require get_template_directory() . '/algolia/config.php';

  // Remove private key (should NEVER be accessible on front-end)
  if (!$private) {
    unset($config['admin_api_key']);
  }

  return $config;
}

/*
 * Make Algolia config accessible to Javascript
 */
function telabotanica_algolia_add_config() {
  if ( !telabotanica_algolia_check() ) { return; }
  $json_config = json_encode( telabotanica_algolia_config() );
  echo '<script type="text/javascript">var algolia = ' . $json_config . ';</script>';
}
add_filter( 'wp_footer', 'telabotanica_algolia_add_config' );

/*
 * Add templates to the page
 */
function telabotanica_algolia_add_templates() {
  if ( !telabotanica_algolia_check() ) { return; }
  require get_template_directory() . '/algolia/autocomplete.php';
}
add_filter( 'wp_footer', 'telabotanica_algolia_add_templates', PHP_INT_MAX );

/*
 * Add custom query_vars `q` and `in` (for search page)
 */
function telabotanica_algolia_add_query_vars( $vars ){
  $vars[] = "in";
  $vars[] = "q";
  return $vars;
}
add_filter( 'query_vars', 'telabotanica_algolia_add_query_vars' );
