<?php function telabotanica_composant_bouton($data) {
  if (!isset($data->href)) $data->href = get_sub_field('lien_interne');
  if (!isset($data->intitule)) $data->intitule = get_sub_field('intitule');

  echo '<div class="composant composant-bouton">';

  the_telabotanica_module('bouton', $data);

  echo '</div>';
}
