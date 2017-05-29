<?php

function telabotanica_module_search_results_hit_projets($hit)
{
    printf(
		'<a class="search-results-hit-link" href="%s" title="%s">',
		$hit['permalink'],
		$hit['name']
	);
    if ($hit['image']) {
        printf(
				'<img class="search-results-hit-group-thumbnail" src="%s" alt="%s" />',
				$hit['image'],
				$hit['name']
			);
    }
    echo '<div class="search-results-hit-group-attributes">';
    printf(
				'<span class="search-results-hit-post-title">%s</span>',
				$hit['_highlightResult']['name']['value']
			);
    printf(
				'<span class="search-results-hit-post-content">%s</span>',
				$hit['_highlightResult']['description']['value']
			);
    echo '</div>';
    echo '</a>';
}
