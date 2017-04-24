<?php
// Si un post n'a pas de vignette, essayer d'en ajouter une
function telabotanica_set_featured_image( $post_id ) {
	// Ne pas réécrire une vignette existante
	if ( has_post_thumbnail( $post_id ) ) return;

	// Pour les évènements (qui contiennent un champ image optionnel)
	$image = get_field('image', $post_id, false);

	if ( $image ) {
		// Définir comme vignette
		update_post_meta($post_id, '_thumbnail_id', $image);
		return;
	}

	// Pour les posts utilisant des composants
	$flexible_content = get_field('components', $post_id, false);

	if ( $flexible_content ) {
		foreach ($flexible_content as $row) {
			// Trouver le premier composant image
			if ( $row['acf_fc_layout'] == 'image' && isset($row['field_582c849d8668f_field_582c67ba3c90e']) ){
				// Définir comme vignette
				update_post_meta($post_id, '_thumbnail_id', $row['field_582c849d8668f_field_582c67ba3c90e']);
				break;
			}
		}
	}
}
// Déclenché quand ACF sauve les données $_POST['acf']
add_action('acf/save_post', 'telabotanica_set_featured_image', 20);


// Ajout d'une query_var `categorie` (pour la page "Proposer une actulité")
function telabotanica_add_categorie_query_var( $vars ){
	$vars[] = "categorie";
	return $vars;
}
add_filter( 'query_vars', 'telabotanica_add_categorie_query_var' );
