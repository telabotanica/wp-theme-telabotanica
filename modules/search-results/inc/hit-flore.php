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
		printf(
			'<span class="search-results-hit-post-content">%s</span>',
			$hit['_highlightResult']['bdtfx']['common_name']['value']
		);
	echo '</a>';
}
