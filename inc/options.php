<?php

if( function_exists('acf_add_options_page') ) {

	// Options pour la lettre d'actu
	acf_add_options_page(array(
		'page_title' 	=> 'Composer',
		'menu_title'	=> 'Composer la newsletter',
		'menu_slug' 	=> 'newsletter_compose',
		'parent_slug'	=> 'newsletter',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}
