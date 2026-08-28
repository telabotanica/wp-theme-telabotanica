<?php function telabotanica_module_search_results_hit_vegetation($hit) {
  $permalink = $hit['permalink'] ?? '#';
  $common = $hit['commonName'] ?? '';
  $highlight_syntaxon = $hit['_highlightResult']['syntaxon']['value'] ?? '';

  printf(
    '<a class="search-results-hit-link" href="%s" target="_blank" rel="noopener" title="%s">',
    esc_url( $permalink ),
    esc_attr( $common )
  );
    printf(
      '<span class="search-results-hit-post-title">%s</span>',
      wp_kses_post( $highlight_syntaxon )
    );
  echo '</a>';
}
