<?php function telabotanica_component_embed($data) {
  if (!isset($data->method)) $data->method = get_sub_field('method');

  if ( $data->method === 'oembed' ) :

    $data->embed = get_sub_field('embed');

  elseif ( $data->method === 'iframe' ) :

    $data->embed = sprintf(
      '<iframe src="%s"></iframe>',
      get_sub_field('iframe')
    );

  endif;

  echo '<div class="component component-embed">';

  echo $data->embed;

  echo '</div>';
}
