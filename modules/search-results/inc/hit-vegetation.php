<?php

function telabotanica_module_search_results_hit_vegetation($hit)
{
    printf(
        '<a class="search-results-hit-link" href="%s" target="_blank" title="%s">',
        $hit['url'],
        $hit['commonName']
    );
    printf(
            '<span class="search-results-hit-post-title">%s</span>',
            $hit['_highlightResult']['syntaxon']['value']
        );
    echo '</a>';
}
