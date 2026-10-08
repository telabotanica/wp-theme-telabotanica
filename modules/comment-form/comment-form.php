<?php function telabotanica_module_comment_form($data) {

  $defaults = [
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('comment-form', $data->modifiers);

  printf(
    '<div class="%s">',
    implode(' ', $data->modifiers)
  );

    $current_user = wp_get_current_user();

    comment_form([
      'class_submit' => 'button',
      'label_submit' => __('Publier', 'telabotanica'),
      'logged_in_as' => sprintf(
        '<p class="logged-in-as">%s</p>',
        sprintf(
          __( 'Connexion en tant que %1$s. <a href="%2$s">Se déconnecter?</a> Les champs obligatoires sont indiqués avec *', 'telabotanica' ),
          $current_user->display_name,
          wp_logout_url( get_permalink() )
        )
      ),
    ]);

  echo '</div>';
}
