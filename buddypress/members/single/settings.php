<?php
/**
 * BuddyPress - Users Settings.
 */
the_telabotanica_module('header-dashboard', [
	'title' => __('Mes réglages', 'telabotanica'),
]);

if (bp_core_can_edit_settings()) :
	$nav_tabs_items = array_map(function ($item) {
	    if ($item->parent !== 'settings') {
	        return;
	    }

	    $item = [
			'href'    => $item->link,
			'text'    => $item->name,
			'current' => in_array('current-menu-item', $item->class),
		];

	    return (object) $item;
	}, bp_get_nav_menu_items());

	the_telabotanica_module('nav-tabs', [
		'label' => __('Member secondary navigation', 'buddypress'),
		'items' => array_filter($nav_tabs_items),
	]);
endif;

?>

<div id="buddypress">
<?php

switch (bp_current_action()) :
	case 'notifications':
		bp_get_template_part('members/single/settings/notifications');
		break;
	case 'capabilities':
		bp_get_template_part('members/single/settings/capabilities');
		break;
	case 'delete-account':
		bp_get_template_part('members/single/settings/delete-account');
		break;
	case 'general':
		bp_get_template_part('members/single/settings/general');
		break;
	case 'profile':
		bp_get_template_part('members/single/settings/profile');
		break;
	default:
		bp_get_template_part('members/single/plugins');
		break;
endswitch;
?>
</div>
