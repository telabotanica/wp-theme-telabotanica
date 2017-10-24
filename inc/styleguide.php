<?php
/**
 * Fonctions du style guide
 *
 * Ces fonctions permettent de charger les modules, les blocs et les composants du styleguide.
 * Elles suivent les conventions de nommage de wordpress:
 *		`the_*` pour les fonctions qui affichent un élément
 *		`get_*` pour les fonctions qui retournent un élément
 *
 * Elles utilisent également l'espace de nommage `telabotanica` pour éviter
 * les collisions.
 *
 * @package WordPress
 * @subpackage Tela_Botanica
 */

 /**
	* Liste de tous les modules accessibles depuis les fonctions du styleguide
	*/
$telabotanica_modules = [
	'article',
	'autocomplete',
	'breadcrumbs',
	'block-dashboard',
	'block-dashboard-images',
	'block-dashboard-map',
	'block-dashboard-observations',
	'button',
	'button-top',
	'card-project',
	'categories',
	'categories-labels',
	'column-articles',
	'column-features',
	'column-links',
	'comment-form',
	'comments',
	'cover',
	'cover-home',
	'cover-member',
	'cover-project',
	'cover-search',
	'error-page',
	'event-dates',
	'feed',
	'feed-item',
	'footer',
	'header',
	'header-dashboard',
	'icon',
	'list-articles',
	'list-articles-item',
	'list-projects',
	'map-events',
	'meta-news',
	'nav-dashboard',
	'nav-project',
	'nav-tabs',
	'notice',
	'notice-cookies',
	'newsletter',
	'pagination',
	'search-box',
	'search-filters',
  'search-hit',
	'search-results',
	'share',
	'title',
	'toc',
	'upcoming-events',
];
array_walk($telabotanica_modules, function ($module) {
	if (!locate_template('modules/' . $module . '/' . $module . '.php', true, true)) {
		trigger_error(sprintf(__('Erreur lors de la recherche de %s pour inclusion', 'telabotanica'), $module), E_USER_ERROR);
	}
});

/**
 * Liste de tous les composants accessibles depuis les fonctions du styleguide
 */
$telabotanica_blocks = [
	'contribute',
	'focus',
	'list-features',
	'list-projects',
	'main-features',
	'maps',
	'mosaic',
];
array_walk($telabotanica_blocks, function ($block) {
 if (!locate_template('blocks/' . $block . '/' . $block . '.php', true, true)) {
	 trigger_error(sprintf(__('Erreur lors de la recherche de %s pour inclusion', 'telabotanica'), $block), E_USER_ERROR);
 }
});

/**
 * Liste de tous les composants accessibles depuis les fonctions du styleguide
 */
$telabotanica_components = [
	'accordion',
	'articles',
	'buttons',
	'contact',
	'embed',
	'image',
	'info',
	'intro',
	'links',
	'map',
	'tools',
	'text',
	'title',
];
array_walk($telabotanica_components, function ($component) {
 if (!locate_template('components/' . $component . '/' . $component . '.php', true, true)) {
	 trigger_error(sprintf(__('Erreur lors de la recherche de %s pour inclusion', 'telabotanica'), $component), E_USER_ERROR);
 }
});

/**
 * Affiche un module
 * @param string $module Nom du module.
 * @param mixed[] $data Données utilisées par le module.
 */
function the_telabotanica_module($module, $data = []) {
	the_telabotanica_styleguide_element('module', $module, $data);
}

/**
 * Retourne un module
 * @param string $module Nom du module.
 * @param mixed[] $data Données utilisées par le module.
 * @return string Le code HTML du module.
 */
function get_telabotanica_module($module, $data = []) {
	return get_telabotanica_styleguide_element('module', $module, $data);
}

/**
 * Affiche un bloc
 * @param string $bloc Nom du bloc.
 * @param mixed[] $data Données utilisées par le bloc.
 */
function the_telabotanica_block($block, $data = []) {
	the_telabotanica_styleguide_element('block', $block, $data);
}

/**
 * Retourne un bloc
 * @param string $block Nom du bloc.
 * @param mixed[] $data Données utilisées par le bloc.
 * @return string Le code HTML du bloc.
 */
function get_telabotanica_block($block, $data = []) {
	return get_telabotanica_styleguide_element('block', $block, $data);
}

/**
 * Affiche un composant
 * @param string $component Nom du composant.
 * @param mixed[] $data Données utilisées par le composant.
 */
