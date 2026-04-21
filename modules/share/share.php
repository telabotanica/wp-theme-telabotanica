<?php function telabotanica_module_share($data) {

  $url = tb_current_url();

  echo '<ul class="share">';
    printf(
      '<li class="share-item"><a href="%s" target="_blank" title="%s">%s</a></li>',
      'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url ),
      sprintf( __( 'Partager sur %s', 'telabotanica' ), 'Facebook' ),
      get_telabotanica_module('icon', ['icon' => 'facebook'])
    );
    printf(
      '<li class="share-item"><a href="%s" title="%s">%s</a></li>',
      'mailto:?subject=' . rawurlencode( get_the_title() ) . '&body=' . rawurlencode( $url ),
      __( 'Partager par courriel', 'telabotanica' ),
      get_telabotanica_module('icon', ['icon' => 'mail'])
    );
  echo '</ul>';

}
