<?php

/**
 * Get current page depth
 *
 * @return integer
 */
function get_current_page_depth(){
	global $wp_query;

	$object = $wp_query->get_queried_object();
	$parent_id  = $object->post_parent;
	$depth = 0;
	while($parent_id > 0){
		$page = get_page($parent_id);
		$parent_id = $page->post_parent;
		$depth++;
	}

 	return $depth;
}

/**
 * Format place (saved using ACF field Algolia Places)
 *
 * @return string
 */
function telabotanica_format_place($place, $icon = true) {

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
