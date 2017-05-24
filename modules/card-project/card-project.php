<?php

function telabotanica_module_card_project($data)
{
    global $pug;

    $cover_image_url = bp_attachments_get_attachment('url', [
        'object_dir' => 'groups',
        'item_id'    => bp_get_group_id(),
    ]);

    $defaults = [
        'tag'             => 'div',
        'permalink'       => bp_get_group_permalink(),
        'cover_image_url' => $cover_image_url,
        'tela'            => bp_groups_has_group_type(bp_get_group_id(), 'tela-botanica'),
        'tela_title'      => __('Un projet Tela Botanica', 'telabotanica'),
        'tela_icon'       => get_telabotanica_module('icon', ['icon' => 'tela-leaf']),
        'avatar'          => bp_core_fetch_avatar([
            'item_id' => bp_get_group_id(),
            'object'  => 'group',
            'type'    => 'full',
            'html'    => false,
        ]),
        'name'        => bp_get_group_name(),
        'description' => strip_tags(bp_get_group_description_excerpt()),
        'meta'        => [
            [
                'icon' => 'members',
                'text' => bp_get_group_member_count(),
            ],
        ],
        'modifiers' => [],
    ];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('card-project', $data->modifiers);

    echo $pug->render(__DIR__.'/card-project.pug', [
        'tag'  => $data->tag,
        'data' => $data,
    ]);
}
