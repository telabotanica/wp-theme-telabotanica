<?php
// Si un post n'a pas de vignette, utiliser le premier composant image
function telabotanica_set_featured_image( $post_id ) {

	$flexible_content = get_field('components', $post_id, false);

	// ne pas réécrire une vignette existante
	if ( has_post_thumbnail( $post_id ) ) return;

	if ( $flexible_content ) {
		foreach ($flexible_content as $row) {
			// check if the image is set in certain layout
			if ( $row['acf_fc_layout'] == 'image' && isset($row['field_582c849d8668f_field_582c67ba3c90e']) ){
				// update the featured image
				update_post_meta($post_id, '_thumbnail_id', $row['field_582c849d8668f_field_582c67ba3c90e']);
				break;
			}
		}
	}

}
// run after ACF saves the $_POST['acf'] data
add_action('acf/save_post', 'telabotanica_set_featured_image', 20);
