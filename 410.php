<?php
$GLOBALS['is_error'] = true;
get_header();

	the_telabotanica_module('error-page', [
		'type' => 410,
		'title' => __("La page que vous recherchez n'existe plus.", 'telabotanica')
	]);

get_footer();
