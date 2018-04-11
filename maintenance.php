<?php

$GLOBALS['is_error'] = true;
get_header();

  the_telabotanica_module('error-page', [
    'type'   => 'maintenance',
    'title'  => __('Le site est en cours de maintenance.', 'telabotanica'),
    'text'   => __("Veuillez nous excuser pour la gêne occasionnée, le site devrait revenir à la normale d'ici très peu de temps.", 'telabotanica'),
    'button' => [
      'href' => '',
      'text' => __('Réessayer', 'telabotanica')
    ]
  ]);

get_footer();
