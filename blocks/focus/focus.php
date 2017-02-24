<?php function telabotanica_block_focus($data) {
	$defaults = [
		'background_color' => get_sub_field('background_color'),
		'main_component_place' => get_sub_field('main_component_place'),
		'main_component' => get_sub_field('main_component'),
		'title' => get_sub_field('title'),
		'intro' => get_sub_field('intro'),
		'text' => get_sub_field('text'),
		'display_buttons' => get_sub_field('display_buttons'),
		'intro_buttons' => get_sub_field('intro_buttons'),
		'content_buttons' => get_sub_field('content_buttons'),
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array(['block', 'block-focus'], $data->modifiers);

	if (!$data->display_buttons) $data->display_buttons = [];

	$data->main_component['modifiers'] = []; // annule les modifiers du composant image

	printf(
		'<div class="%s" style="background-color: %s">',
		implode(' ', $data->modifiers),
		$data->background_color
	);

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

			if ( in_array('intro', $data->display_buttons) && $data->intro_buttons ) :

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

						if ( in_array('content', $data->display_buttons) && $data->content_buttons['items'] ) :

							$data->content_buttons['display'] = [ $data->content_buttons['display'], 'seamless' ];
							the_telabotanica_component( 'buttons', $data->content_buttons );

						endif;

					echo '</div>';

				endif;

			echo '</div>';

		endif;

	echo '</div>';
}
