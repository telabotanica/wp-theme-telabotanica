<?php function telabotanica_block_focus($data) {
  $get = function($key) { return function_exists('get_sub_field') ? get_sub_field($key) : null; };
  $defaults = [
    'background' => $get('background'),
    'background_color' => $get('background_color'),
    'background_image' => $get('background_image'),
    'main_component_place' => $get('main_component_place'),
    'main_component' => $get('main_component'),
    'title_icon' => $get('title_icon'),
    'title' => $get('title'),
    'intro' => $get('intro'),
    'text' => $get('text'),
    'display_buttons' => $get('display_buttons'),
    'intro_buttons' => $get('intro_buttons'),
    'content_buttons' => $get('content_buttons'),
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-focus'], $data->modifiers);

  if (!is_array($data->display_buttons)) $data->display_buttons = $data->display_buttons ? (array) $data->display_buttons : [];

  $data->main_component = is_array($data->main_component) ? $data->main_component : [];
  $data->main_component['modifiers'] = []; // annule les modifiers du composant image

  $background = '';
  if ( $data->background === 'image' && is_array($data->background_image) ) :
    $cover = $data->background_image['sizes']['cover-background'] ?? ($data->background_image['url'] ?? '');
    if ( !empty($cover) ) :
      $background = sprintf( 'background-image: url(%s)', esc_url($cover) );
      $data->modifiers[] = 'with-background-image';
    endif;
  elseif ( $data->background === 'color' && !empty($data->background_color) ) :
    $background = sprintf( 'background-color: %s', esc_attr($data->background_color) );
  endif;

  printf(
    '<div class="%s" style="%s">',
    esc_attr(implode(' ', (array) $data->modifiers)),
    esc_attr($background)
  );

    $has_main_component_rows = function_exists('have_rows') && have_rows('main_component');

    if ( $data->main_component_place === 'top' && $has_main_component_rows && function_exists('the_telabotanica_component') ) :

      while ( have_rows('main_component') ) : the_row();

        the_telabotanica_component(get_row_layout(), $data->main_component);

      endwhile;

    endif;

    echo '<div class="block-focus-header">';

      if ( !empty($data->title_icon) && function_exists('get_telabotanica_module') ) :

        printf(
          '<div class="block-focus-title-icon">%s</div>',
          get_telabotanica_module('icon', ['icon' => $data->title_icon, 'color' => 'vert-clair'])
        );

      endif;

      echo '<h2 class="block-focus-title">' . ($data->title ?? '') . '</h2>';

      if ( !empty($data->intro) ) :

        echo '<div class="block-focus-intro">' . $data->intro . '</div>';

      endif;

      $data->intro_buttons = is_array($data->intro_buttons ?? null) ? $data->intro_buttons : [];
      if ( in_array('intro', (array) $data->display_buttons) && !empty($data->intro_buttons) && function_exists('the_telabotanica_component') ) :

        $data->intro_buttons['display'] = [ ($data->intro_buttons['display'] ?? ''), 'seamless' ];
        the_telabotanica_component( 'buttons', $data->intro_buttons );

      endif;

    echo '</div>';

    $data->content_buttons = is_array($data->content_buttons ?? null) ? $data->content_buttons : [];
    $has_content_buttons = !empty($data->content_buttons['items']);
    $has_left_component = ( $data->main_component_place === 'left' && $has_main_component_rows );

    if ( $has_left_component || !empty($data->text) || $has_content_buttons ) :

      echo '<div class="block-focus-content">';

        if ( $has_left_component && function_exists('the_telabotanica_component') ) :

          while ( have_rows('main_component') ) : the_row();

            the_telabotanica_component(get_row_layout(), $data->main_component);

          endwhile;

        endif;

        if ( !empty($data->text) || $has_content_buttons ) :

          echo '<div class="block-focus-content-text">';

            if ( !empty($data->text) && function_exists('the_telabotanica_component') ) :

              the_telabotanica_component( 'text', $data->text );

            endif;

            if ( in_array('content', (array) $data->display_buttons) && $has_content_buttons && function_exists('the_telabotanica_component') ) :

              $data->content_buttons['display'] = [ ($data->content_buttons['display'] ?? ''), 'seamless' ];
              the_telabotanica_component( 'buttons', $data->content_buttons );

            endif;

          echo '</div>';

        endif;

      echo '</div>';

    endif;

    if ( $data->background === 'image' && !empty($data->background_image) && function_exists('telabotanica_image_credits') ) :
      telabotanica_image_credits( $data->background_image, 'block-focus' );
    endif;

  echo '</div>';
}
