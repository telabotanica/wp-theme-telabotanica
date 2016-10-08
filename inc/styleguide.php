<?php
/**
 * Fonctions du style guide
 *
 * Ces fonctions permettent de charger les modules et composants du styleguide.
 * Elles suivent les conventions de nommage de wordpress:
 *    `the_*` pour les fonctions qui affichent un élément
 *    `get_*` pour les fonctions qui retournent un élément
 *
 * Elles utilisent également l'espace de nommage `telabotanica` pour éviter
 * les collisions.
 *
 * @package WordPress
 * @subpackage Tela_Botanica
 * @since TelaBotanica 0.0.1
 */

 /**
  * Liste de tous les modules accessibles depuis les fonctions du styleguide
  */
$telabotanica_modules = [
    'bouton'
];
array_walk($telabotanica_modules, function ($module) {
  if (!locate_template('modules/' . $module . '/module.php', true, true)) {
    trigger_error(sprintf(__('Erreur lors de la recherche de %s pour inclusion', 'telabotanica'), $file), E_USER_ERROR);
  }
});

/**
 * Liste de tous les composants accessibles depuis les fonctions du styleguide
 */
$telabotanica_composants = [
  'boutons'
];
array_walk($telabotanica_composants, function ($composant) {
 if (!locate_template('composants/' . $composant . '/composant.php', true, true)) {
   trigger_error(sprintf(__('Erreur lors de la recherche de %s pour inclusion', 'telabotanica'), $file), E_USER_ERROR);
 }
});

/**
 * Affiche un module
 * @param string $module Nom du module.
 * @param mixed[] $data Données utilisées par le module.
 */
function the_telabotanica_module($module, $data) {
  the_telabotanica_styleguide_element('module', $module, $data);
}

/**
 * Retourne un module
 * @param string $module Nom du module.
 * @param mixed[] $data Données utilisées par le module.
 * @return string Le code HTML du module.
 */
function get_telabotanica_module($module, $data) {
  return get_telabotanica_styleguide_element('module', $module, $data);
}

/**
 * Affiche un composant
 * @param string $module Nom du composant.
 * @param mixed[] $data Données utilisées par le composant.
 */
function the_telabotanica_composant($composant, $data) {
  the_telabotanica_styleguide_element('composant', $composant, $data);
}

/**
 * Retourne un composant
 * @param string $module Nom du composant.
 * @param mixed[] $data Données utilisées par le composant.
 * @return string Le code HTML du composant.
 */
function get_telabotanica_composant($composant, $data) {
  return get_telabotanica_styleguide_element('composant', $composant, $data);
}

/**
 * Affiche un élément du styleguide
 * @param string $type Type d'élément (module ou composant)
 * @param string $nom Nom de l'élément
 * @param mixed[] $data Données utilisées par l'élément.
 */
function the_telabotanica_styleguide_element($type, $nom, $data) {
  $function = 'telabotanica_' . $type . '_' . $nom;
  if (function_exists($function)) {
    $data = (object) $data;
    call_user_func($function, $data);
  } else {
    trigger_error(sprintf(__('Le %s `%s` n\'existe pas dans le styleguide.', 'telabotanica'), $type, $nom), E_USER_WARNING);
  }
}

/**
 * Retourne un élément du styleguide (module ou composant)
 * @param string $type Type d'élément (module ou composant)
 * @param string $nom Nom de l'élément
 * @param mixed[] $data Données utilisées par l'élément.
 * @return string Le code HTML de l'élément.
 */
function get_telabotanica_styleguide_element($type, $nom, $data) {
  ob_start();
  the_telabotanica_styleguide_element($type, $nom, $data);
  return ob_get_clean();
}
