<?php function telabotanica_composant_outils($data) {
  if (!isset($data->items)) $data->items = get_sub_field('outils');

  echo '<div class="composant composant-outils">';

  if ( $data->items ):

      echo '<ul class="composant-outils-items">';

      foreach ($data->items as $item) :

        $item = (object) $item;

        echo '<li class="composant-outils-item">';
        echo '<div class="composant-outils-item-icon"></div>';
        echo '<h4 class="composant-outils-item-titre">' . $item->titre . '</h4>';
        echo '<div class="composant-outils-item-description">' . $item->description . '</div>';
        echo '<div class="composant-outils-item-lien"><a href="' . $item->lien . '">' . $item->intitule_du_lien . ' &rsaquo;</a></div>';
        echo '</li>';

      endforeach;

      echo '</ul>';

  endif;

  echo '</div>';
}
