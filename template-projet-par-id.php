<?php
/**
 * Template pour rediriger vers un projet en fonction de son ID
 */
 /*
Template Name: projet-par-id
*/

$id = false;
// si le paramètre "id" est fourni
if (! empty($_GET['id']) && is_numeric($_GET['id'])) {
	$id = $_GET['id'];
} else { // sinon on fouille dans l'URL
	$parsedUrl = wp_parse_url("//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	if (! empty($parsedUrl['path'])) {
		$urlParts = explode('/', $parsedUrl['path']);
		if (count($urlParts > 0)) {
			$lastPart = array_pop($urlParts);
			while ($lastPart == "") {
				$lastPart = array_pop($urlParts);
			}
			if (is_numeric($lastPart)) {
				$id = $lastPart;
			}
		}
	}
}

// recherche de l'URL du groupe par son ID
// si le groupe n'existe pas, le permalink pointera sur la liste des groupes (pratique)
$group = groups_get_group(array('group_id' => $id));
$permalink = bp_get_group_permalink($group);
wp_redirect($permalink);
