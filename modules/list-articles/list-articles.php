<?php function telabotanica_module_list_articles($data) {
  $category = get_category( get_query_var('cat') );
  $category_evenements = get_category_by_slug( 'evenements' );
  $is_category_events = is_category( $category_evenements ) || cat_is_ancestor_of( $category_evenements, $category );

  echo '<div class="list-articles ' . ( $is_category_events ? ' only-events' : '' ) . '">';

  if ( have_posts() ) :
    while ( have_posts() ) : the_post();
      $is_event = !empty( get_field( 'date' ) );
      ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class( 'list-articles-item ' . ( $is_event ? 'is-event' : '') ); ?>>
        <?php
        if ( $is_event ) :
          $date_timestamp = strtotime( get_field( 'date', null, false ) );
          $date_end_timestamp = strtotime( get_field( 'date_end', null, false ) );
          $date_title = date_i18n( get_option( 'date_format' ), $date_timestamp );
          if ( $date_end_timestamp ) :
            $date_title = sprintf( _x( 'Du %s au %s', '%s = dates', 'telabotanica' ), $date_title, date_i18n( get_option( 'date_format' ), $date_end_timestamp ) );
          else :
            $date_title = sprintf( _x( 'Le %s', '%s = date', 'telabotanica' ), $date_title );
          endif;
          echo '<a href="' . esc_url( get_permalink() ) . '" class="list-articles-dates" title="' . $date_title . '">';
          echo sprintf(
            '<time datetime="%s" class="list-articles-dates-item"><div class="list-articles-dates-day">%s</div><div class="list-articles-dates-month">%s</div></time>',
            date_i18n('Y-m-d', $date_timestamp),
            date_i18n('j', $date_timestamp),
            date_i18n('M', $date_timestamp)
          );
          if ( $date_end_timestamp ) {
            echo sprintf(
              '<time datetime="%s" class="list-articles-dates-item is-end"><div class="list-articles-dates-day">%s</div><div class="list-articles-dates-month">%s</div></time>',
              date_i18n('Y-m-d', $date_end_timestamp),
              date_i18n('j', $date_end_timestamp),
              date_i18n('M', $date_end_timestamp)
            );
          }
          echo '</a>';
        else :
          echo sprintf(
            '<a href="%s" class="list-articles-image">%s</a>',
            esc_url( get_permalink() ),
            has_post_thumbnail() ? get_the_post_thumbnail( null, 'post-thumbnail', array( 'class' => 'list-articles-image' ) ) : ''
          );
        endif;
        ?>
        <div class="list-articles-text">
          <div class="list-articles-meta">
            <?php
            if ( $is_event ) :
              $place = get_field( 'place' );
              echo '<span class="list-articles-place">' . telabotanica_format_place( $place ) . '</span>';
            endif;

            echo sprintf(
              '<span class="list-articles-date" title="%s">%s <time datetime="%s">%s</time></span>',
              sprintf( _x( '%s à %s', '%s = date et %s = heure', 'telabotanica' ),
                date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ),
                date_i18n( get_option( 'time_format' ), get_the_time( 'U' ) )
              ),
              get_telabotanica_module('icon', ['icon' => 'clock']),
              get_the_time( 'Y-m-d\\TG:i:s\\Z' ),
              sprintf( _x( 'il y a %s', '%s = intervalle de temps', 'telabotanica' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) )
            );
            ?>
            &ndash;
            <span class="list-articles-author"><?php echo sprintf( __( 'par %s', 'telabotanica' ), get_the_author() ); ?></span>
            <span class="list-articles-categories"><?php the_category( ' ' ); ?></span>
          </div>
          <?php the_title( sprintf( '<h2 class="list-articles-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
          <?php the_excerpt(); ?>
        </div>
      </article>
    <?php endwhile;

    the_telabotanica_module('pagination');
    ?>
  <?php else :
    echo '<p>' . __( 'Aucune actualité dans cette catégorie.', 'telabotanica' ) . '</p>';
  endif;

  echo '</div>';

}
