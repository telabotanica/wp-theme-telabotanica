<?php

function telabotanica_module_search_filters($data)
{
    echo '<div class="search-filters">';
    the_telabotanica_module('title', [
            'title'     => __('Filtrer les résultats', 'telabotanica'),
            'level'     => 2,
            'modifiers' => ['search-filters-title', 'with-border-bottom'],
        ]);
    echo '<ul class="search-filters-items">';
    echo '</ul>';
    echo '</div>';
}
