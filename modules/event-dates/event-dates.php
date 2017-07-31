<?php function telabotanica_module_event_dates($data) {
	global $pug;

	$defaults = [
		'start' => [],
		'end' => false,
		'href' => false,
		'modifiers' => []
	];

	$data = telabotanica_styleguide_data($defaults, $data);

	$date_timestamp = strtotime( get_field( 'date', null, false ) );
	$date_end_timestamp = strtotime( get_field( 'date_end', null, false ) );

	$data->start = [
		'datetime' => date_i18n('Y-m-d', $date_timestamp),
		'day' => date_i18n('j', $date_timestamp),
		'month' => date_i18n('M', $date_timestamp)
	];

	if ( $date_end_timestamp ) :
		$data->end = [
			'datetime' => date_i18n('Y-m-d', $date_end_timestamp),
			'day' => date_i18n('j', $date_end_timestamp),
			'month' => date_i18n('M', $date_end_timestamp)
		];
	endif;

	$date_title = date_i18n( get_option( 'date_format' ), $date_timestamp );

	if ( $data->end ) {
		$data->title = sprintf( _x( 'Du %s au %s', '%s = dates', 'telabotanica' ), $date_title, date_i18n( get_option( 'date_format' ), $date_end_timestamp ) );
	} else {
		$data->title = sprintf( _x( 'Le %s', '%s = date', 'telabotanica' ), $date_title );
	}

	echo $pug->render(__DIR__ . '/event-dates.pug', [
		'data' => $data
	]);

}
