<?php
/**
 * Amélioration du flux RSS
 *
 * Ajoute un paramètre "dept" pour filtrer les événements par département
 * 
 * Modifie le flux pour afficher les dates (champs ACF) des événements
 *
 * @package WordPress
 * @subpackage Tela_Botanica
 */

/**
 * Add the 'departement' as a public query variable
 *
 * @param array $query_vars
 * @return array $query_vars
 */ 
function my_query_vars( $query_vars ) 
{
    $query_vars[] = 'dept';
    return $query_vars;
}
add_filter( 'query_vars', 'my_query_vars' );

/**
 * Filter the feed by the 'geo_country' meta key 
 *
 * @param WP_Query object $query
 * @return void 
 */ 
function my_pre_get_posts( $query ) 
{
    // only for feeds
    if( $query->is_feed && $query->is_main_query() ) 
    {
        // check if the geo_country variable is set 
        if( isset( $query->query_vars['dept'] ) 
                && ! empty( $query->query_vars['dept'] ) )
        {
            // if you only want to allow 'alpha-numerics':
            $dept =  preg_replace( "/[^a-zA-Z0-9]/", "", $query->query_vars['dept'] ); 

            // set up the meta query for geo_country
            $query->set( 'meta_key', 'place' );
            $query->set( 'meta_compare', 'LIKE' );
            $query->set( 'meta_value', '"postcode":"'.$dept );
        }

    } 
}

add_action( 'pre_get_posts', 'my_pre_get_posts' );

// ajout des dates au flux rss des événements
function fields_in_feed($content) {
    if(is_feed()) {
        $post_id = get_the_ID();
        $output = "";
        $content = get_field('description', $post_id); 
        $date = get_field('date', $post_id);
        $date_end = get_field('date_end', $post_id);
        if (!is_null($date)) {
			if (is_null($date_end)) {
				$output = "Le ".$date." ";
			} else {
				$output = "Du ";
				$output .= $date;
				$output .= " au ".$date_end." ";
			} 
		}
        $content = $output.$content;  
    }  
    return $content;  
}  

add_filter('the_content','fields_in_feed');
