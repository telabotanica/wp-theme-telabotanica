<?php

function telabotanica_component_intro($data)
{
    $defaults = [
    'text'      => get_sub_field('intro'),
    'modifiers' => []
  ];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-intro'], $data->modifiers);

    echo '<div class="' . implode(' ', $data->modifiers) . '">';
    echo $data->text;
    echo '</div>';
}
