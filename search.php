<?php

$search_query_raw = get_search_query();
$search_query = sanitize_text_field($search_query_raw);

// Are we searching in a specific index?
$current_index = sanitize_key( get_query_var( 'in', false ) );

// Redirect some indices to the category or page, while preserving the query
switch ($current_index) {
  case 'actualites':
    $cat = get_category_by_slug( 'actualites' );
    if ($cat) $redirect_url = get_category_link( $cat );
    break;

  case 'evenements':
    $cat = get_category_by_slug( 'evenements' );
    if ($cat) $redirect_url = get_category_link( $cat );
    break;

  case 'projets':
    $pages = get_option('bp-pages');
    $groups_page = $pages['groups'] ?? null;
    if ($groups_page) $redirect_url = get_permalink( $groups_page );
    break;
}

if ( isset($redirect_url) ) {
  wp_safe_redirect( add_query_arg('q', $search_query, $redirect_url) );
  exit;
}

// Force a small header (without use cases navigation)
$header_small = true;
get_header();

?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main">

      <?php
      if ( telabotanica_algolia_check(true) ) :

        // Get Algolia instance
        $algolia_client = telabotanica_algolia_client();
        $algolia_config = telabotanica_algolia_config();
        $algolia_autocomplete_config = $algolia_config['autocomplete'] ?? null;

        if ( !$algolia_client || !$algolia_autocomplete_config ) :
          echo '<p>' . esc_html__('Configuration Algolia incomplète.', 'telabotanica') . '</p>';
        elseif ( $current_index ) :

          // Retrieve the label for the current index
          $indices = $algolia_autocomplete_config['sources'];
          $current_index_data = null;
          foreach ( $indices as $index ) :
            if ( ($index['index_id'] ?? '') === $current_index ) {
              $current_index_data = [
                'id' => $current_index,
                'label' => $index['label'],
                'name' => $index['index_name'],
                'filters' => $index['filters'] ?? []
              ];
              break;
            }
          endforeach;

          if (!$current_index_data) :
            echo '<p>' . esc_html__('Index inconnu.', 'telabotanica') . '</p>';
          else :
            $decoded_query = urldecode($search_query);
            try {
              if (method_exists($algolia_client, 'searchSingleIndex')) {
                // PHP client v4 (Api\SearchClient)
                $results = $algolia_client->searchSingleIndex($current_index_data['name'], [
                  'query' => $decoded_query,
                  'hitsPerPage' => 20
                ]);
              } elseif (method_exists($algolia_client, 'initIndex')) {
                $index = $algolia_client->initIndex($current_index_data['name']);
                $results = $index->search($decoded_query, [
                  'hitsPerPage' => 20
                ]);
              } else {
                throw new Exception('Algolia client has no search method');
              }
            } catch (Exception $e) {
              $results = ['nbHits' => 0, 'hits' => []];
              error_log('[Algolia] search error: ' . $e->getMessage());
            }

            the_telabotanica_module('cover-search', [
              'index' => $current_index_data['id'],
              'total_results' => false,
              'instantsearch' => true
            ]);
            ?>

          <div class="layout-content-col">
            <div class="layout-wrapper">
              <aside class="layout-column">
                <?php
                the_telabotanica_module('search-filters', [
                  'filters' => $current_index_data['filters']
                ]);
                the_telabotanica_module('button-top');
                ?>
              </aside>
              <div class="layout-content">
                <?php
                the_telabotanica_module('breadcrumbs', [
                  'items' => [
                    [
                      'href' => esc_url( add_query_arg('s', $search_query, home_url('/')) ),
                      'text' => __('Recherche', 'telabotanica')
                    ],
                    [
                      'text' => $current_index_data['label']
                    ],
                    [ 'text' => '<span id="search-stats">' . sprintf( _n(
                        '%s résultat trouvé',
                        '%s résultats trouvés',
                        $results['nbHits'],
                        'telabotanica'
                      ), number_format_i18n( $results['nbHits'] ) ) . '</span>' ]
                  ]
                ]);

                echo '<div id="search-hits">';
                foreach ($results['hits'] as $hit) {
                  $hit['type'] = $current_index_data['id'];
                  the_telabotanica_module('search-hit', $hit);
                }
                echo '</div>';
                ?>
              </div>
            </div>
          </div>
          <?php
          endif;
        else :
          // Perform several queries in a single API call
          $queries = [];

          foreach ( $algolia_autocomplete_config['sources'] as $index ) :
            $q = [
              'indexName' => $index['index_name'],
              'query' => urldecode($search_query),
              'hitsPerPage' => ($index['settings']['hitsPerPage'] ?? 5) * 2,
            ];
            if (!empty($index['settings']['facetFilters'])) {
              $q['facetFilters'] = $index['settings']['facetFilters'];
            }
            $queries[] = array_filter($q, function($v) { return $v !== null && $v !== ''; });
          endforeach;

          try {
            if (method_exists($algolia_client, 'search')) {
              // PHP client v4: search(['requests' => ...])
              $response = $algolia_client->search(['requests' => $queries]);
              // v4 returns ['results'=> [...]] like v3, ensure compat
              $results = isset($response['results']) ? $response : ['results' => $response['results'] ?? $response];
              if (!isset($results['results'])) $results = ['results' => $results];
            } elseif (method_exists($algolia_client, 'multipleQueries')) {
              $results = $algolia_client->multipleQueries($queries);
            } else {
              throw new Exception('Algolia client has no multiple search method');
            }
          } catch (Exception $e) {
            $results = ['results' => []];
            error_log('[Algolia] multipleQueries error: ' . $e->getMessage());
          }
          $total_results = 0;
          if (!empty($results['results'])) {
            $total_results = array_sum(array_column($results['results'], 'nbHits'));
          }

          the_telabotanica_module('cover-search', [
            'total_results' => $total_results
          ]);
          ?>
          <div class="layout-central-col is-wide adjacent-top">
            <div class="layout-wrapper">
              <div class="layout-content">
                <?php
                the_telabotanica_module('search-results', $results);
                ?>
              </div>
            </div>
          </div>
        <?php
        endif;
      endif;
      ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
