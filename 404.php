<?php

$GLOBALS['is_error'] = true;
get_header();

	the_telabotanica_module('error-page', [
		'type'  => 404,
		'title' => __('La page que vous demandez est introuvable.', 'telabotanica')
	]);

get_footer();
