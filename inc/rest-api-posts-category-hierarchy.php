<?php
add_action('rest_api_init', 'tb_add_category_fields_to_posts');

function tb_add_category_fields_to_posts() {
    register_rest_field(
        'post',
        'parent_category',
        [
            'get_callback' => 'tb_get_post_parent_category',
            'schema' => [
                'type' => 'string',
            ],
        ],
    );
    register_rest_field(
        'post',
        'category',
        [
            'get_callback' => 'tb_get_post_category',
            'schema' => [
                'type' => 'array',
            ],
        ],
    );
}
/*
    Il n'y a qu'une seule catégorie par article, qui n'a qu'une catégorie parente
    Aucun article n'est directement dans une catégorie "parente"
    Slugs :
    "articles"
    "evenements"
    "offres-emploi"
*/

// Ajouter la catégorie parente de chaque post dans les donnée de WP Rest API
function tb_get_post_parent_category($object, $field_name, $request) {
    if (empty($object['categories']) || empty($object['categories'][0])) {
        return null;
    }
    $ancestors = get_ancestors( $object['categories'][0], 'category' );

    return $ancestors[0];
}
// Ajouter les infos de la catégorie de chaque post dans les donnée de WP Rest API
function tb_get_post_category($object, $field_name, $request) {
    if (empty($object['categories']) || empty($object['categories'][0])) {
        return null;
    }
    $category_id = $object['categories'][0];
    $category = get_category( $category_id );

    return [
        'id' => $object['categories'][0],
        'name' => $category->name,
        'slug' => $category->slug,
        'count' => $category->count,
    ];
}
