<?php function telabotanica_module_list_articles_item($data) {
	global $pug;

	$defaults = [
		'modifiers' => get_post_class(),
		'event' => !empty( get_field( 'date' ) ),
		'id' => get_the_ID(),
		'href' => get_permalink(),
		'title' => get_the_title(),
		'text' => get_the_excerpt(),
		'thumbnail' => has_post_thumbnail() ? get_the_post_thumbnail( null, 'post-thumbnail', array( 'class' => 'list-articles-item-image' ) ) : '',
		'place' => telabotanica_format_place( get_field( 'place' ), false ),
		'dates' => [],
		'date' => [
			'title' => sprintf( _x( '%s à %s', '%s = date et %s = heure', 'telabotanica' ),
				date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ),
				date_i18n( get_option( 'time_format' ), get_the_time( 'U' ) )
			),
			'datetime' => get_the_time( 'Y-m-d\\TG:i:s\\Z' ),
			'text' => sprintf( _x( 'il y a %s', '%s = intervalle de temps', 'telabotanica' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) )
		],
		'author' => [
			'prefix' => __( 'par', 'telabotanica' ),
			'text' => get_the_author(),
			'href' => bp_core_get_user_domain( get_the_author_meta( 'ID' ) )
		],
		'categories' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);

	if ($data->event) {
		$data->modifiers[] = 'is-event';

		// TODO: refactor code below (copied from event-dates module)
		$date_timestamp = strtotime( get_field( 'date', null, false ) );
		$date_end_timestamp = strtotime( get_field( 'date_end', null, false ) );
		$date_title = date_i18n( get_option( 'date_format' ), $date_timestamp );

		$data->dates = [
			'start' => [
				'datetime' => date_i18n('Y-m-d', $date_timestamp),
				'day' => date_i18n('j', $date_timestamp),
				'month' => date_i18n('M', $date_timestamp)
			]
		];

		if ( $date_end_timestamp ) {
			$data->dates['end'] = [
				'datetime' => date_i18n('Y-m-d', $date_end_timestamp),
				'day' => date_i18n('j', $date_end_timestamp),
				'month' => date_i18n('M', $date_end_timestamp)
			];
			$data->dates['title'] = sprintf( _x( 'Du %s au %s', '%s = dates', 'telabotanica' ), $date_title, date_i18n( get_option( 'date_format' ), $date_end_timestamp ) );
		} else {
			$data->dates['title'] = sprintf( _x( 'Le %s', '%s = date', 'telabotanica' ), $date_title );
		}
	}

	if ( empty($data->categories) ) {
		foreach ( get_the_category() as $category ) {
			$data->categories[] = [
				'href' => get_category_link( $category->term_id ),
				'text' => $category->name
			];
		}
	}

	echo $pug->render(__DIR__ . '/list-articles-item.pug', [
		'data' => $data
	]);
}
