<?php function telabotanica_composant_liens($data) {
  if (!isset($data->titre)) $data->titre = get_sub_field('titre');
  if (!isset($data->items)) $data->items = get_sub_field('lien');

  echo '<div class="composant composant-liens">';

  echo '<h3 class="composant-liens-titre">' . $data->titre . '</h3>';

  if ( $data->items ):

      echo '<ul>';

      foreach ($data->items as $item) :

        $item = (object) $item;

        if (@$item->href) {
          $href = $item->href;
        } else {
          $href = $item->url;
        }

        echo '<li><a href="' . $href . '">' . $item->intitule . '</a></li>';

      endforeach;

      echo '</ul>';

  endif;

  echo '</div>';
}
