<?php function telabotanica_module_cover_home($data) {

  $defaults = [
    'image' => tb_acf('cover_image', []),
    'title' => __('Bienvenue sur Tela Botanica, <br />le réseau des botanistes francophones', 'telabotanica'),
    'modifiers' => []
  ];
  $data = telabotanica_styleguide_data($defaults, $data);
  $data->image = is_array($data->image) ? $data->image : [];
  $data->modifiers = telabotanica_styleguide_modifiers_array(['cover', 'cover-home'], $data->modifiers);

  $bg = '';
  if (is_array($data->image) && isset($data->image['sizes']['cover-background'])) {
    $bg = $data->image['sizes']['cover-background'];
  } elseif (is_array($data->image) && isset($data->image['url'])) {
    $bg = $data->image['url'];
  }

  printf(
    '<div class="%s" style="background-image: url(%s);">',
    implode(' ', $data->modifiers),
    esc_url($bg)
  );

    echo '<div class="layout-wrapper">';
      echo '<div class="cover-home-content">';
        printf(
          '<h1 class="cover-home-title">%s</h1>',
          $data->title
        );

//      the_telabotanica_module('search-box', [
//        // TODO: A reintegrer sans algolia
//        'suggestions' => ['coquelicot', 'quercus ilex', 'végétation', 'mooc'],
//        'modifiers' => ['large', 'is-primary']
//      ]);

      echo '</div>';

      ?>
    <?php
    echo '</div>';

    telabotanica_image_credits( $data->image, 'cover' );

    echo '</div>';
}
