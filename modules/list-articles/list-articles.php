<?php function telabotanica_module_list_articles($data) {

  echo '<div class="list-articles">';

  if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'list-articles-item' ); ?>>
      <?php
      echo sprintf(
        '<a href="%s" class="list-articles-image">%s</a>',
        esc_url( get_permalink() ),
        has_post_thumbnail() ? get_the_post_thumbnail( null, 'post-thumbnail', array( 'class' => 'list-articles-image' ) ) : ''
      );
      ?>
      <div class="list-articles-text">
        <div class="list-articles-meta">
          <?php echo sprintf(
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

    the_posts_pagination( [
      'prev_text'          => __( 'Page précédente', 'telabotanica' ),
      'next_text'          => __( 'Page suivante', 'telabotanica' ),
      'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'telabotanica' ) . ' </span>',
    ] );
    ?>
  <?php else :
    echo '<p>' . __( 'Aucune actualité dans cette catégorie.', 'telabotanica' ) . '</p>';
  endif;

  echo '</div>';

}
