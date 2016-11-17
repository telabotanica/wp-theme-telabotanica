<?php

/**
 * Filter the except length to 20 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function telabotanica_custom_excerpt( $post_excerpt ) {

  // On ajoute l'intro au début de l'excerpt s'il y en a une
  if ( get_field('intro') ) :
    $post_excerpt = get_field('intro') . ' ' . $post_excerpt;
  endif;

  // On recoupe l'excerpt à 20 mots, et on change le suffixe
  return wp_trim_words( $post_excerpt, 30, '&nbsp;&hellip;' );

}
add_filter( 'get_the_excerpt', 'telabotanica_custom_excerpt' );
