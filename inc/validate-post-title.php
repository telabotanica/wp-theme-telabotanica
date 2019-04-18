<?php

// Si le titre est tout en majuscule on corrige car c'est moche
function telabotanica_check_title_for_uppercase( $data, $postarr ) {
  $user = wp_get_current_user();
  if (!in_array('administrator', (array) $user->roles)) {
    $title = $postarr['post_title'];

    // on ne considère par les blancs car certains ont une version majuscule
    $clean_title = preg_replace( '/\s+/', '', $title );
    $title_upper = str_split( mb_strtoupper( $clean_title ) );
    $title_original = str_split( $clean_title );

    // On calcule le ratio de différences entre le titre original et sa version en
    // majuscules (c'est tordu là mais c'est pour éviter la division par 0)
    // Vers 1 on a moult majuscules et vers 0 on a une absence de majuscules
    $rate = ( count( $title_original ) - count( array_diff_assoc( $title_upper, $title_original ) ) ) / count( $title_original ) ;

    if ( $rate > 0.5 ) {
      $title = ucfirst( mb_strtolower( $title ) );
    }

    $data['post_title'] = $title;
  }

  return $data;
}

add_filter( 'wp_insert_post_data', 'telabotanica_check_title_for_uppercase', 99, 2 );
