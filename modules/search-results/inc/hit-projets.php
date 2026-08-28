<?php function telabotanica_module_search_results_hit_projets($hit) {
  $permalink = $hit['permalink'] ?? '#';
  $name = $hit['name'] ?? '';
  $highlight_name = $hit['_highlightResult']['name']['value'] ?? esc_html($name);
  $highlight_desc = $hit['_highlightResult']['description']['value'] ?? '';

  printf(
    '<a class="search-results-hit-link" href="%s" title="%s">',
    esc_url( $permalink ),
    esc_attr( $name )
  );
    if (!empty($hit['image'])) {
      printf(
        '<img class="search-results-hit-group-thumbnail" src="%s" alt="%s" loading="lazy" />',
        esc_url( $hit['image'] ),
        esc_attr( $name )
      );
    }
    echo '<div class="search-results-hit-group-attributes">';
      printf(
        '<span class="search-results-hit-post-title">%s</span>',
        wp_kses_post( $highlight_name )
      );
      printf(
        '<span class="search-results-hit-post-content">%s</span>',
        wp_kses_post( $highlight_desc )
      );
    echo '</div>';
  echo '</a>';
}
