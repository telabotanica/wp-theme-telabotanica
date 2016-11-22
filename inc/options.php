<?php

if( function_exists('acf_add_options_page') ) {

	// Options pour les Actualités
	acf_add_options_page(array(
		'page_title' 	=> __( "Lettre d'actu", 'californiefrancaise' ),
		'menu_title'	=> __( "Lettre d'actu", 'californiefrancaise' ),
		'menu_slug' 	=> 'newsletter',
		'capability'	=> 'edit_posts',
		'position'    => 30.3,
		'icon_url'    => 'dashicons-email-alt',
		'redirect'		=> false
	));

	// Options pour les application externes intégrées (eFlore, Chorologie...)
	acf_add_options_page(array(
		'page_title' 	=> __( "Applis externes", 'tb_applis_externes' ),
		'menu_title'	=> __( "Applis externes", 'tb_applis_externes' ),
		'menu_slug' 	=> 'tb_applis_externes',
		'capability'	=> 'administrator',
		'position'    => 105,
		'icon_url'    => 'dashicons-screenoptions',
		'redirect'		=> false
	));
}