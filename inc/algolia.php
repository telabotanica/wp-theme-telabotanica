<?php

/**
 * Dequeue default CSS files.
 *
 * Hooked to the wp_print_styles action, with a late priority (100),
 * so that it is after the stylesheets were enqueued.
 */
function telabotanica_theme_dequeue_styles() {
  // Remove the algolia-autocomplete.css.
  wp_dequeue_style( 'algolia-autocomplete' );
}
add_action( 'wp_print_styles', 'telabotanica_theme_dequeue_styles', 100 );


// Blacklist some custom post types
function telabotanica_blacklist_custom_post_type( array $blacklist ) {
    $blacklist[] = 'attachment';
    $blacklist[] = 'bp-email';
    $blacklist[] = 'custom_css';
    $blacklist[] = 'customize_changeset';
    $blacklist[] = 'acf-field-group';
    $blacklist[] = 'acf-field';
    $blacklist[] = 'tb_outils_category';
    return $blacklist;
}
add_filter( 'algolia_post_types_blacklist', 'telabotanica_blacklist_custom_post_type' );

// Blacklist some custom taxonomies
function telabotanica_blacklist_custom_taxonomies( array $blacklist ) {
    $blacklist[] = 'tb_outils_category';
    $blacklist[] = 'bp_member_type';
    $blacklist[] = 'bp-email-type';
    $blacklist[] = 'bp_group_type';
    $blacklist[] = 'media_category';
    return $blacklist;
}
add_filter( 'algolia_taxonomies_blacklist', 'telabotanica_blacklist_custom_taxonomies' );

// Customize config
function telabotanica_algolia_config( array $config ) {
  // var_dump($config);
  // Add other indices
  $config['autocomplete']['sources'][] = [
    'index_id' => 'taxons',
    'index_name' => 'Taxons_dev',
    'label' => __('Flore', 'telabotanica'),
    'position' => 90,
    'max_suggestions' => 3,
    'tmpl_suggestion' => 'autocomplete-taxon-suggestion',
    'enabled' => true
  ];
  $config['autocomplete']['sources'][] = [
    'index_id' => 'syntaxons',
    'index_name' => 'SyntaxonCore_dev',
    'label' => __('Végétation', 'telabotanica'),
    'position' => 80,
    'max_suggestions' => 3,
    'tmpl_suggestion' => 'autocomplete-syntaxon-suggestion',
    'enabled' => true
  ];
  return $config;
}
add_filter( 'algolia_config', 'telabotanica_algolia_config' );
