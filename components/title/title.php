<?php

function telabotanica_component_title($data)
{
    $defaults = [
        'level'     => get_sub_field('level') ?: 2,
        'anchor'    => get_sub_field('anchor'),
        'title'     => get_sub_field('title'),
        'modifiers' => [],
    ];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-title'], $data->modifiers);

    $data->modifiers[] = 'level-'.$data->level;

    if (empty($data->anchor)) {
        $data->anchor = sanitize_title_with_dashes($data->title);
    }

    printf(
        '<div class="%s"><a class="component-title-anchor" name="%s"></a>',
        implode(' ', $data->modifiers),
        str_replace('#', '', $data->anchor)
    );

    printf(
            '<h%s>%s</h%s>',
            $data->level,
            $data->title,
            $data->level
        );

    echo '</div>';
}
