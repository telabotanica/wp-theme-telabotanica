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
function telabotanica_algolia_client() {
	if ( !telabotanica_algolia_check(true) ) { return; }
	$private_config = telabotanica_algolia_config(true);

	return new \AlgoliaSearch\Client($private_config['application_id'], $private_config['admin_api_key']);
}

/*
 * autocomplete.js configuration
 */
function telabotanica_algolia_autocomplete_config() {
	$autocomplete_sources = [
		[
			'index_id' => 'flore',
			'index_name' => 'Flore',
			'label' => __('Flore', 'telabotanica'),
			'tmpl_suggestion' => 'autocomplete-taxon-suggestion',
			'settings' => [
				'hitsPerPage' => 5,
				'facetFilters' => [ 'referentiels:bdtfx' ]
			]
		],
		[
			'index_id' => 'actualites',
			'index_name' => ALGOLIA_PREFIX . 'actualites',
			'label' => __('Actualités', 'telabotanica'),
			'tmpl_suggestion' => 'autocomplete-post-suggestion',
			'settings' => [
				'hitsPerPage' => 5,
				'attributesToSnippet' => [ 'post_content:7' ]
			]
		],
		[
			'index_id' => 'projets',
			'index_name' => ALGOLIA_PREFIX . 'projets',
			'label' => __('Projets', 'telabotanica'),
			'tmpl_suggestion' => 'autocomplete-group-suggestion',
			'settings' => [
				'hitsPerPage' => 3
			]
		],
		[
			'index_id' => 'vegetation',
			'index_name' => 'Vegetations',
			'label' => __('Végétations', 'telabotanica'),
			'tmpl_suggestion' => 'autocomplete-syntaxon-suggestion',
			'settings' => [
				'hitsPerPage' => 5,
				'attributesToHighlight' => [ 'syntaxon' ]
			]
		],
		[
			'index_id' => 'evenements',
			'index_name' => ALGOLIA_PREFIX . 'evenements',
			'label' => __('Évènements', 'telabotanica'),
			'tmpl_suggestion' => 'autocomplete-post-suggestion',
			'settings' => [
				'hitsPerPage' => 5,
				'attributesToSnippet' => [ 'post_content:7' ]
			]
		],
		// TODO: enable when ready
		// [
		// 	'index_id' => 'pages',
		// 	'index_name' => ALGOLIA_PREFIX . 'pages',
		// 	'label' => __('Pages', 'telabotanica'),
		// 	'tmpl_suggestion' => 'autocomplete-post-suggestion',
		// 	'settings' => [
		// 		'hitsPerPage' => 5
		// 	]
		// ]
	];

	$autocomplete_config = [
		'sources' => $autocomplete_sources
	];

	return $autocomplete_config;
}

/*
 * Algolia config
 */
function telabotanica_algolia_config($private = false) {
	if ( !telabotanica_algolia_check() ) { return; }

	$config = [
		'debug'               => defined( 'WP_DEBUG' ) && WP_DEBUG,
		'application_id'      => ALGOLIA_APPLICATION_ID,
		'search_api_key'      => ALGOLIA_SEARCH_API_KEY,
		'powered_by_enabled'  => true,
		'query' 			   			=> isset( $_GET['s'] ) ? esc_html( $_GET['s'] ) : '',
		'autocomplete'        => telabotanica_algolia_autocomplete_config(),
		'indices' 						=> [], // TODO for instantsearch?
	];

	if ($private) {
		$config['admin_api_key'] = ALGOLIA_ADMIN_API_KEY;
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
 * Add custom query_var `index` (for search page)
 */
function telabotanica_algolia_add_query_vars( $vars ){
	$vars[] = "index";
	return $vars;
}
add_filter( 'query_vars', 'telabotanica_algolia_add_query_vars' );
