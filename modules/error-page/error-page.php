<?php

function telabotanica_module_error_page($data)
{
    $defaults = [
        'type'   => 404,
        'title'  => __('Erreur', 'telabotanica'),
        'text'   => false,
        'button' => [
            'href' => site_url(),
            'text' => __("Retour à l'accueil", 'telabotanica'),
        ],
        'modifiers' => [],
    ];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('error-page', $data->modifiers);

    printf(
        '<div class="%s">',
        implode(' ', $data->modifiers)
    );

    printf(
            '<a href="%s" class="error-page-logo"><img src="%s" alt="Tela Botanica" /></a>',
            site_url(),
            get_template_directory_uri().'/assets/images/logo-horizontal.svg'
        );

    printf(
            '<div class="error-page-image"><img src="%s" alt="%s" /></div>',
            get_template_directory_uri().'/modules/error-page/'.$data->type.'.jpg',
            $data->type
        );

    printf(
            '<h1 class="error-page-title">%s</h1>',
            $data->title
        );

    if ($data->text) :
            printf(
                '<p class="error-page-text">%s</p>',
                $data->text
            );
    endif;

    the_telabotanica_module('button', $data->button);

    echo '</div>';
}
