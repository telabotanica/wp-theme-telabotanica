<?php function telabotanica_module_share($data) {

  if ( bp_is_group() ) :
    $url = bp_get_group_permalink();
  else :
    $url = get_permalink();
  endif;

  echo '<ul class="share">';
    printf(
      '<li class="share-item"><a href="%s" target="_blank" title="%s">%s</a></li>',
      'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( $url ),
      sprintf( __( 'Partager sur %s', 'telabotanica' ), 'Facebook' ),
      get_telabotanica_module('icon', ['icon' => 'facebook'])
    );
    printf(
      '<li class="share-item"><a href="%s" target="_blank" title="%s">%s</a></li>',
      'https://twitter.com/intent/tweet?text=' . urlencode( get_the_title() . ' ' . $url ),
      sprintf( __( 'Partager sur %s', 'telabotanica' ), 'Twitter' ),
      get_telabotanica_module('icon', ['icon' => 'twitter'])
    );
    printf(
      '<li class="share-item"><a href="%s" title="%s">%s</a></li>',
      'mailto:?subject=' . rawurlencode( get_the_title() ) . '&body=' . urlencode( $url ),
      __( 'Partager par courriel', 'telabotanica' ),
      get_telabotanica_module('icon', ['icon' => 'mail'])
    );
  echo '</ul>';

}