function the_telabotanica_component($component, $data = []) {
	the_telabotanica_styleguide_element('component', $component, $data);
}

/**
 * Retourne un composant
 * @param string $component Nom du composant.
 * @param mixed[] $data Données utilisées par le composant.
 * @return string Le code HTML du composant.
 */
function get_telabotanica_component($component, $data = []) {
	return get_telabotanica_styleguide_element('component', $component, $data);
}

/**
 * Affiche un élément du styleguide
 * @param string $type Type d'élément (module, block ou component)
 * @param string $name Nom de l'élément
 * @param mixed[] $data Données utilisées par l'élément.
 */
function the_telabotanica_styleguide_element($type, $name, $data) {
	$function = 'telabotanica_' . $type . '_' . str_replace('-', '_', $name);
	if (function_exists($function)) {
		$data = (object) $data;
		call_user_func($function, $data);
	} else {
		trigger_error(sprintf(__('Le %s `%s` n\'existe pas dans le styleguide. Avez-vous pensé à l\'ajouter à la liste des éléments dans inc/styleguide.php ?', 'telabotanica'), $type, $name), E_USER_WARNING);
	}
}

/**
 * Retourne un élément du styleguide (module, bloc ou composant)
 * @param string $type Type d'élément (module, block ou component)
 * @param string $name Nom de l'élément
 * @param mixed[] $data Données utilisées par l'élément.
 * @return string Le code HTML de l'élément.
 */
function get_telabotanica_styleguide_element($type, $name, $data) {
	ob_start();
	the_telabotanica_styleguide_element($type, $name, $data);
	return ob_get_clean();
}

/**
 * Ajout des filtres et actions nécessaires
 */

// Sélection du template styleguide en fonction du paraètre `pagename`
function telabotanica_styleguide_page_template( $template ) {
	global $wp_query;
	if ( $wp_query->query_vars['pagename'] === 'styleguide' ) {
		$new_template = locate_template('styleguide.php');
		if ( '' != $new_template ) {
			return $new_template ;
		}
	}
	return $template;
}
add_filter( 'template_include', 'telabotanica_styleguide_page_template', 99 );

// Merging des data avec les défauts
function telabotanica_styleguide_data($defaults, $data) {
	$data = (object) array_merge((array) $defaults, (array) $data);
	return $data;
}

// Interprétation des modifiers
function telabotanica_styleguide_modifiers_array($default, $modifiers) {
	if (!is_array($default))   $default = explode(' ', $default);
	if (!is_array($modifiers)) $modifiers = explode(' ', $modifiers);
	return array_merge($default, $modifiers);
}

// Définition des paramètres d'URL
function telabotanica_styleguide_rewrite_tags() {
	add_rewrite_tag('%styleguide_type%', '([^&]+)');
	add_rewrite_tag('%styleguide_nom%', '([^&]+)');
}
add_action('init', 'telabotanica_styleguide_rewrite_tags', 10, 0);

// Définition des règles de réécriture d'URL
function telabotanica_styleguide_rewrite_rules() {
	add_rewrite_rule('^styleguide/([^/]*)/([^/]*)/?', 'index.php?pagename=styleguide&styleguide_type=$matches[1]&styleguide_nom=$matches[2]', 'top');
	add_rewrite_rule('^styleguide/?', 'index.php?pagename=styleguide', 'top');
}
add_action('init', 'telabotanica_styleguide_rewrite_rules', 10, 0);

// Vider le cache des routes après leur création
function telabotanica_styleguide_flush_rules(){
	$rules = get_option( 'rewrite_rules' );

	if ( !isset( $rules['^styleguide/?'] ) ) {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}
}
add_action( 'wp_loaded', 'telabotanica_styleguide_flush_rules' );

// Définition du <title> des pages
function telabotanica_styleguide_title( $title ) {
	global $wp_query;
	if ( $wp_query->query_vars['pagename'] !== 'styleguide' ) { return $title; }

	$prefix = '';
	if ($wp_query->get('styleguide_type') && $wp_query->get('styleguide_nom')) {
		$type = $wp_query->get('styleguide_type');
		$name = $wp_query->get('styleguide_nom');
		$prefix = $type . ' ' . $name . ' &#8211; ';
	}

	return $prefix . 'Styleguide' . ' &#8211; ' . get_bloginfo('name');
}
add_filter( 'pre_get_document_title', 'telabotanica_styleguide_title', 10, 2 );
