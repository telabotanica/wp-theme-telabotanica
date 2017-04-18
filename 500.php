<?php
$GLOBALS['is_error'] = true;
get_header();

	the_telabotanica_module('error-page', [
		'type' => 500,
		'title' => __("Erreur interne au serveur.", 'telabotanica')
	]);

get_footer();
