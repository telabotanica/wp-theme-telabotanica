<?php function telabotanica_module_share($data) {

  echo '<ul class="share">';
    echo sprintf(
      '<li class="share-item"><a href="%s" target="_blank" title="%s">%s</li>',
      'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink() ),
      sprintf( __( 'Partager sur %s', 'telabotanica' ), 'Facebook' ),
      get_telabotanica_module('icon', ['icon' => 'facebook'])
    );
    echo sprintf(
      '<li class="share-item"><a href="%s" target="_blank" title="%s">%s</li>',
      'https://twitter.com/intent/tweet?text=' . urlencode( get_the_title() . ' ' . get_permalink() ),
      sprintf( __( 'Partager sur %s', 'telabotanica' ), 'Twitter' ),
      get_telabotanica_module('icon', ['icon' => 'twitter'])
    );
    echo sprintf(
      '<li class="share-item"><a href="%s" target="_blank" title="%s">%s</li>',
      'mailto:?subject=' . urlencode( get_the_title() ) . '&body=' . urlencode( get_permalink() ),
      __( 'Partager par courriel', 'telabotanica' ),
      get_telabotanica_module('icon', ['icon' => 'mail'])
    );
  echo '</ul>';

}
