<?php function telabotanica_module_search_results_hit_flore($hit) {
  $permalink = $hit['bdtfx']['permalink'] ?? '#';
  $scientific = $hit['bdtfx']['scientific_name'] ?? '';
  $highlight_scientific = $hit['_highlightResult']['bdtfx']['scientific_name']['value'] ?? esc_html($scientific);

  printf(
    '<a class="search-results-hit-link" href="%s" title="%s">',
    esc_url( $permalink ),
    esc_attr( $scientific )
  );
    printf(
      '<span class="search-results-hit-post-title">%s</span>',
      wp_kses_post( $highlight_scientific )
    );
    $noms = $hit['_highlightResult']['bdtfx']['common_name'] ?? [];
    $noms_txt = '';
    if (is_array($noms)) {
      $parts = array_filter(array_map(function($nom) {
        return $nom['value'] ?? '';
      }, $noms));
      $noms_txt = implode(', ', $parts);
    }
    printf(
      '<span class="search-results-hit-post-content">%s</span>',
      wp_kses_post( $noms_txt )
    );
  echo '</a>';
}
