<?php function telabotanica_component_articles($data) {

  $defaults = [
    'title_level' => 3,
    'items' => get_sub_field('items'),
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-articles'], $data->modifiers);

  echo '<div class="' . implode(' ', $data->modifiers) . '">';

  if ( $data->items ) :

      echo '<ul class="component-articles-items">';

      foreach ($data->items as $item) :

        // Tableau d'objets WP_Post
        if (gettype($item) === 'object' && get_class($item) === 'WP_Post') :

          $item->title = $item->post_title;
          $item->text = get_the_excerpt($item);
          $item->href = get_permalink($item);

          $fields = (object) get_fields($item->ID);

          switch ($item->post_type) :
            // moyen de participer
            case 'tb_participer' :
              $item->text = isset($fields->short_description) ? $fields->short_description : '';
              $item->thumbnail = isset($fields->image) ? $fields->image : false;
              $item->href = $fields->destination['url'];
              $item->target = $fields->destination['target'];
              break;

            // thématique
            case 'tb_thematique' :
              $item->text = isset($fields->cover_subtitle) ? $fields->cover_subtitle : '';
              $item->thumbnail = isset($fields->cover_image) ? $fields->cover_image : false;
              break;

            default :
              $item->thumbnail = has_post_thumbnail($item) ? get_the_post_thumbnail_url( $item, 'post-thumbnail' ) : false;
              break;
          endswitch;

        // Tableau simple
        elseif (gettype($item) === 'array') :

          $item = (object) $item;

        endif;

        $item->tag = 'li';
        $item->title_level = $data->title_level;
        $item->modifiers = 'is-small';

        the_telabotanica_module('article', $item);

      endforeach;

      echo '</ul>';

  endif;

  echo '</div>';
}
