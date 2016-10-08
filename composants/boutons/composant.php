<?php function telabotanica_composant_boutons($data) {
  echo '<div class="boutons">';
  foreach ($data->items as $bouton) {
    the_telabotanica_module('bouton', $bouton);
  }
  echo '</div>';
}
