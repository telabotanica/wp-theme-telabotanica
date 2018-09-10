<?php

/**
 *
 * Display city name when has apostrophe
 * Replicated and modified from plugins/buddypress/bp-xprofile/bp-xprofile-filters.php
 * refer to xprofile_filter_link_profile_data()
 *
 */
remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 3 );
add_filter( 'bp_get_the_profile_field_value', 'tb_profile_filter_link_profile_data', 9, 3 );
function tb_profile_filter_link_profile_data( $field_value, $field_type = 'textbox' ) {
  global $field;

  if ( ! $field->get_do_autolink() ) {
    // Used for :
    // 'Pseudo', 'Prénom', 'Nom', 'Inscription à la lettre d’actualité',
    // 'Conditions d’utilisation', 'Membre d'une association naturaliste'
    return $field_value;
  }

  // Field values in our profile display :
  // Condition ( 'datebox' === $field_type ) always false
  // Condition ( strpos( $field_value, ',' ) === false && strpos( $field_value, ';' ) === false && ( count( explode( ' ', $field_value ) ) > 5 ) ) always false

  if ( $field->id === 4 ) {// Field 'ville'
    // No need to explode $field_values
    // that introduces undesirable effect on city name display
    $values = $field_value;
  } else { // Condition strpos( $field_value, ',' ) always false
    // Used for
    // 'Pays', 'Département', 'Expérience botanique'
    $list_type = 'semicolon';
    $values = explode( ';', $field_value ); // Semicolon-separated lists.
  }

  if ( ! empty( $values ) ) {

    foreach ( (array) $values as $value ) {
      $value = trim( $value );
      // In our profile display :
      // $value is not URL
      // Condition count( explode( ' ', $value ) ) > 5 ) always false
      $query_arg       = bp_core_get_component_search_query_arg( 'members' );
      $search_url      = add_query_arg( array( $query_arg => urlencode( $value ) ), bp_get_members_directory_permalink() );
      $new_values[]    = '<a href="' . esc_url( $search_url ) . '" rel="nofollow">' . $value . '</a>';
    }

    // In our profile display :
    // ( 'comma' === $list_type ) always false
    $values = implode( '; ', $new_values );
  }

  return $values;
}

