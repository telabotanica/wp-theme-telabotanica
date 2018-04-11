<?php

function telabotanica_component_embed($data)
{
    $defaults = [
    'method'         => get_sub_field('method'),
    'description'    => get_sub_field('description'),
    'description_id' => get_sub_field_object('description')['name'],
    'embed'          => '',
    'modifiers'      => []
  ];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-embed'], $data->modifiers);

    if ($data->method === 'oembed') :

    $height = false;
    $data->embed = get_sub_field('embed'); elseif ($data->method === 'iframe') :

    $height = get_sub_field('height');

    $data->embed = sprintf(
      '<iframe src="%s" style="%s"></iframe>',
      get_sub_field('iframe'),
      $height ? 'height: ' . ($height / 10) . 'rem' : ''
    );

    endif;

    echo '<div class="' . implode(' ', $data->modifiers) . '">';

    printf(
    '<div class="component-embed-wrapper" aria-describedby="%s" style="%s">',
    $data->description_id,
    $height ? 'height: ' . ($height / 10) . 'rem' : ''
  );
    echo $data->embed;
    echo '</div>';

    if ($data->description) :

    echo '<div class="component-embed-description" id="' . $data->description_id . '">';
    echo $data->description;
    echo '</div>';

    endif;

    echo '</div>';
}
