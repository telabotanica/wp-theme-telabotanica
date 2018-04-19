<?php
// Filtres

// Si le titre est tout en majuscules, le convertir en minuscules
function telabotanica_filtre_majuscules( $content ) {

  if ( ctype_upper( $content ) ) {
    $content = strtolower( $content );
  }

  return $content;
}
// add_filter( 'wp_insert_post_data' , 'telabotanica_filtre_majuscules' , '99', 2 );
add_filter( 'content_save_pre', 'telabotanica_filtre_majuscules', 10, 1 );
