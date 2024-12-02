<?php

/**
 * Display city name when has apostrophe
 * Replicated and modified from plugins/buddypress/bp-xprofile/bp-xprofile-filters.php
 * refer to xprofile_filter_link_profile_data()
 */
remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 3 );
add_filter( 'bp_get_the_profile_field_value', 'tb_profile_filter_link_profile_data', 9, 3 );
function tb_profile_filter_link_profile_data( $field_value, $field_type = 'textbox' ) {
  global $field;

  if ( !$field->get_do_autolink() ) {
    // Used for :
    // 'Pseudo', 'Prénom', 'Nom', 'Inscription à la lettre d’actualité',
    // 'Conditions d’utilisation', 'Membre d'une association naturaliste'
    return $field_value;
  }

  // Field values in our profile display :
  // Condition ( 'datebox' === $field_type ) always false
  // Condition ( strpos( $field_value, ',' ) === false && strpos( $field_value, ';' ) === false && ( count( explode( ' ', $field_value ) ) > 5 ) ) always false

  if ( 4 === $field->id ) { // Field 'ville'
    // No need to explode $field_value
    // that introduces undesirable effect on city name display
    $values = $field_value;
  } else { // Condition strpos( $field_value, ',' ) always false
    // Used for
    // 'Pays', 'Département', 'Expérience botanique'
    $list_type = 'semicolon';
    $values = explode( ';', $field_value ); // Semicolon-separated lists.
  }

  if ( !empty( $values ) ) {

    foreach ( (array) $values as $value ) {
      $value = trim( $value );
      $displayed_value = $value;
      // If value is a country iso code
      if ( 3 === $field->id && 2 === strlen( $value ) && ctype_upper( $value ) ) {
        // Displayed value is country name
        $displayed_value = retrieve_country_name_from_iso( $value );
      }
      // In our profile display :
      // $value is not URL
      // Condition count( explode( ' ', $value ) ) > 5 ) always false

      if( $displayed_value !== $value ) {
      // Suitable search url for countries :
        $keys = array(
          'countries' => urlencode( $value ) ,
          'tb_search' => urlencode( $displayed_value )
        );
      } else {
      // This is riginal search query string, in xprofile_filter_link_profile_data() :
      // /?members_search=$value :
        $keys = array( bp_core_get_component_search_query_arg( 'members' ) => urlencode( $value ) );
      }
      $search_url   = add_query_arg( $keys , bp_get_members_directory_permalink() );
      $new_values[] = '<a href="' . esc_url( $search_url ) . '" rel="nofollow">' . $displayed_value . '</a>';
    }

    // In our profile display :
    // ( 'comma' === $list_type ) always false
    $values = implode( '; ', $new_values );
  }

  return $values;
}

/**
 * Add country and new members_search to query vars
 */
add_filter( 'query_vars', 'add_custom_query_var' );
function add_custom_query_var( $vars ){
  $vars[] .= 'countries';
  $vars[] .= 'tb_search';
  return $vars;
}

/**
 * Retrieve country name from iso code
 *
 * @return string
 */
function retrieve_country_name_from_iso( $iso ) {
  global $wpdb;

  $country_name = $wpdb->get_var( $wpdb->prepare(
    "SELECT pays_officiel
    FROM {$wpdb->prefix}pays
    WHERE iso = %s",
    $iso
  ));

  if( 0 >= count( $country_name ) ) {
    return false;
  }
  return $country_name;
}

/**
 * Retrieve user ids from search values
 *
 * @return array
 */
function tb_members_custom_ids( $field_value, $field_id = null ) {
  global $wpdb;

  $query = "SELECT user_id FROM " . $wpdb->prefix . "bp_xprofile_data WHERE";
  $values = explode ( ',' , $field_value );

  $query .= " value = '" . $values[0] . "'";

  array_shift( $values );
  if ( 0 < count( $values ) ) {
    foreach ( $values as $value ) {
      $query .= " OR value = '" . $value . "'";
    }
  }

  if ( !is_null( $field_id ) ) {
    $query .= " AND field_id = " . $field_id;
  }

  return $wpdb->get_col( $query );
}

/**
 * When custom members search with countries (iso), pagination must be reset
 */
function telabotanica_bp_get_custom_pagination( $links ) {
  global $members_count_custom_search;
  global $members_template;
  if( !is_null( $members_count_country_search ) ) :
    $links = paginate_links([
      'base'      => add_query_arg( 'upage' , '%#%' ),
      'total'     => ceil( (int) $members_count_country_search / (int) $members_template->pag_num ),
      'format'    => '',
      'current'   => (int) $members_template->pag_page,
      'prev_text' => _x( '&larr;', 'Member pagination previous text', 'buddypress' ),
      'next_text' => _x( '&rarr;', 'Member pagination next text', 'buddypress' ),
      'mid_size'  => 1,
      'add_args'  => false,
    ]);
  endif;
  return $links;
}
add_filter( 'bp_get_members_pagination_links', 'telabotanica_bp_get_custom_pagination', 10, 1 );
