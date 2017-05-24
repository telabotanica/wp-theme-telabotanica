<?php

function telabotanica_module_button($data)
{
    $defaults = [
        'tag'              => 'a',
        'href'             => '#',
        'target'           => '',
        'text'             => 'Bouton',
        'title'            => '',
        'icon_before'      => false,
        'icon_after'       => false,
        'modifiers'        => [],
        'extra_attributes' => [],
    ];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('button', $data->modifiers);

    if ($data->modifiers && in_array('back', $data->modifiers)) {
        $data->icon_before = 'arrow-left';
    }

    $extra_attributes = '';
    foreach ($data->extra_attributes as $name => $value) {
        $extra_attributes .= sprintf('%s="%s" ', $name, $value);
    }

    printf(
    '<%s href="%s" %s class="%s" target="%s" title="%s">%s<span class="button-text">%s</span>%s</%s>',
    $data->tag,
    $data->href,
    $extra_attributes,
    implode($data->modifiers, ' '),
    $data->target,
    $data->title,
    $data->icon_before ? get_telabotanica_module('icon', ['icon' => $data->icon_before]) : '',
    $data->text,
    $data->icon_after ? get_telabotanica_module('icon', ['icon' => $data->icon_after]) : '',
    $data->tag
  );
}
