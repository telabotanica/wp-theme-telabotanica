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

	// Si l'excerpt est toujours vide, on essaye d'utiliser la description
	if ( empty( $post_excerpt ) && get_field('description') ) :
		$post_excerpt = get_field('description');
	endif;

	// On recoupe l'excerpt à 30 mots, et on change le suffixe
	return wp_trim_words( $post_excerpt, 30, '&nbsp;&hellip;' );

}
add_filter( 'get_the_excerpt', 'telabotanica_custom_excerpt' );

// Raccourcir l'excerpt des descriptions de groupes BuddyPress
function telabotanica_group_description_excerpt( $excerpt ) {
	// On recoupe l'excerpt à 20 mots, et on change le suffixe
	return wp_trim_words( strip_tags($excerpt), 25, '&nbsp;&hellip;' );
}
add_filter( 'bp_get_group_description_excerpt', 'telabotanica_group_description_excerpt', 99 );
