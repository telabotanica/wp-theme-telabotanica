<?php

require_once 'inc/filters.php';

function telabotanica_module_cover_project($data)
{
    echo '<div class="cover-project">';

    $cover_image_url = bp_attachments_get_attachment('url', [
			'object_dir' => 'groups',
			'item_id'    => bp_get_group_id(),
		]);
    printf(
			'<div class="cover-project-image" style="background-image: url(%s);"></div>',
			$cover_image_url
		);

    if (!bp_disable_group_avatar_uploads()) :
			bp_group_avatar('type=full&width=90&height=90');
    endif;

    echo '<h1 class="cover-project-title">'.bp_get_group_name().'</h1>';
    echo '<div class="cover-project-description">'.strip_tags(bp_get_group_description_excerpt()).'</div>';

    $external_site_url = groups_get_groupmeta(bp_get_group_id(), 'url-site');
    if ('' !== $external_site_url) {
        the_telabotanica_module('button', [
				'href'   => $external_site_url,
				'text'   => __('Visiter le site web', 'telabotanica'),
				'target' => '_blank',
			]);
    }

    the_telabotanica_module('button', [
			'href'      => bp_get_groups_directory_permalink(),
			'text'      => __('Retour à la liste', 'telabotanica'),
			'modifiers' => 'cover-project-back white link back',
		]);

    echo '<div class="cover-project-meta">';
    $visibility_icons = [
				'public'  => 'globe',
				'private' => 'private',
				'hidden'  => 'hidden',
			];
    printf(
				'<span class="cover-project-visibility">%s %s</span>',
				bp_get_group_type(),
				get_telabotanica_module('icon', ['icon' => $visibility_icons[bp_get_group_status()]])
			);
    bp_group_join_button();
    echo '</div>';

    echo '</div>';
}
