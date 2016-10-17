<?php

acf_add_local_field_group(array (
	'key' => 'group_58034e80e09e5',
	'title' => 'En kiosque',
	'fields' => array (
		array (
			'key' => 'field_58034e8c9fc17',
			'label' => 'Présentation',
			'name' => 'presentation',
			'type' => 'textarea',
			'instructions' => 'Présentation de l\'ouvrage',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'wpautop',
		),
		array (
			'key' => 'field_58034eab9fc18',
			'label' => 'Auteur',
			'name' => 'auteur',
			'type' => 'textarea',
			'instructions' => 'Présentation de l\'auteur',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'wpautop',
		),
		array (
			'key' => 'field_58034ebe9fc19',
			'label' => 'Informations pratiques',
			'name' => 'informations_pratiques',
			'type' => 'textarea',
			'instructions' => 'Renseigner les références de l\'ouvrage',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Titre de l\'ouvrage
Auteur(s)
Éditions, date de publication
Nombre de pages, format ...
ISBN
Prix indicatif',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'wpautop',
		),
		array (
			'key' => 'field_58034ee99fc1a',
			'label' => 'Pour se procurer l\'ouvrage',
			'name' => 'acheter',
			'type' => 'textarea',
			'instructions' => 'Donner un lien vers le site de l\'éditeur pour pouvoir acquérir l\'ouvrage',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Commander l\'ouvrage en ligne sur le site des éditions [X] [url de la page du livre]',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'wpautop',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
			array (
				'param' => 'post_category',
				'operator' => '==',
				'value' => 'category:en-kiosque',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'the_content',
		1 => 'excerpt',
	),
	'active' => 1,
	'description' => '',
));
