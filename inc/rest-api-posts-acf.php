<?php
//register acf fields to Wordpress API
add_action('rest_api_init', 'tb_add_acf_fields');

function tb_add_acf_fields() {
    register_rest_field(
        'post',
        'acf',
        [
            'get_callback' => 'tb_get_acf_fields',
            'schema' => [
                'type' => 'array',
            ],
        ],
    );
}

function tb_get_acf_fields($object, $field_name, $request) {
    if (empty($object['id'])) {
        return null;
    }
    return get_fields($object['id']);
}