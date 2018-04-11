<?php

function telabotanica_component_image($data)
{
    $defaults = [
    'alt'       => get_sub_field('alt'),
    'image'     => '',
    'srcset'    => '',
    'sizes'     => '',
    'modifiers' => [get_sub_field('modifiers')]
  ];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-image'], $data->modifiers);

    if (empty($data->image)) {
        $image = get_sub_field('image') ?: get_field('image');
        $data->image = $image['sizes']['large'];

        // Le srcset est analysé selon les tailles proposées.
        // La taille est fixe sur desktop (max-width du conteneur des composants)
        // et fluide sur mobile (proche de toute la largeur, donc 100vw)
        // cf. https://ericportis.com/posts/2014/srcset-sizes/
        $srcset = [];
        foreach (['medium', 'large'] as $size) {
            $srcset[$image['sizes'][$size . '-width']] = $image['sizes'][$size] . ' ' . $image['sizes'][$size . '-width'] . 'w';
        }

        $components_width = is_page() ? 620 : 700;

        if ($image['width'] > $components_width) {
            $data->srcset = implode($srcset, ', ');
            $data->sizes = '(min-width: 1160px) ' . $components_width . 'px, 100vw';
        }

        if (empty($data->alt)) {
            $data->alt = $image['title'];
        }
    }

    echo '<div class="' . implode(' ', $data->modifiers) . '">';

    printf(
      '<img src="%s" srcset="%s" sizes="%s" alt="%s" />',
      $data->image,
      $data->srcset,
      $data->sizes,
      $data->alt
    );

    telabotanica_image_credits($image, 'component-image');

    echo '</div>';
}
