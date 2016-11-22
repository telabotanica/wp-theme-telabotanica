<?php
/**
 * Template pour l'affichage d'eFlore
 *
 * Amorce le fichier eflore_wordpress.php contenu dans le code
 * d'eflore-consultation; nécessite de remplir la configuration dans la page
 * "Applis externes" du Tableau de Bord Wordpress
 */
 /*
Template Name: eflore
*/

$dossier_eflore = get_field('applis_externes_chemin_eflore', 'options');
$chemin_eflore_http = get_field('applis_externes_chemin_eflore_http', 'options');

// Inclusion de l'appli
if (is_dir($dossier_eflore)) {
	$chemin_eflore = $dossier_eflore . "/eflore_wordpress.php";
	include $chemin_eflore;
} else {
	echo "Impossible de charger eFlore, vérifiez la configuration.";
}

// Rendu
get_header();
$content_class = [ 'main-content-inner' ];
echo eflore_get_contenu(); // défini dans eflore_wordpress.php
get_footer();
