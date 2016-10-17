<?php function telabotanica_composant_intertitre($data) {
  if (!isset($data->niveau)) $data->niveau = get_sub_field('niveau');
  if (!isset($data->ancre)) $data->ancre = get_sub_field('ancre');
  if (!isset($data->titre)) $data->titre = get_sub_field('titre');

  echo '<div class="composant composant-intertitre niveau-' . $data->niveau . '">';

  echo '<h' . $data->niveau . ' id="' . $data->ancre . '">';
  echo $data->titre;
  echo '</h' . $data->niveau . '>';

  echo '</div>';
}
