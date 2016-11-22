<?php

if( function_exists('acf_add_options_page') ) {

  // Options pour la lettre d'actu
  acf_add_options_page(array(
    'page_title'  => __( "Lettre d'actu", 'telabotanica' ),
    'menu_title'  => __( "Lettre d'actu", 'telabotanica' ),
    'menu_slug'   => 'newsletter',
    'capability'  => 'edit_posts',
    'position'    => 30.3,
    'icon_url'    => 'dashicons-email-alt',
    'redirect'    => false
	));

}
