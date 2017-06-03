<?php

require_once get_template_directory().'/algolia/class-algolia-actualites-index.php';
require_once get_template_directory().'/algolia/class-algolia-evenements-index.php';
require_once get_template_directory().'/algolia/class-algolia-projets-index.php';

/**
 * Dequeue default CSS & JS files.
 *
 * Hooked to the algolia_autocomplete_scripts action, with a late priority (100),
 * so that it is after the stylesheets were enqueued.
 */
function telabotanica_theme_dequeue_files()
{
    wp_dequeue_style('algolia-autocomplete');
    wp_dequeue_script('algolia-search');
    wp_dequeue_script('algolia-autocomplete');
    wp_dequeue_script('algolia-autocomplete-noconflict');
    wp_dequeue_script('tether');
}
add_action('algolia_autocomplete_scripts', 'telabotanica_theme_dequeue_files', 100);

// Blacklist some custom post types
function telabotanica_blacklist_custom_post_type(array $blacklist)
{
    $blacklist[] = 'attachment';
    $blacklist[] = 'bp-email';
    $blacklist[] = 'custom_css';
    $blacklist[] = 'customize_changeset';
    $blacklist[] = 'acf-field-group';
    $blacklist[] = 'acf-field';

    return $blacklist;
}
add_filter('algolia_post_types_blacklist', 'telabotanica_blacklist_custom_post_type');

// Blacklist some custom taxonomies
function telabotanica_blacklist_custom_taxonomies(array $blacklist)
{
    $blacklist[] = 'tb_outils_category';
    $blacklist[] = 'bp_member_type';
    $blacklist[] = 'bp-email-type';
    $blacklist[] = 'bp_group_type';
    $blacklist[] = 'media_category';

    return $blacklist;
}
add_filter('algolia_taxonomies_blacklist', 'telabotanica_blacklist_custom_taxonomies');

// Customize indices
function telabotanica_algolia_indices(array $indices)
{
    $indices[] = new Algolia_Actualites_Index();
    $indices[] = new Algolia_Evenements_Index();
    $indices[] = new Algolia_Projets_Index();

    return $indices;
}
add_filter('algolia_indices', 'telabotanica_algolia_indices');

// Customize searchable posts (it will be displayed as the "Pages" index)
function telabotanica_algolia_should_index_searchable_post(bool $should_index, WP_Post $post)
{
    // Add all post types you want to make searchable.
    $included_post_types = ['page', 'tb_thematique', 'tb_outil', 'tb_participer'];

    if (false === $should_index) {
        return false;
    }

    return in_array($post->post_type, $included_post_types, true);
}
add_filter('algolia_should_index_searchable_post', 'telabotanica_algolia_should_index_searchable_post', 10, 2);

// Customize autocomplete config
function telabotanica_algolia_autocomplete_config(array $config)
{
    // Override some parameters in existing indices
    foreach ($config as $i => $index) :
        if ('searchable_posts' === $index['index_id']) {
            $config[$i]['index_id'] = 'pages';
            $config[$i]['label'] = __('Pages', 'telabotanica');
            $config[$i]['position'] = 60;
        }
    endforeach;

    // Add other indices
    $config[] = [
        'index_id'              => 'flore',
        'index_name'            => 'Flore',
        'label'                 => __('Flore', 'telabotanica'),
        'position'              => 10,
        'max_suggestions'       => 5,
        'tmpl_suggestion'       => 'autocomplete-taxon-suggestion',
        'enabled'               => true,
        'default_facet_filters' => ['referentiels:bdtfx'],
    ];
    $config[] = [
        'index_id'        => 'vegetation',
        'index_name'      => 'Vegetations',
        'label'           => __('Végétations', 'telabotanica'),
        'position'        => 40,
        'max_suggestions' => 5,
        'tmpl_suggestion' => 'autocomplete-syntaxon-suggestion',
        'enabled'         => true,
    ];

    return $config;
}
add_filter('algolia_autocomplete_config', 'telabotanica_algolia_autocomplete_config');

// Add custom query_var `index` (for search page)
function telabotanica_algolia_add_query_vars($vars)
{
    $vars[] = 'index';

    return $vars;
}
add_filter('query_vars', 'telabotanica_algolia_add_query_vars');
