<?php

/**
 * Get current page depth
 *
 * @return integer
 */
function get_current_page_depth(){
	global $wp_query;

	$object = $wp_query->get_queried_object();
	$parent_id = $object->post_parent;
	$depth = 0;
	while($parent_id > 0){
		$page = get_page($parent_id);
		$parent_id = $page->post_parent;
		$depth++;
	}

 	return $depth;
}

/**
 * Tests if any of a post's assigned categories are descendants of target categories
 * source: http://wordpress.stackexchange.com/questions/155332/check-if-a-post-is-in-any-child-category-of-a-parent-category
 *
 * @param int|string|array $cats The target categories. Integer ID or array of integer IDs or string slug or array of string slugs
 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Passes $cats
 * @uses in_category() Passes $_post (can be empty)
 * @version 2.7
 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
 */
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
		function post_is_in_descendant_category( $cats, $_post = null ) {
				foreach ( (array) $cats as $cat ) {
						// get_term_children() accepts integer ID only
						if ( is_string( $cat ) ) $cat = get_category_by_slug( $cat )->cat_ID;
						$descendants = get_term_children( (int) $cat, 'category' );
						if ( $descendants && in_category( $descendants, $_post ) )
								return true;
				}
				return false;
		}
}

/**
 * Format place (saved using ACF field Algolia Places)
 *
 * @return string
 */
function telabotanica_format_place( $place, $icon = true ) {

	if ( !is_object( $place ) ) return $place;

	$template = '%s %s (%s)';

	if ( $icon ) {
		$icon = get_telabotanica_module('icon', ['icon' => 'marker']);
	}

	if ( $place->countryCode !== 'fr' ) {
		$code = strtoupper( $place->countryCode );
	} else if ( isset( $place->postcode ) ) {
		$code = substr( $place->postcode, 0, 2 );
	} else {
		$code = $place->administrative;
	}

	if ( isset( $place->city ) ) {
		$city = $place->city;
	} else {
		$city = $place->name;
	}

	$place = sprintf(
		$template,
		$icon,
		$city,
		$code
	);

 	return $place;
}

/**
 * Maintenance page
 */
if ( ! function_exists( 'telabotanica_maintenance_mode' ) ) {
	function telabotanica_maintenance_mode() {
		if ( file_exists( ABSPATH . '.maintenance' ) ) {
			include_once get_stylesheet_directory() . '/maintenance.php';
			die();
		}
	}
	add_action( 'wp', 'telabotanica_maintenance_mode' );
}
