<?php
return [
	'home_url'            => home_url(),
	'debug'               => defined( 'WP_DEBUG' ) && WP_DEBUG,
	'application_id'      => ALGOLIA_APPLICATION_ID,
	'search_api_key'      => ALGOLIA_SEARCH_API_KEY,
	// The following admin_api_key will not be accessible on front-end
	'admin_api_key'       => ALGOLIA_ADMIN_API_KEY,
	'powered_by_enabled'  => true,
	'query' 			   			=> isset( $_GET['s'] ) ? esc_html( $_GET['s'] ) : '',
	'autocomplete' => [
		'sources' => [
			[
				'index_id' => 'flore',
				'index_name' => 'Flore',
				'label' => __('Flore', 'telabotanica'),
				'tmpl_suggestion' => 'autocomplete-taxon-suggestion',
				'settings' => [
					'hitsPerPage' => 5,
					'facetFilters' => [ 'referentiels:bdtfx' ]
				],
				'filters' => [
					'referentiels' => [
						'type' => 'menu',
						'label' => __('Par référentiel', 'telabotanica')
					]
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
				],
				'filters' => [
					'category' => [
						'type' => 'menu',
						'label' => __('Par catégorie', 'telabotanica')
					]
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
				],
				'filters' => [
					'habitat' => [
						'type' => 'menu',
						'label' => __('Par habitat', 'telabotanica')
					]
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
				],
				'filters' => [
					'category' => [
						'type' => 'menu',
						'label' => __("Par type d'évènement", 'telabotanica')
					],
					'event_date.month' => [
						'type' => 'menu',
						'label' => __("Par date", 'telabotanica')
					],
					'event_place.country' => [
						'type' => 'menu',
						'label' => __("Par pays", 'telabotanica')
					],
					'event_place.city' => [
						'type' => 'menu',
						'label' => __("Par ville", 'telabotanica')
					]
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
		]
	]
];
