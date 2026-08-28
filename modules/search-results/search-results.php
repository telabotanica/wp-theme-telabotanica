<?php
// Load methods for rendering specific hits
require_once 'inc/hit-projets.php';
require_once 'inc/hit-flore.php';
require_once 'inc/hit-vegetation.php';

function telabotanica_module_search_results_hit($index_id, $hit) {
  $function = 'telabotanica_module_search_results_hit_' . sanitize_key($index_id);
  if (function_exists($function)) {
    call_user_func($function, $hit);
  } else {
    $permalink = $hit['permalink'] ?? '#';
    $title = $hit['post_title'] ?? '';
    $highlight = $hit['_highlightResult']['post_title']['value'] ?? esc_html($title);
    printf(
      '<a href="%s" title="%s" class="search-results-hit-link">',
      esc_url( $permalink ),
      esc_attr( $title )
    );
    echo '<div class="search-results-hit-post-attributes">';
    printf(
      '<span class="search-results-hit-post-title">%s</span>',
      wp_kses_post( $highlight )
    );
    echo '</div>';
    echo '</a>';
  }
}

function telabotanica_module_search_results($data) {
  if ( !telabotanica_algolia_check(true) ) { return; }

  $config = telabotanica_algolia_config();
  if (empty($config['autocomplete']['sources'])) return;
  $algolia_autocomplete_config = $config['autocomplete'];

  // Retrieve the label for each index
  $indices_ids = [];
  $indices_labels = [];
  foreach ( $algolia_autocomplete_config['sources'] as $index ) :
    if (empty($index['index_name']) || empty($index['index_id'])) continue;
    $indices_ids[$index['index_name']] = $index['index_id'];
    $indices_labels[$index['index_name']] = $index['label'];
  endforeach;

  if (empty($data->results)) return;

  echo '<div class="search-results">';

  foreach ( $data->results as $results ) :
    $index_name = $results['index'] ?? '';
    if (!isset($indices_ids[$index_name])) continue;
    $index_id = $indices_ids[$index_name];
    $query = $results['query'] ?? '';
    $link_more = add_query_arg(['s' => $query, 'in' => $index_id], home_url('/'));

    echo '<div class="search-results-index has-more">';

      // header
      printf(
        '<a href="%s" class="search-results-header">',
        esc_url( $link_more )
      );
        printf(
          '<div class="search-results-header-title">%s</div>',
          esc_html( $indices_labels[$index_name] )
        );
        printf(
          '<div class="search-results-header-count">%s</div>',
          esc_html( $results['nbHits'] )
        );
      echo '</a>';

      // hits / empty
      if ( !empty($results['nbHits']) ) :
        echo '<div class="search-results-hits">';
          foreach ( $results['hits'] as $hit ) :
            echo '<div class="search-results-hit">';
              telabotanica_module_search_results_hit($index_id, $hit);
            echo '</div>';
          endforeach;
        echo '</div>';
      else :
        printf(
          '<div class="search-results-empty">%s<span class="search-results-empty-query">"%s"</span></div>',
          esc_html__( 'Aucun résultat pour ', 'telabotanica' ),
          esc_html( $query )
        );
      endif;

      // more
      printf(
        '<div class="search-results-more"><a href="%s">%s</a></div>',
        esc_url( $link_more ),
        esc_html__( 'Afficher tous les résultats', 'telabotanica' )
      );

    echo '</div>';
  endforeach;
  ?>
  <div class="search-results-footer">
    <div class="search-results-footer-branding">
      <?php esc_html_e( 'Powered by', 'algolia' ); ?>
      <a href="https://www.algolia.com/?utm_source=WordPress&utm_medium=extension&utm_content=<?php echo esc_attr($_SERVER['HTTP_HOST'] ?? ''); ?>&utm_campaign=poweredby" class="algolia-powered-by-link" title="Algolia" target="_blank" rel="noopener">
        <img class="algolia-logo" src="https://www.algolia.com/assets/algolia128x40.png" alt="Algolia" loading="lazy" />
      </a>
    </div>
  </div>
  <?php
  echo '</div>';
}
