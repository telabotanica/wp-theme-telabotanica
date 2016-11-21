<?php function telabotanica_module_upcoming_events($data) { ?>
  <div class="upcoming-events <?php echo $data->modifiers ?>">
    <div class="upcoming-events-title">
      <?php the_telabotanica_module('icon', ['icon' => 'calendar']); ?>
      <?php echo __( "Évènements à venir", 'telabotanica' ) ?>
    </div>
    <ul class="upcoming-events-items">
      <?php
      $events = get_posts( [
        'posts_per_page' => 3,
        'meta_query' => [
          [
            'key' => 'date',
            'compare' => '>',
            'value' => date('Ymd'),
            'type' => 'DATE'
          ]
        ],
        'orderby' => 'meta_value_num',
        'meta_key' => 'date',
        'order' => 'ASC',
      ] );

      if ( $events ) :
        foreach ( $events as $event ) :
          $date_timestamp = strtotime( get_field( 'date', $event, false ) );
          preg_match( "/(\d{2})\d{3}\W(.+),\WFrance/", get_field( 'place', $event )['address'], $address );
          echo '<li class="upcoming-events-item">';
          echo sprintf(
            '<a href="%s" class="upcoming-events-item-link">
              <div class="upcoming-events-date">
                <div class="upcoming-events-date-day">%s</div>
                <div class="upcoming-events-date-month">%s</div>
              </div>
              <div class="upcoming-events-name">%s</div>
              <div class="upcoming-events-place">%s (%d)</div>
            </a>',
            get_permalink($event),
            date_i18n('j', $date_timestamp),
            date_i18n('M', $date_timestamp),
            get_the_title($event),
            @$address[2],
            @$address[1]
          );
          echo '</li>';
        endforeach;
        wp_reset_postdata();
      endif;
      ?>
    </ul>
    <a href="<?php echo get_category_link( get_category_by_slug( 'evenements' ) ) ?>" class="button block orange upcoming-events-button"><?php echo __( "Voir tous les évènements", 'telabotanica' ) ?></a>
  </div>
<?php }
