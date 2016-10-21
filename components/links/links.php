<?php function telabotanica_component_links($data) {
  if (!isset($data->title)) $data->title = get_sub_field('title');
  if (!isset($data->items)) $data->items = get_sub_field('link');

  echo '<div class="component component-links">';

  echo '<h3 class="component-links-title">' . $data->title . '</h3>';

  if ( $data->items ):

      echo '<ul>';

      foreach ($data->items as $item) :

        $item = (object) $item;

        if (@$item->href) {
          $href = $item->href;
        } else {
          $href = $item->url;
        }

        echo '<li><a href="' . $href . '">' . $item->text . '</a></li>';

      endforeach;

      echo '</ul>';

  endif;

  echo '</div>';
}
