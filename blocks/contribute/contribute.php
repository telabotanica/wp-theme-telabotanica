<?php

function telabotanica_block_contribute_item($item) {
  if ( is_array($item) ) $item = (object) $item;
  if ( !is_object($item) ) return;

  $href = $item->href ?? '#';
  $target = $item->target ?? '';
  $image = $item->image ?? '';
  $title = $item->title ?? '';
  $text = $item->text ?? '';
  $button_text = $item->button_text ?? '';
  if ( empty($title) && empty($href) ) return;

  echo '<div class="block-contribute-item">';

    printf(
      ($target
        ? '<a href="%s" target="%s" class="block-contribute-item-link">'
        : '<a href="%s" class="block-contribute-item-link">'
      ),
      esc_url( $href ),
      esc_attr( $target )
    );

      if ( !empty($image) ) {
        printf(
          '<div class="block-contribute-item-image" style="background-image: url(%s);"></div>',
          esc_url( $image )
        );
      }

      printf(
        '<h3 class="block-contribute-item-title"><span>%s</span></h3>',
        esc_html( $title )
      );

      printf(
        '<div class="block-contribute-item-text">%s</div>',
        wp_trim_words( $text, 18 )
      );

      printf(
        '<div class="block-contribute-item-button">%s</div>',
        esc_html( $button_text )
      );

    echo '</a>';

  echo '</div>';
}

function telabotanica_block_contribute($data) {
  $defaults = [
    'query' => false,
    'background_color' => function_exists('get_sub_field') ? get_sub_field('background_color') : '',
    'title' => function_exists('get_sub_field') ? get_sub_field('title') : '',
    'items' => function_exists('get_sub_field') ? get_sub_field('items') : null,
    'buttons' => function_exists('get_sub_field') ? get_sub_field('buttons') : null,
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-contribute'], $data->modifiers);

  printf(
    '<div class="%s" style="background-color: %s">',
    implode(' ', $data->modifiers),
    $data->background_color
  );

    echo '<div class="block-contribute-header">';

      echo '<h2 class="block-contribute-title">' . $data->title . '</h2>';

    echo '</div>';

    echo '<div class="block-contribute-content">';

      echo '<div class="layout-wrapper">';
        echo '<div class="block-contribute-items">';

        $items_id = [];

        if ( !empty($data->items) && is_array($data->items) ) :

          foreach ($data->items as $item) :

            // Tableau d'objets Moyens de participer
            if (gettype($item) === 'object' && get_class($item) === 'WP_Post') :

              $items_id[] = $item->ID;
              $item->title = $item->post_title;
              $fields = function_exists('get_fields') ? (get_fields($item->ID) ?: []) : [];
              $fields = (object) $fields;
              $destination = is_array($fields->destination ?? null) ? $fields->destination : [];
              $image_field = is_array($fields->image ?? null) ? $fields->image : [];
              $item->text = $fields->short_description ?? '';
              $item->button_text = $fields->button_text ?? __( 'Commencer', 'telabotanica' );
              $item->href = $destination['url'] ?? '#';
              $item->target = $destination['target'] ?? '';
              $item->image = $image_field['sizes']['medium_square'] ?? ($image_field['url'] ?? '');

            endif;

            telabotanica_block_contribute_item($item);

          endforeach;

        endif;

        // S'il y a moins de 3 items sélectionnés, on en ajoute pour arriver à 3
        $items_count = count($items_id);
        if ($items_count < 3) {
          $data->query = new WP_Query([
            'post_type' => 'tb_participer',
            'posts_per_page' => 3 - $items_count,
            'post__not_in' => $items_id,
            'orderby' => 'rand'
          ]);
        }

        if ( $data->query && $data->query instanceof WP_Query ) :

          while ( $data->query->have_posts() ) : $data->query->the_post();

            $destination = function_exists('get_field') ? get_field('destination') : null;
            $destination = is_array($destination) ? $destination : [];
            $image_field = function_exists('get_field') ? get_field('image') : null;
            $image_field = is_array($image_field) ? $image_field : [];
            $item = [
              'title' => get_the_title(),
              'text' => function_exists('get_field') ? (get_field('short_description') ?: '') : '',
              'button_text' => function_exists('get_field') ? (get_field('button_text') ?: '') : '',
              'href' => $destination['url'] ?? '#',
              'target' => $destination['target'] ?? '',
              'image' => $image_field['sizes']['medium'] ?? ($image_field['url'] ?? '')
            ];
            telabotanica_block_contribute_item($item);

          endwhile;

        endif;

        echo '</div>';
      echo '</div>';

      if ( !empty($data->buttons) && is_array($data->buttons) && function_exists('the_telabotanica_component') ) :

        $data->buttons['display'] = [ ($data->buttons['display'] ?? ''), 'seamless' ];
        the_telabotanica_component( 'buttons', $data->buttons );

      endif;

    echo '</div>';

  echo '</div>';

  wp_reset_postdata();
}
