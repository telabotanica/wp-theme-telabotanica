<?php function telabotanica_block_focus($data) {
  if (!isset($data->background_color)) $data->background_color = get_sub_field('background_color');
  if (!isset($data->main_component_place)) $data->main_component_place = get_sub_field('main_component_place');
  if (!isset($data->main_component)) $data->main_component = get_sub_field('main_component');
  if (!isset($data->title)) $data->title = get_sub_field('title');
  if (!isset($data->intro)) $data->intro = get_sub_field('intro');
  if (!isset($data->text)) $data->text = get_sub_field('text');
  if (!isset($data->intro_buttons)) $data->intro_buttons = get_sub_field('intro_buttons');
  if (!isset($data->content_buttons)) $data->content_buttons = get_sub_field('content_buttons');

  $data->main_component['modifiers'] = []; // annule les modifiers du composant image

  echo '<div class="block block-focus" style="background-color: ' . $data->background_color . '">';

    if ( $data->main_component_place === 'top' && have_rows('main_component') ) :

      while ( have_rows('main_component') ) : the_row();

        the_telabotanica_component(get_row_layout(), $data->main_component);

      endwhile;

    endif;

    echo '<div class="block-focus-header">';

      echo '<h2 class="block-focus-title">' . $data->title . '</h2>';

      if ( $data->intro ) :

        echo '<div class="block-focus-intro">' . $data->intro . '</div>';

      endif;

      if ( $data->intro_buttons ) :

        $data->intro_buttons['display'] = [ $data->intro_buttons['display'], 'seamless' ];
        the_telabotanica_component( 'buttons', $data->intro_buttons );

      endif;

    echo '</div>';

    if ( ( $data->main_component_place === 'left' && have_rows('main_component') ) || $data->text || $data->content_buttons['items'] ) :

      echo '<div class="block-focus-content">';

        if ( $data->main_component_place === 'left' && have_rows('main_component') ) :

          while ( have_rows('main_component') ) : the_row();

            the_telabotanica_component(get_row_layout(), $data->main_component);

          endwhile;

        endif;

        if ( $data->text || $data->content_buttons['items'] ) :

          echo '<div class="block-focus-content-text">';

            if ( $data->text ) :

              the_telabotanica_component( 'text', $data->text );

            endif;

            if ( $data->content_buttons['items'] ) :

              $data->content_buttons['display'] = [ $data->content_buttons['display'], 'seamless' ];
              the_telabotanica_component( 'buttons', $data->content_buttons );

            endif;

          echo '</div>';

        endif;

      echo '</div>';

    endif;

  echo '</div>';
}
