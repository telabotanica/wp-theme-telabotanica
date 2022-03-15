<?php function telabotanica_module_event_dates($data) {

  $defaults = [
    'tag' => 'div',
    'start' => [],
    'end' => false,
    'href' => false,
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('event-dates', $data->modifiers);

  $data->tag = $data->href ? 'a' : 'div';

  $date_timestamp = strtotime( get_field( 'date', null, false ) );
  $date_end_timestamp = strtotime( get_field( 'date_end', null, false ) );

  $data->start = [
    'datetime' => date_i18n('Y-m-d', $date_timestamp),
    'day' => date_i18n('j', $date_timestamp),
    'month' => date_i18n('M', $date_timestamp),
    'year' => date_i18n('Y', $date_timestamp)

  ];

  if ( $date_end_timestamp ) :
    $data->end = [
      'datetime' => date_i18n('Y-m-d', $date_end_timestamp),
      'day' => date_i18n('j', $date_end_timestamp),
      'month' => date_i18n('M', $date_end_timestamp),
      'year' => date_i18n('Y', $date_end_timestamp)
    ];
  endif;

  $date_title = date_i18n( get_option( 'date_format' ), $date_timestamp );

  if ( $data->end ) {
    $data->title = sprintf( _x( 'Du %s au %s', '%s = dates', 'telabotanica' ), $date_title, date_i18n( get_option( 'date_format' ), $date_end_timestamp ) );
  } else {
    $data->title = sprintf( _x( 'Le %s', '%s = date', 'telabotanica' ), $date_title );
  }

  printf(
    '<%s href="%s" class="%s" title="%s">',
    $data->tag,
    $data->href,
    implode(' ', $data->modifiers),
    $data->title
  );

    if ($data->start) {
      printf(
        '<time class="event-dates-item" datetime="%s">',
        $data->start['datetime']
      );
        printf(
          '<div class="event-dates-day">%s</div>',
          $data->start['day']
        );
        printf(
          '<div class="event-dates-month">%s</div>',
          $data->start['month'].(date('Y') !== $data->start['year'] ? ' '.$data->start['year'] : '')
        );
      echo '</time>';
    }

    if ($data->end) {
      printf(
        '<time class="event-dates-item is-end" datetime="%s">',
        $data->end['datetime']
      );
        printf(
          '<div class="event-dates-day">%s</div>',
          $data->end['day']
        );
        printf(
          '<div class="event-dates-month">%s</div>',
          $data->end['month'].(date('Y') !== $data->end['year'] ? ' '.$data->end['year'] : '')
        );
      echo '</time>';
    }

  printf('</%s>', $data->tag);

}
