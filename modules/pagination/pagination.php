<?php function telabotanica_module_pagination($data) {

  $defaults = [
    'id' => false,
    'count_id' => false,
    'links_id' => false,
    'context' => 'wordpress',
    'type' => 'posts'
  ];

  $data = telabotanica_styleguide_data($defaults, $data);

  if ( $data->context === 'wordpress' ) :

    if ( $data->type === 'posts' ) :
      global $sort_events;
      // when events limit page count to $sort_events->max_num_pages
      if ($sort_events->max_num_pages) :
        $args['total'] = array('total' => $sort_events->max_num_pages);
      endif;

      $args = [
        'prev_text' => __( 'Page précédente', 'telabotanica' ),
        'next_text' => __( 'Page suivante', 'telabotanica' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'telabotanica' ) . ' </span>',
      ];


      the_posts_pagination( $args );

    endif;

  elseif ( $data->context === 'buddypress' ) :

    printf( '<div id="%s" class="pagination">', $data->id );
      // Do not display the pagination count

      // printf( '<div id="%s" class="pag-count">', $data->count_id );
      //   if ( $data->type === 'members' ) :
      //     bp_members_pagination_count();
      //   elseif ( $data->type === 'groups' ) :
      //     bp_groups_pagination_count();
      //   endif;
      // echo '</div>';

      printf( '<div id="%s" class="pagination-links">', $data->links_id );
        if ( $data->type === 'members' ) :
          bp_members_pagination_links();
        elseif ( $data->type === 'groups' ) :
          bp_groups_pagination_links();
        endif;
      echo '</div>';
    echo '</div>';

  endif;

}

// Personnalisation des boutons précédent / suivant dans les paginations buddypress
function telabotanica_bp_get_pagination_links($links) {
  $links = str_replace('&larr;', __( 'Page précédente', 'telabotanica' ), $links);
  $links = str_replace('←', __( 'Page précédente', 'telabotanica' ), $links);
  $links = str_replace('&rarr;', __( 'Page suivante', 'telabotanica' ), $links);
  $links = str_replace('→', __( 'Page suivante', 'telabotanica' ), $links);
  return $links;
}
add_filter( 'bp_get_members_pagination_links', 'telabotanica_bp_get_pagination_links', 10, 1 );
add_filter( 'bp_get_groups_pagination_links', 'telabotanica_bp_get_pagination_links', 10, 1 );
