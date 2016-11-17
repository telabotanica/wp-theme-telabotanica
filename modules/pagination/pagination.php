<?php function telabotanica_module_pagination($data) {

  the_posts_pagination( [
    'prev_text'          => __( 'Page précédente', 'telabotanica' ),
    'next_text'          => __( 'Page suivante', 'telabotanica' ),
    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'telabotanica' ) . ' </span>',
  ] );
  
}
