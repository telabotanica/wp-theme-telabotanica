<?php
/**
 * Catégorie d'outils
 */

// Rediriger vers la page Outils, avec une ancre
global $wp;
$url = home_url(add_query_arg(array(),$wp->request));
$url = preg_replace("/(.+)\/categorie\/(.+)\/?$/", "$1/#$2", $url);
wp_redirect( $url );
exit;
