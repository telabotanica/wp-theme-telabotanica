<?php

// Pages thématiques
function telabotanica_thematique_post_type() {
	$labels = array(
		'name'                  => _x( 'Thématiques', 'Post Type General Name', 'telabotanica' ),
		'singular_name'         => _x( 'Thématique', 'Post Type Singular Name', 'telabotanica' ),
		'menu_name'             => __( 'Thématiques', 'telabotanica' ),
		'name_admin_bar'        => __( 'Thématiques', 'telabotanica' ),
		'archives'              => __( 'Toutes les thématiques', 'telabotanica' ),
		'parent_item_colon'     => __( 'Thématique parente :', 'telabotanica' ),
		'all_items'             => __( 'Toutes les thématiques', 'telabotanica' ),
		'add_new_item'          => __( 'Ajouter une thématique', 'telabotanica' ),
		'add_new'               => __( 'Nouvelle thématique', 'telabotanica' ),
		'new_item'              => __( 'Nouvelle thématique', 'telabotanica' ),
		'edit_item'             => __( 'Modifier la thématique', 'telabotanica' ),
		'update_item'           => __( 'Mettre à jour la thématique', 'telabotanica' ),
		'view_item'             => __( 'Voir la thématique', 'telabotanica' ),
		'search_items'          => __( 'Chercher la thématique', 'telabotanica' ),
		'not_found'             => __( 'Aucune thématique.', 'telabotanica' ),
		'not_found_in_trash'    => __( 'Aucune thématique dans la corbeille.', 'telabotanica' ),
		'featured_image'        => __( 'Image principale', 'telabotanica' ),
		'set_featured_image'    => __( 'Définir une image principale', 'telabotanica' ),
		'remove_featured_image' => __( 'Enlever l\'image principale', 'telabotanica' ),
		'use_featured_image'    => __( 'Utiliser comme image principale', 'telabotanica' ),
		'insert_into_item'      => __( 'Insert into item', 'telabotanica' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'telabotanica' ),
		'items_list'            => __( 'Liste des thématiques', 'telabotanica' ),
		'items_list_navigation' => __( 'Items list navigation', 'telabotanica' ),
		'filter_items_list'     => __( 'Filter items list', 'telabotanica' ),
		);

	$rewrite = array(
		'slug'                  => 'thematiques',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);

	register_post_type( 'tb_thematique',
		array(
			'labels' => $labels,
			'description' => __( 'Page thématique', 'telabotanica' ),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 21,
			'menu_icon' => 'dashicons-media-document',
			'capability_type' => 'page',
			'supports' => array(
				'title',
				'editor',
				'revisions',
				'page-attributes'
			),
			'hierarchical' => true,
			'rewrite' => $rewrite
		)
	);
}
add_action( 'init', 'telabotanica_thematique_post_type' );

