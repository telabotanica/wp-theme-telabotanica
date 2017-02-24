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
	// get_header() doit être placé après le require sans quoi les
	// scripts et styles ne seront pas amorcés
	get_header();
	template_collections_entete();
	?>
	<div class="appli-collections">
		<?php
		// (fonctions définies dans collection_wordpress.php)
		echo collections_get_contenu_tete();
		?>
		<div class="component component-title level-2">
			<h1 id="resultats-recherche-collections">Résultats de la recherche</h1>
		</div>
		<?php
		echo collections_get_contenu();
		echo collections_get_contenu_pied();
		?>
	</div>
	<?php
} else {
	get_header();
	template_collections_entete();
	?>
	<div class="component component-text">Impossible de charger le moteur de recherche des collections, vérifiez la configuration.</div>
	<?php
}

// fermeture des balises ouvertes par template_collections_entete() ?>
</article>
</div>
</div>
</div>
</main><!-- .site-main -->
</div><!-- .content-area -->

<?php
get_footer();

/**
 * Factorisation crado des éléments communs au cas général et au cas d'erreur, à
 * cause de la nécesité d'appeler get_header() après l'inclusion de l'appli
 */
function template_collections_entete() {
	?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

	  <?php the_telabotanica_module('cover'); ?>

	  <div class="layout-content-col">
		<div class="layout-wrapper">
		  <aside class="layout-column">
		  <?php
			$module = collections_get_module();
			the_telabotanica_module('toc', [
				'items' => [
					[
						'text' => 'Rechercher',
						'href' => '#recherche-collections',
						'active' => true,
						'items' => [
							[
								'text' => 'Rechercher une collection',
								'href' => '?module=Recherche#rechercher-parmi-collections',
								'active' => false
							],
							[
								'text' => 'Rechercher une personne',
								'href' => '?module=Recherche#rechercher-parmi-personnes',
								'active' => false
							],
							[
								'text' => 'Rechercher une publication',
								'href' => '?module=RecherchePublications',
								'active' => ($module == 'RecherchePublications')
							]
						]
					],
					[
						'text' => 'Résultats de recherche',
						'href' => '#resultats-recherche-collections',
						'active' => false
					]
				]
			]); ?>
			<?php the_telabotanica_module('button-top'); ?>
		  </aside>
		  <div class="layout-content">
			<?php the_telabotanica_module('breadcrumbs'); ?>
			<article class="article">
				<div class="component component-title level-2">
					<h1 id="recherche-collections">Rechercher parmi les collections</h1>
				</div>
				<div class="component component-text">
					<p>
						Recherchez une collection botanique, une institution hébergeant un herbier, une personne ou une publication.
						<br>
						Complétez l'inventaire sur <a href="https://beta.tela-botanica.org/preprod/outils/collections-en-ligne">Collections En Ligne</a>
					</p>
				</div>
<?php }
