<?php

add_action('bp_setup_nav', 'tb_bp_profile_subpages', 30);

function tb_bp_profile_subpages()
{
    bp_core_new_nav_item(
		[
			'name'                    => 'Documents',
			'slug'                    => 'documents',
			'default_subnav_slug'     => 'documents', // important, sinon ça marche pas et on devient fou
			'item_css_id'             => 'documents',
			'position'                => 40,
			'show_for_displayed_user' => false, // false : profil privé seulement, true : profil public
			'screen_function'         => 'tb_profile_documents',
		]
	);
    bp_core_new_nav_item(
		[
			'name'                    => 'Contributions',
			'slug'                    => 'contributions',
			'default_subnav_slug'     => 'contributions',
			'item_css_id'             => 'contributions',
			'position'                => 40,
			'show_for_displayed_user' => false,
			'screen_function'         => 'tb_profile_contributions',
		]
	);
    bp_core_new_nav_item(
		[
			'name'                    => 'Dons',
			'slug'                    => 'dons',
			'default_subnav_slug'     => 'dons',
			'item_css_id'             => 'dons',
			'position'                => 40,
			'show_for_displayed_user' => false,
			'screen_function'         => 'tb_profile_dons',
		]
	);
    bp_core_new_nav_item(
		[
			'name'                    => 'Outils',
			'slug'                    => 'outils',
			'default_subnav_slug'     => 'outils',
			'item_css_id'             => 'outils',
			'position'                => 40,
			'show_for_displayed_user' => false,
			'screen_function'         => 'tb_profile_outils',
		]
	);
    bp_core_new_nav_item(
		[
			'name'                    => 'Thématiques',
			'slug'                    => 'thematiques',
			'default_subnav_slug'     => 'thematiques',
			'item_css_id'             => 'thematiques',
			'position'                => 40,
			'show_for_displayed_user' => false,
			'screen_function'         => 'tb_profile_thematiques',
		]
	);
	// si on modifie la page associée au composant "groupes" de BP, redéfinir la
	// navigation ici permet d'éviter un warning curieux;
	$pagesBP = get_option('bp-pages');
    $groupsPage = get_post($pagesBP['groups']);
    $groupsSlug = $groupsPage->post_name;
	// bp_get_groups_slug() ne fonctionne pas ici (retourne toujours "groups")
	bp_core_new_nav_item(
		[
			'name'                    => 'Projets',
			'slug'                    => $groupsSlug,
			'default_subnav_slug'     => $groupsSlug,
			'item_css_id'             => 'projets',
			'position'                => 40,
			'show_for_displayed_user' => true,
		]
	);
}

/**
 * Rendu de la sous-page de profil "documents" en utilisant le template "home"
 * (fournit la mise en page, les menus); celui-ci chargera un sous-template.
 */
function tb_profile_documents()
{
    bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/home'));
}

function tb_profile_contributions()
{
    bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/home'));
}

function tb_profile_dons()
{
    bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/home'));
}

function tb_profile_outils()
{
    bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/home'));
}

function tb_profile_thematiques()
{
    bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/home'));
}
