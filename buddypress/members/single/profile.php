<?php
/**
 * BuddyPress - Users Profile.
 */
if (bp_current_action() === 'public') :

    the_telabotanica_module('cover-member', [
        'back' => [
            'href'      => bp_loggedin_user_domain(),
            'text'      => __('Retour à mon espace personnel', 'telabotanica'),
            'modifiers' => 'cover-member-back white link back',
        ],
        'button' => [
            'href'        => bp_loggedin_user_domain().'profile/edit/',
            'text'        => __('Modifier mon profil', 'telabotanica'),
            'icon_before' => 'edit',
        ],
    ]);

    ?>
	<div class="layout-central-col">
  	<div class="layout-wrapper">
    	<div class="layout-content"><?php

            // Display XProfile
            if (bp_is_active('xprofile')) {
                bp_get_template_part('members/single/profile/profile-loop');
            }

            // Display WordPress profile (fallback)
            else {
                bp_get_template_part('members/single/profile/profile-wp');
            }

        ?>
		</div>
	</div>
</div>
<?php

else :

    the_telabotanica_module('header-dashboard', [
        'title' => __('Mon profil', 'telabotanica'),
    ]);

    $nav_tabs_items = array_map(function ($item) {
        if ($item->parent !== 'profile') {
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

/*
 * Fires before the display of member profile content.
 *
 * @since 1.1.0
 */
do_action('bp_before_profile_content'); ?>

<div id="buddypress" class="profile">

<?php switch (bp_current_action()) :

    // Edit
    case 'edit':
        bp_get_template_part('members/single/profile/edit');
        break;

    // Change Avatar
    case 'change-avatar':
        bp_get_template_part('members/single/profile/change-avatar');
        break;

    // Change Cover Image
    case 'change-cover-image':
        bp_get_template_part('members/single/profile/change-cover-image');
        break;

    // Any other
    default:
        bp_get_template_part('members/single/plugins');
        break;
endswitch; ?>
</div><!-- .profile -->

<?php
endif;

/*
 * Fires after the display of member profile content.
 *
 * @since 1.1.0
 */
do_action('bp_after_profile_content');

?>
