<?php function telabotanica_module_card_project($data) {
  $cover_image_url = bp_attachments_get_attachment('url', array(
    'object_dir' => 'groups',
    'item_id' => bp_get_group_id(),
  ));

  $defaults = [
    'permalink' => bp_get_group_permalink(),
    'cover_image_url' => $cover_image_url,
    'tela' => bp_groups_has_group_type( bp_get_group_id(), 'tela-botanica' ),
    'tela_title' => __( 'Un projet Tela Botanica', 'telabotanica' ),
    'avatar' => bp_core_fetch_avatar( [
      'item_id' => bp_get_group_id(),
      'object' => 'group',
      'type' => 'full',
      'html' => false
    ] ),
    'name' => bp_get_group_name(),
    'description' => strip_tags(bp_get_group_description_excerpt()),
    'meta' => [
      [
        'icon' => 'members',
        'text' => bp_get_group_member_count()
      ]
    ],
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('card-project', $data->modifiers);

  echo '<div class="' . implode(' ', $data->modifiers) . '">';
    echo '<a class="card-project-link" href="' . $data->permalink . '">';

      echo sprintf(
        '<div class="card-project-cover" style="background-image: url(%s);">',
        $data->cover_image_url
      );

        if ($data->tela) {
          echo sprintf(
            '<div class="card-project-tela" title="%s">%s</div>',
            esc_attr( $data->tela_title ),
            get_telabotanica_module('icon', ['icon' => 'tela-leaf'])
          );
        }

        echo sprintf(
          '<img src="%s" class="card-project-avatar" />',
          $data->avatar
        );

      echo '</div>';

      echo '<div class="card-project-content">';
        echo '<h2 class="card-project-title"><span>' . $data->name . '</span></h2>';
        echo '<div class="card-project-description">' . $data->description . '</div>';
      echo '</div>';

      if ($data->meta) :
        echo '<div class="card-project-meta">';
          foreach ($data->meta as $item) :
            $item = (object) $item;
            echo '<span class="card-project-meta-item">';
              the_telabotanica_module('icon', ['icon' => $item->icon]);
              echo $item->text;
            echo '</span>';
          endforeach;
        echo '</div>';
      endif;

    echo '</a>';
  echo '</div>';
}
