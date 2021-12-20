<?php
add_filter( 'rest_post_collection_params', function ( $params, WP_Post_Type $post_type ) {
    if ( 'post' === $post_type->name && isset( $params['per_page'] ) ) {
        $params['per_page']['maximum'] = PHP_INT_MAX;
    }

    return $params;
}, 10, 2 );
