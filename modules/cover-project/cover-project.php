<?php function telabotanica_module_cover_project($data) {
  if ( bp_has_groups() ) :

    while ( bp_groups() ) : bp_the_group();

      echo '<div class="cover-project">';

        echo sprintf(
          '<div class="cover-project-image" style="background-image: url(%s);"></div>',
          'http://local.wordpress.dev/wp-content/uploads/2016/09/img000267049O.jpg' // TODO: URL de la cover
        );

        bp_group_avatar( 'type=full&width=90&height=90' );

        echo '<h1 class="cover-project-title">' . bp_get_group_name() . '</h1>';
        echo '<div class="cover-project-description">' . bp_get_group_description_excerpt() . '</div>';

        the_telabotanica_module('button', [
          'href' => '#',
          'text' => __( 'Visiter le site web', 'telabotanica' )
        ] );

        echo sprintf(
          '<a href="%s" class="cover-project-back">%s %s</a>',
          bp_get_groups_directory_permalink(),
          get_telabotanica_module('icon', ['icon' => 'arrow-left']),
          __( 'Retour à la liste', 'telabotanica' )
        );

        echo '<div class="cover-project-meta">';
          echo sprintf(
            '<span class="cover-project-visibility">%s %s</span>',
            __( 'Projet public', 'telabotanica' ),
            get_telabotanica_module('icon', ['icon' => 'globe'])
          );
          the_telabotanica_module('button', [
            'href' => '#',
            'text' => __( 'Suivre ce projet', 'telabotanica' ) . get_telabotanica_module('icon', ['icon' => 'plus']),
            'modifiers' => 'outline'
          ] );
        echo '</div>';

      echo '</div>';

    endwhile;

  endif;

}
