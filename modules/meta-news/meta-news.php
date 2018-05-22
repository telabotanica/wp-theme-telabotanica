<?php function telabotanica_module_meta_news($data) {
  $category = get_the_category();

  echo '<div class="meta-news">';

  if ( count($category) > 0 ) :
    the_telabotanica_module('button', [
      'href' => get_category_link( $category[0] ),
      'text' => __( 'Retour', 'telabotanica' ),
      'modifiers' => 'link back'
    ] );
  endif;

  if ( get_field('place') ) :
    if ($category[0]->parent === 30) : // $category->parent === 30 is 'offres-emploi'
      echo '<div class="meta-news-item meta-news-job-loc">';
    else :
      echo '<div class="meta-news-item meta-news-place">';
    endif;
    the_telabotanica_module('icon', ['icon' => 'marker']);
    printf(
      '<span>%s</span>',
      telabotanica_format_place( get_field( 'place' ) )
    );
    echo '</div>';
  endif;

  echo '<div class="meta-news-item meta-news-date">';
  the_telabotanica_module('icon', ['icon' => 'clock']);
  printf(
    '<time datetime="%s" title="%s">%s</time>',
    get_the_time( 'Y-m-d\\TG:i:s\\Z' ),
    sprintf( _x( '%s à %s', '%s = date et %s = heure', 'telabotanica' ),
      date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ),
      date_i18n( get_option( 'time_format' ), get_the_time( 'U' ) )
    ),
    sprintf( __( 'Publié le %s', 'telabotanica' ), get_the_date() )
  );
  echo '</div>';

  printf(
    '<div class="meta-news-item meta-news-author">%s<span>%s</span></div>',
    get_telabotanica_module('icon', ['icon' => 'user']),
    sprintf(
      __( 'par %s', 'telabotanica' ),
      sprintf(
        '<a href="%s">%s</a>',
        esc_url( bp_core_get_user_domain( get_the_author_meta( 'ID' ) ) ),
        get_the_author()
      )
    )
  );

  // if ( get_the_tags() ) :
  if ( count($category) > 0 ) :
    echo '<div class="meta-news-item meta-news-categories">';
    the_telabotanica_module('icon', ['icon' => 'bookmark']);
    the_telabotanica_module('categories-labels');
    //   the_tags();
    echo '</div>';
  endif;

  echo '<div class="meta-news-item meta-news-share">';
    the_telabotanica_module('share');
  echo '</div>';

  echo '</div>';

}
