<?php

// Remplace le bouton de BuddyPress par un module button du styleguide
function telabotanica_bp_get_group_join_button($button)
{
    $icons = [
    'join_group'           => 'plus',
    'leave_group'          => false,
    'accept_invite'        => false,
    'membership_requested' => false,
    'request_membership'   => 'plus'
  ];
    $icon = $icons[$button['id']];

    the_telabotanica_module('button', [
    'href'       => $button['link_href'],
    'text'       => $button['link_text'],
    'icon_after' => $icon ? $icon : false,
    'modifiers'  => 'outline'
  ]);

    return false;
}
add_filter('bp_get_group_join_button', 'telabotanica_bp_get_group_join_button', 99);
