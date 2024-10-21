<?php function telabotanica_module_search_results_hit_flore($hit) {
  printf(
    '<a class="search-results-hit-link" href="%s" title="%s">',
    $hit['bdtfx']['permalink'],
    $hit['bdtfx']['scientific_name']
  );
    printf(
      '<span class="search-results-hit-post-title">%s</span>',
      $hit['_highlightResult']['bdtfx']['scientific_name']['value']
    );
    $noms=$hit['_highlightResult']['bdtfx']['common_name'];
    $noms_txt='';
    foreach($noms as $nom){
    	$noms_txt.=$nom['value'].', ';
    }
    $noms_txt=rtrim($noms_txt);
    $noms_txt=rtrim($noms_txt,',');
    printf(
      '<span class="search-results-hit-post-content">%s</span>',
      $noms_txt
    );
  echo '</a>';
}