<?php function telabotanica_module_list_articles($data) {
	$defaults = [
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);
	$data->modifiers = telabotanica_styleguide_modifiers_array('list-articles', $data->modifiers);

	$category = get_category( get_query_var('cat') );
	$category_evenements = get_category_by_slug( 'evenements' );
	$is_category_events = is_category( $category_evenements ) || cat_is_ancestor_of( $category_evenements, $category );
	if ($is_category_events) $data->modifiers[] = 'only-events';

	printf(
		'<div class="%s">',
		implode(' ', $data->modifiers)
	);

	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			$is_event = !empty( get_field( 'date' ) );

			printf(
				'<article id="post-%s" class="%s">',
				get_the_ID(),
				implode(' ', get_post_class( 'list-articles-item ' . ( $is_event ? 'is-event' : '') ) )
			);

				if ( $is_event ) :
					the_telabotanica_module('event-dates', ['modifiers' => 'float-left']);
				else :
					printf(
						'<a href="%s" class="list-articles-image">%s</a>',
						esc_url( get_permalink() ),
						has_post_thumbnail() ? get_the_post_thumbnail( null, 'post-thumbnail', array( 'class' => 'list-articles-image' ) ) : ''
					);
				endif;

				echo '<div class="list-articles-text">';
					echo '<div class="list-articles-meta">';

						if ( $is_event ) :
							$place = get_field( 'place' );
							echo '<span class="list-articles-place">' . telabotanica_format_place( $place ) . '</span>';
						endif;

						printf(
							'<span class="list-articles-date" title="%s">%s <time datetime="%s">%s</time></span>',
							sprintf( _x( '%s à %s', '%s = date et %s = heure', 'telabotanica' ),
								date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ),
								date_i18n( get_option( 'time_format' ), get_the_time( 'U' ) )
							),
							get_telabotanica_module('icon', ['icon' => 'clock']),
							get_the_time( 'Y-m-d\\TG:i:s\\Z' ),
							sprintf( _x( 'il y a %s', '%s = intervalle de temps', 'telabotanica' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) )
						);

						echo ' &ndash; ';

						printf(
							'<span class="list-articles-author">%s</span>',
							sprintf(
								__( 'par %s', 'telabotanica' ),
								sprintf(
									'<a href="%s">%s</a>',
									esc_url( bp_core_get_user_domain( get_the_author_meta( 'ID' ) ) ),
									get_the_author()
								)
							)
						);

						the_telabotanica_module('categories-labels');

						echo '</div>';

					the_title( sprintf( '<h2 class="list-articles-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
					the_excerpt();

					echo '</div>';
				echo '</article>';
		endwhile;

		the_telabotanica_module('pagination');

	else :
		echo '<p>' . __( 'Aucune actualité dans cette catégorie.', 'telabotanica' ) . '</p>';
	endif;

	echo '</div>';

}
