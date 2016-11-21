<?php function telabotanica_module_cover_project($data) {

  echo '<div class="cover-project">';

    $cover_image_url = bp_attachments_get_attachment('url', array(
      'object_dir' => 'groups',
      'item_id' => bp_get_group_id(),
    ));
    echo sprintf(
      '<div class="cover-project-image" style="background-image: url(%s);"></div>',
      $cover_image_url
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
      $visibility_icons = [
        'public' => 'globe',
        'private' => 'globe',
        'hidden' => 'globe'
      ];
      echo sprintf(
        '<span class="cover-project-visibility">%s %s</span>',
        bp_get_group_type(),
        get_telabotanica_module('icon', ['icon' => $visibility_icons[ bp_get_group_status() ] ])
      );
      the_telabotanica_module('button', [
        'href' => '#',
        'text' => __( 'Suivre ce projet', 'telabotanica' ) . get_telabotanica_module('icon', ['icon' => 'plus']),
        'modifiers' => 'outline'
      ] );
      // bp_group_join_button();
      // var_dump( bp_get_group_join_button() );
    echo '</div>';

  echo '</div>';

}
