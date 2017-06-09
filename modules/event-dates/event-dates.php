<?php

function telabotanica_module_event_dates($data)
{
    $defaults = [
		'date'      => get_field('date', null, false),
		'date_end'  => get_field('date_end', null, false),
		'tag'       => 'a',
		'modifiers' => []
	];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array('event-dates', $data->modifiers);

    $date_timestamp = strtotime($data->date);
    $date_end_timestamp = strtotime($data->date_end);
    $date_title = date_i18n(get_option('date_format'), $date_timestamp);
    if ($date_end_timestamp) :
		$date_title = sprintf(_x('Du %s au %s', '%s = dates', 'telabotanica'), $date_title, date_i18n(get_option('date_format'), $date_end_timestamp)); else :
		$date_title = sprintf(_x('Le %s', '%s = date', 'telabotanica'), $date_title);
    endif;

    if ($data->tag === 'a') :
		printf(
			'<%s href="%s" class="%s" title="%s">',
			$data->tag,
			esc_url(get_permalink()),
			implode(' ', $data->modifiers),
			$date_title
		); else :
		printf(
			'<%s class="%s">',
			$data->tag,
			implode(' ', $data->modifiers)
		);
    endif;

    printf(
			'<time datetime="%s" class="event-dates-item"><div class="event-dates-day">%s</div><div class="event-dates-month">%s</div></time>',
			date_i18n('Y-m-d', $date_timestamp),
			date_i18n('j', $date_timestamp),
			date_i18n('M', $date_timestamp)
		);
    if ($date_end_timestamp) {
        printf(
				'<time datetime="%s" class="event-dates-item is-end"><div class="event-dates-day">%s</div><div class="event-dates-month">%s</div></time>',
				date_i18n('Y-m-d', $date_end_timestamp),
				date_i18n('j', $date_end_timestamp),
				date_i18n('M', $date_end_timestamp)
			);
    }

    printf(
		'</%s>',
		$data->tag
	);
}
