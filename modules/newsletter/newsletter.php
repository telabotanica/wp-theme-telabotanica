<?php function telabotanica_module_newsletter($data) {

  $defaults = [
    'modifiers' => [],
    'button' => true
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('newsletter', $data->modifiers);

  printf(
    '<div class="%s">',
    implode(' ', $data->modifiers)
  );

    printf(
      '<div class="newsletter-title">%s</div>',
      __( "Recevoir la lettre d'actualités", 'telabotanica' )
    );

    printf(
      '<p class="newsletter-text">%s</p>',
      __( "Recevez, plusieurs fois par mois, un condensé de l'actualité du réseau, des évènements et des offres d'emplois directement dans votre boîte mail.", 'telabotanica' )
    );

  $url = 'https://46563308.sibforms.com/serve/MUIFAPJUtw2w0WpKJqfiJNBhfvOVssukXdvQEf1ho_rGz4WAsfqF8yAbiB9xfYly5VW6RPA5i9PS-5epLES-2axyz3si0uh8AQoPIZX7plKVd080KqiBl-2juUTuwAZ658q94_3GaZZSlKO-nVjn82qWrpxpBz5QPt9t4Kd6MG7q0DLn8Njg19K72kn1Cs4cozWHpeNNqm_nFBzU';

    if ($data->button) {
      the_telabotanica_module('button', [
        'href' => $url,
        'text' => __( "S'abonner", 'telabotanica' ),
        'target' => '_blank',
        'title' => __( "S'abonner à la lettre d'actualités (nouvel onglet)", 'telabotanica' ),
        'extra_attributes' => [
          'rel' => 'noopener noreferrer'
        ]
      ] );
    }

  echo '</div>';
}
