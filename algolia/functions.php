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
  if ( !telabotanica_algolia_check(true) ) { return null; }
  $private_config = telabotanica_algolia_config(true);
  if (!$private_config) return null;

  $apiKey = $admin ? $private_config['admin_api_key'] : $private_config['search_api_key'];
  $appId = $private_config['application_id'];

  // Algolia PHP client v4.47 (OpenAPI): Algolia\AlgoliaSearch\Api\SearchClient::create
  if (class_exists('\Algolia\AlgoliaSearch\Api\SearchClient')) {
    return \Algolia\AlgoliaSearch\Api\SearchClient::create($appId, $apiKey);
  }
  // Algolia PHP client v4 (legacy): Algolia\AlgoliaSearch\SearchClient::create
  if (class_exists('\Algolia\AlgoliaSearch\SearchClient')) {
    return \Algolia\AlgoliaSearch\SearchClient::create($appId, $apiKey);
  }
  // Algolia PHP client v3: \AlgoliaSearch\Client
  if (class_exists('\AlgoliaSearch\Client')) {
    return new \AlgoliaSearch\Client($appId, $apiKey);
  }

  error_log('[Algolia] No compatible PHP client found. Install algolia/algoliasearch-client-php.');
  return null;
}

/*
 * Algolia config
 */
function telabotanica_algolia_config($private = false) {
  if ( !telabotanica_algolia_check() ) { return null; }

  $config = require get_template_directory() . '/algolia/config.php';

  // Remove private key (should NEVER be accessible on front-end)
  if (!$private) {
    unset($config['admin_api_key']);
  }

  return $config;
}

/*
 * Make Algolia config accessible to Javascript — use wp_json_encode & esc
 */
function telabotanica_algolia_add_config() {
  if ( !telabotanica_algolia_check() ) { return; }
  $config = telabotanica_algolia_config();
  if (!$config) return;
  // Only expose public keys; admin key already removed
  $json_config = wp_json_encode( $config, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
  if (!$json_config) return;
  // Output via wp_add_inline_script would be cleaner, but keep footer script for back-compat
  echo '<script type="text/javascript">var algolia = ' . $json_config . ';</script>' . "\n";
}
add_action( 'wp_footer', 'telabotanica_algolia_add_config' );

/*
 * Add templates to the page
 */
function telabotanica_algolia_add_templates() {
  if ( !telabotanica_algolia_check() ) { return; }
  $file = get_template_directory() . '/algolia/autocomplete.php';
  if (file_exists($file)) require $file;
}
add_action( 'wp_footer', 'telabotanica_algolia_add_templates', PHP_INT_MAX );

/*
 * Add custom query_vars `q` and `in` (for search page)
 */
function telabotanica_algolia_add_query_vars( $vars ){
  $vars[] = "in";
  $vars[] = "q";
  return $vars;
}
add_filter( 'query_vars', 'telabotanica_algolia_add_query_vars' );
