<?php function telabotanica_module_card_project($data) {
  if (!isset($data->tag)) $data->tag = 'div';

  echo '<' . $data->tag . ' class="card-project">';

    echo '<a class="card-project-link" href="' . bp_get_group_permalink() . '">';
      echo sprintf(
        '<div class="card-project-cover" style="background-image: url(%s);">',
        '' // TODO: URL de la cover
      );
      if (true) { // TODO s'il s'agit d'un projet Tela
        echo sprintf(
          '<div class="card-project-tela" title="%s">%s</div>',
          esc_attr__( 'Un projet Tela Botanica', 'telabotanica' ),
          get_telabotanica_module('icon', ['icon' => 'tela-leaf'])
        );
      }
      bp_group_avatar( 'type=full&width=90&height=90' );
      echo '</div>';

      echo '<div class="card-project-content">';
        echo '<h2 class="card-project-title"><span>' . bp_get_group_name() . '</span></h2>';
        echo '<div class="card-project-description">' . bp_get_group_description_excerpt() . '</div>';
      echo '</div>';
    echo '</a>';

    echo '<div class="card-project-meta">';
    the_telabotanica_module('icon', ['icon' => 'members']);
    bp_group_member_count();
    echo '</div>';

  echo '</' . $data->tag . '>';

}
