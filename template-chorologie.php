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
	// get_header() doit être placé après le require sans quoi les
	// scripts et styles ne seront pas amorcés
	get_header();
	template_chorologie_entete();
	?>
	<div class="appli-chorologie">
		<?php
		// fonctions définies dans chorologie_wordpress.php
		//echo chorologie_get_contenu_tete();
		//echo chorologie_get_contenu_navigation();
		echo chorologie_get_contenu();
		echo chorologie_get_contenu_pied();
		?>
	</div>
	<?php
} else {
	get_header();
	template_chorologie_entete();
	?>
	<div class="component component-text">Impossible de charger Chorologie, vérifiez la configuration.</div>
	<?php
}

// fermeture des balises ouvertes par template_chorologie_entete() ?>
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
function template_chorologie_entete() {
	?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

	  <?php the_telabotanica_module('cover'); ?>

	  <div class="layout-left-col">
		<div class="layout-wrapper">
		  <aside class="layout-column">
			<?php
				$module = chorologie_get_module();
				the_telabotanica_module('toc', [
				'items' => [
					[
						'text' => 'Par département',
						'href' => '?module=liste-zones-geo',
						'active' => ($module == 'liste-zones-geo')
					],
					[
						'text' => 'Liste des taxons',
						'href' => '?module=liste-taxons',
						'active' => ($module == 'liste-taxons')
					],
					[
						'text' => 'Carte',
						'href' => '?module=carte',
						'active' => ($module == 'carte' || $module == 'carte-taxon')
					]
				]
			]); ?>
			<?php the_telabotanica_module('button-top'); ?>
		  </aside>
		  <div class="layout-content">
			<?php the_telabotanica_module('breadcrumbs'); ?>
			<article class="article">
				<div class="component component-title level-2">
					<h1 id="recherche-collections">Chorologie départementale</h1>
				</div>
				<div class="component component-text">
					<p>
						Consultez la répartition des espèces de France métropolitaine par département.
						<br>
						Ces données proviennent de la base <!--<a href="#">-->"Chorologie départementale" de Philippe Julve<!--</a>-->
						<br>
						Signalez une nouvelle entrée ou une erreur sur le <a href="http://www.tela-botanica.org/projets-9">projet chorologie départementale</a>
					</p>
				</div>
<?php }
