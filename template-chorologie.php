<?php
/**
 * Template pour l'affichage de Chorologie
 *
 * Amorce le fichier chorologie_wordpress.php contenu dans le code
 * de Chorologie; nécessite de remplir la configuration dans la page
 * "Applis externes" du Tableau de Bord Wordpress
 */
 /*
Template Name: chorologie
*/

$dossier_chorologie = get_field('applis_externes_chemin_chorologie', 'options');

// Cette variable globale sera utilisée par l'amorceur chorologie_wordpress.php
// @TODO faire moins bancal un jour
$chemin_chorologie_http = get_field('applis_externes_chemin_chorologie_http', 'options');

// Inclusion de l'appli
if (is_dir($dossier_chorologie)) {
	$chemin_chorologie = $dossier_chorologie . "/chorologie_wordpress.php";
	require $chemin_chorologie;

	// Rendu
	get_header();
	// fonctions définies dans chorologie_wordpress.php
	//echo chorologie_get_contenu_tete();
	//echo chorologie_get_contenu_navigation();
	echo chorologie_get_contenu();
	echo chorologie_get_contenu_pied();
} else {
	get_header();
	echo "Impossible de charger Chorologie, vérifiez la configuration.";
}

get_footer();