// Outils
function telabotanica_outil_post_type() {
	$labels = array(
		'name'                  => _x( 'Outils', 'Post Type General Name', 'telabotanica' ),
		'singular_name'         => _x( 'Outil', 'Post Type Singular Name', 'telabotanica' ),
		'menu_name'             => __( 'Outils', 'telabotanica' ),
		'name_admin_bar'        => __( 'Outils', 'telabotanica' ),
		'archives'              => __( 'Tous les outils', 'telabotanica' ),
		'all_items'             => __( 'Tous les outils', 'telabotanica' ),
		'add_new_item'          => __( 'Ajouter un outil', 'telabotanica' ),
		'add_new'               => __( 'Nouvel outil', 'telabotanica' ),
		'new_item'              => __( 'Nouvel outil', 'telabotanica' ),
		'edit_item'             => __( 'Modifier cet outil', 'telabotanica' ),
		'update_item'           => __( 'Mettre à jour l\'outil', 'telabotanica' ),
		'view_item'             => __( 'Voir l\'outil', 'telabotanica' ),
		'search_items'          => __( 'Chercher un outil', 'telabotanica' ),
		'not_found'             => __( 'Aucun outil.', 'telabotanica' ),
		'not_found_in_trash'    => __( 'Aucun outil dans la corbeille.', 'telabotanica' ),
		'featured_image'        => __( 'Image principale', 'telabotanica' ),
		'set_featured_image'    => __( 'Définir une image principale', 'telabotanica' ),
		'remove_featured_image' => __( 'Enlever l\'image principale', 'telabotanica' ),
		'use_featured_image'    => __( 'Utiliser comme image principale', 'telabotanica' ),
		'insert_into_item'      => __( 'Insert into item', 'telabotanica' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'telabotanica' ),
		'items_list'            => __( 'Liste des outils', 'telabotanica' ),
		'items_list_navigation' => __( 'Items list navigation', 'telabotanica' ),
		'filter_items_list'     => __( 'Filter items list', 'telabotanica' ),
		);

	$rewrite = array(
		'slug'                  => 'outils',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);

	register_post_type( 'tb_outil',
		array(
			'labels' => $labels,
			'description' => __( 'Outil', 'telabotanica' ),
			'public' => true,
			'has_archive' => false,
			'menu_position' => 22,
			'menu_icon' => 'dashicons-admin-tools',
			'capability_type' => 'page',
			'supports' => array(
				'title',
				'revisions',
				'page-attributes'
			),
			'rewrite' => $rewrite
		)
	);
}
add_action( 'init', 'telabotanica_outil_post_type' );

// Moyens de participer
function telabotanica_participer_post_type() {
	$labels = array(
		'name'                  => _x( 'Moyens de participer', 'Post Type General Name', 'telabotanica' ),
		'singular_name'         => _x( 'Moyen de participer', 'Post Type Singular Name', 'telabotanica' ),
		'menu_name'             => __( 'Participer', 'telabotanica' ),
		'name_admin_bar'        => __( 'Participer', 'telabotanica' ),
		'archives'              => __( 'Tous les moyens de participer', 'telabotanica' ),
		'all_items'             => __( 'Tous les moyens de participer', 'telabotanica' ),
		'add_new_item'          => __( 'Ajouter un moyen de participer', 'telabotanica' ),
		'add_new'               => __( 'Ajouter un nouveau', 'telabotanica' ),
		'new_item'              => __( 'Nouveau moyen de participer', 'telabotanica' ),
		'edit_item'             => __( 'Modifier un moyen de participer', 'telabotanica' ),
		'update_item'           => __( 'Mettre à jour un moyen de participer', 'telabotanica' ),
		'view_item'             => __( 'Voir ce moyen de participer', 'telabotanica' ),
		'search_items'          => __( 'Chercher parmi les moyens de participer', 'telabotanica' ),
		'not_found'             => __( 'Aucun moyen de participer.', 'telabotanica' ),
		'not_found_in_trash'    => __( 'Aucun moyen de participer dans la corbeille.', 'telabotanica' ),
		'featured_image'        => __( 'Image principale', 'telabotanica' ),
		'set_featured_image'    => __( 'Définir une image principale', 'telabotanica' ),
		'remove_featured_image' => __( 'Enlever l\'image principale', 'telabotanica' ),
		'use_featured_image'    => __( 'Utiliser comme image principale', 'telabotanica' ),
		'insert_into_item'      => __( 'Insert into item', 'telabotanica' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'telabotanica' ),
		'items_list'            => __( 'Liste des moyens de participer', 'telabotanica' ),
		'items_list_navigation' => __( 'Items list navigation', 'telabotanica' ),
		'filter_items_list'     => __( 'Filter items list', 'telabotanica' ),
		);

	$rewrite = array(
		'slug'                  => 'comment-participer',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);

	register_post_type( 'tb_participer',
		array(
			'labels' => $labels,
			'description' => __( 'Moyens de participer', 'telabotanica' ),
			'public' => true,
			'has_archive' => false,
			'menu_position' => 23,
			'menu_icon' => 'dashicons-megaphone',
			'capability_type' => 'page',
			'supports' => array(
				'title',
				'revisions',
				'page-attributes'
			),
			'rewrite' => $rewrite
		)
	);
}
add_action( 'init', 'telabotanica_participer_post_type' );
