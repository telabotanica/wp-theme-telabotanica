<?php

// Catégories d'outils
function telabotanica_outils_categories_taxonomy()
{
    $labels = [
        'name'                       => _x('Catégories d\'outils', 'Taxonomy General Name', 'telabotanica'),
        'singular_name'              => _x('Catégorie d\'outils', 'Taxonomy Singular Name', 'telabotanica'),
        'menu_name'                  => __('Catégories', 'telabotanica'),
        'all_items'                  => __('Toutes les catégories', 'telabotanica'),
        'parent_item'                => __('Catégorie parente', 'telabotanica'),
        'parent_item_colon'          => __('Catégorie parente :', 'telabotanica'),
        'new_item_name'              => __('Nouvelle catégorie d\'outils', 'telabotanica'),
        'add_new_item'               => __('Ajouter une nouvelle catégorie d\'outils', 'telabotanica'),
        'edit_item'                  => __('Modifier la catégorie', 'telabotanica'),
        'update_item'                => __('Mettre à jour la catégorie', 'telabotanica'),
        'view_item'                  => __('Voir la catégorie', 'telabotanica'),
        'separate_items_with_commas' => __('Separate items with commas', 'telabotanica'),
        'add_or_remove_items'        => __('Ajouter ou supprimer des catégories', 'telabotanica'),
        'choose_from_most_used'      => __('Les plus utilisées', 'telabotanica'),
        'popular_items'              => __('Les plus populaires', 'telabotanica'),
        'search_items'               => __('Search Items', 'telabotanica'),
        'not_found'                  => __('Aucune catégorie', 'telabotanica'),
        'no_terms'                   => __('Aucune catégorie', 'telabotanica'),
        'items_list'                 => __('Items list', 'telabotanica'),
        'items_list_navigation'      => __('Items list navigation', 'telabotanica'),
    ];
    $rewrite = [
        'slug'                       => 'outils/categorie',
        'with_front'                 => true,
        'hierarchical'               => true,
    ];
    $args = [
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'rewrite'                    => $rewrite,
    ];
    register_taxonomy('tb_outils_category', ['tb_outil'], $args);
}
add_action('init', 'telabotanica_outils_categories_taxonomy', 0);

// Catégories de moyens de participer
function telabotanica_participer_categories_taxonomy()
{
    $labels = [
        'name'                       => _x('Catégories de moyens de participer', 'Taxonomy General Name', 'telabotanica'),
        'singular_name'              => _x('Catégorie de moyens de participer', 'Taxonomy Singular Name', 'telabotanica'),
        'menu_name'                  => __('Catégories', 'telabotanica'),
        'all_items'                  => __('Toutes les catégories', 'telabotanica'),
        'parent_item'                => __('Catégorie parente', 'telabotanica'),
        'parent_item_colon'          => __('Catégorie parente :', 'telabotanica'),
        'new_item_name'              => __('Nouvelle catégorie de moyens de participer', 'telabotanica'),
        'add_new_item'               => __('Ajouter une nouvelle catégorie de moyens de participer', 'telabotanica'),
        'edit_item'                  => __('Modifier la catégorie', 'telabotanica'),
        'update_item'                => __('Mettre à jour la catégorie', 'telabotanica'),
        'view_item'                  => __('Voir la catégorie', 'telabotanica'),
        'separate_items_with_commas' => __('Separate items with commas', 'telabotanica'),
        'add_or_remove_items'        => __('Ajouter ou supprimer des catégories', 'telabotanica'),
        'choose_from_most_used'      => __('Les plus utilisées', 'telabotanica'),
        'popular_items'              => __('Les plus populaires', 'telabotanica'),
        'search_items'               => __('Search Items', 'telabotanica'),
        'not_found'                  => __('Aucune catégorie', 'telabotanica'),
        'no_terms'                   => __('Aucune catégorie', 'telabotanica'),
        'items_list'                 => __('Items list', 'telabotanica'),
        'items_list_navigation'      => __('Items list navigation', 'telabotanica'),
    ];
    $rewrite = [
        'slug'                       => 'comment-participer',
        'with_front'                 => true,
        'hierarchical'               => true,
    ];
    $args = [
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'rewrite'                    => $rewrite,
    ];
    register_taxonomy('tb_participer_category', ['tb_participer'], $args);
}
add_action('init', 'telabotanica_participer_categories_taxonomy', 0);
