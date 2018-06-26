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

// Cette variable globale sera utilisée par l'amorceur eflore_wordpress.php
// @TODO faire moins bancal un jour
$chemin_eflore_http = get_field('applis_externes_chemin_eflore_http', 'options');

// Inclusion de l'appli
if (is_dir($dossier_eflore)) {
  $chemin_eflore = $dossier_eflore . "/eflore_wordpress.php";
  require $chemin_eflore;

  // Rendu
  $content_class = [ 'main-content-inner' ];
  get_header();

  // bandeau avec moteur de recherche
  $eflore_page = get_page_by_path( 'eflore' );
  the_telabotanica_module('cover', [
    'image' => get_field('cover_image', $eflore_page),
    'title' => get_the_title($eflore_page),
    'subtitle' => get_field('cover_subtitle', $eflore_page),
    'search' => [
      'index' => 'flore',
      'placeholder' => __('Rechercher un nom, un taxon...', 'telabotanica'),
      'instantsearch' => true,
      // 'facetFilters' => 'referentiels:bdtfx'
    ]
  ]);

  echo eflore_get_contenu(); // défini dans eflore_wordpress.php
} else {
  get_header();
  echo "Impossible de charger eFlore, vérifiez la configuration.";
}

get_footer();
