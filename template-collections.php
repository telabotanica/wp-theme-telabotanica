<?php
/**
 * Template pour l'affichage du moteur de recherche des collections (coel-consultation)
 *
 * Amorce le fichier collection_wordpress.php contenu dans le code
 * de coel-consultation; nécessite de remplir la configuration dans la page
 * "Applis externes" du Tableau de Bord Wordpress
 */
 /*
Template Name: collections
*/

$dossier_collections = get_field('applis_externes_chemin_collections', 'options');

// Cette variable globale sera utilisée par l'amorceur collection_wordpress.php
// @TODO faire moins bancal un jour
$chemin_collections_http = get_field('applis_externes_chemin_collections_http', 'options');

// Inclusion de l'appli
if (is_dir($dossier_collections)) {
	$chemin_collections = $dossier_collections . "/collection_wordpress.php";
	require $chemin_collections;

	// Rendu
	get_header();
	// (fonctions définies dans collection_wordpress.php)
	echo collections_get_contenu_tete();
	echo collections_get_contenu();
	echo collections_get_contenu_pied();
} else {
	get_header();
	echo "Impossible de charger le moteur de recherche des collections, vérifiez la configuration.";
}

get_footer();
