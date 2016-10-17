<?php function telabotanica_composant_texte($data) {
  if (!isset($data->texte)) $data->texte = get_sub_field('texte');

  echo '<div class="composant composant-texte">';

  echo $data->texte;

  echo '</div>';
}
