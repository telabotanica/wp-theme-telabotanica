<?php

function telabotanica_block_mosaic_item($item) {
  if ( is_array($item) ) $item = (object) $item;
  if ( !is_object($item) ) return;

  $item->button = is_array($item->button ?? null) ? $item->button : [];
  $item->images = is_array($item->images ?? null) ? $item->images : [];

  echo '<li class="block-mosaic-item">';
    echo '<div class="block-mosaic-item-content-wrapper">';
      echo '<div class="block-mosaic-item-content">';

        echo '<h3 class="block-mosaic-item-title">' . ($item->title ?? '') . '</h3>';

        echo '<p class="block-mosaic-item-text">' . ($item->text ?? '') . '</p>';

        // forcer le bouton à s'afficher en mode "block"
        if ( empty($item->button['modifiers']) || !is_array( $item->button['modifiers'] ) ) $item->button['modifiers'] = [];
        if ( is_array($item->button['modifiers']) && !in_array( 'block', $item->button['modifiers'] ) ) $item->button['modifiers'][] = 'block';
        if ( ($item->i ?? 0) % 2 === 1 ) $item->button['modifiers'][] = 'orange';
        $item->button['text'] = $item->button_text ?? ($item->button['text'] ?? '');
        $item->button['href'] = $item->button['url'] ?? ($item->button['href'] ?? '#');
        if ( function_exists('the_telabotanica_module') && !empty($item->button['text']) ) :
          the_telabotanica_module('button', $item->button);
        endif;

      echo '</div>';
    echo '</div>';

    echo '<ul class="block-mosaic-item-images">';
      foreach ($item->images as $image) :
        if ( !is_array($image) && !is_object($image) ) continue;
        $image = (object) $image;
        if ( empty($image->src) ) continue;

        printf(
          '<li class="block-mosaic-item-image"><a href="%s" target="_blank" title="%s"><img data-src="%s" alt="%s" class="lazyload" /></a></li>',
          esc_url( $image->href ?? '#' ),
          esc_attr( @$image->title ?: '' ),
          esc_url( $image->src ),
          esc_attr( @$image->alt ?: '' )
        );

      endforeach;
    echo '</ul>';
  echo '</li>';
}

function telabotanica_block_mosaic($data) {
  $defaults = [
    'items' => function_exists('get_sub_field') ? get_sub_field('items') : null,
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-mosaic'], $data->modifiers);

  $data->items = is_array($data->items) ? array_values($data->items) : [];
  if ( empty($data->items) ) return;

  $images_per_item = 4;
  $images_count = count($data->items) * $images_per_item;

  $images = get_transient( 'module_mosaic_images' );
  if ( !is_array($images) ) :
    $images = [];
    try {
      $response = @file_get_contents('https://api.tela-botanica.org/service:del:0.1/observations?navigation.depart=0&navigation.limite=' . $images_count . '&masque.type=adeterminer&masque.pninscritsseulement=1&tri=date_transmission&ordre=desc');
      if ( is_string($response) && $response !== '' ) :
        $images_feed = json_decode($response);
        if ( isset($images_feed->resultats) && is_array($images_feed->resultats) ) :
          $images = array_map(function($resultat) {
            if ( !is_object($resultat) ) return null;
            $first_image = is_array($resultat->images ?? null) ? ($resultat->images[0] ?? null) : null;
            $src = '';
            if ( is_object($first_image) && isset($first_image->{'binaire.href'}) ) :
              $src = str_replace('XL.', 'CRS.', $first_image->{'binaire.href'});
            endif;
            if ( empty($src) ) return null;
            return (object) [
              'href' => 'https://www.tela-botanica.org/appli:identiplante#obs~' . ($resultat->id_observation ?? ''),
              'src' => $src,
              'alt' => $resultat->{'determination.ns'} ?? __( 'Indéterminé', 'telabotanica' )
            ];
          }, $images_feed->resultats);
          $images = array_values(array_filter($images));
          if ( !empty($images) ) set_transient( 'module_mosaic_images', $images, 1 * HOUR_IN_SECONDS );
        endif;
      endif;
    } catch ( Throwable $e ) {
      error_log( '[telabotanica][block:mosaic] ' . $e->getMessage() );
      $images = [];
    }
  endif;

  if ( empty($images) ) return;

  $images = array_chunk($images, $images_per_item);

  printf(
    '<div class="%s">',
    implode(' ', $data->modifiers)
  );

  echo '<ul class="block-mosaic-items">';

    foreach ($data->items as $i => $item) :

      if ( !is_array($item) ) continue;
      $item['i'] = $i;
      $item['images'] = $images[$i] ?? [];
      if ( empty($item['images']) ) continue;
      telabotanica_block_mosaic_item($item);

    endforeach;

  echo '</ul>';

  echo '</div>';
}
