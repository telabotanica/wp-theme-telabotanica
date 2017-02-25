<?php
// Load methods for rendering specific hits
require_once 'inc/hit-projets.php';
require_once 'inc/hit-flore.php';
require_once 'inc/hit-vegetation.php';

function telabotanica_module_search_results_hit($index_id, $hit) {
	$function = 'telabotanica_module_search_results_hit_' . $index_id;
	if (function_exists($function)) {
		call_user_func($function, $hit);
	} else {
		echo sprintf(
			'<a href="%s" title="%s" class="search-results-hit-link">',
			$hit['permalink'],
			$hit['post_title']
		);
		echo '<div class="search-results-hit-post-attributes">';
		echo sprintf(
			'<span class="search-results-hit-post-title">%s</span>',
			$hit['_highlightResult']['post_title']['value']
		);
		echo '</div>';
		echo '</a>';
	}
}

function telabotanica_module_search_results($data) {
	if ( !class_exists( 'Algolia_Plugin' ) ) { return; }
	$algolia = Algolia_Plugin::get_instance();

	// Retrieve the label for each index
	$indices_ids = [];
	$indices_labels = [];
	$indices = $algolia->get_autocomplete_config()->get_config();
	foreach ( $indices as $index ) :
		$indices_ids[$index['index_name']] = $index['index_id'];
		$indices_labels[$index['index_name']] = $index['label'];
	endforeach;

	echo '<div class="search-results">';

	foreach ( $data->results as $results ) :
		$link_more = '/?s=' . $results['query'] . '&index=' . $indices_ids[$results['index']]; // TODO

		echo '<div class="search-results-index has-more">';

			// header
			echo sprintf(
				'<a href="%s" class="search-results-header">',
				$link_more
			);
				echo sprintf(
					'<div class="search-results-header-title">%s</div>',
					$indices_labels[$results['index']]
				);
				echo sprintf(
					'<div class="search-results-header-count">%s</div>',
					$results['nbHits']
				);
			echo '</a>';

			// hits / empty
			if ( $results['nbHits'] !== 0 ) :
				echo '<div class="search-results-hits">';
					foreach ( $results['hits'] as $hit ) :
						echo '<div class="search-results-hit">';
							telabotanica_module_search_results_hit($indices_ids[$results['index']], $hit);
						echo '</div>';
					endforeach;
				echo '</div>';
			else :
				printf(
					'<div class="search-results-empty">%s<span class="search-results-empty-query">"%s"</span></div>',
					__( 'Aucun résultat pour ', 'telabotanica' ),
					$results['query']
				);
			endif;

			// more
			printf(
				'<div class="search-results-more"><a href="%s">%s</a></div>',
				$link_more,
				__( 'Afficher tous les résultats', 'telabotanica' )
			);

		echo '</div>';
	endforeach;
	?>
	<div class="search-results-footer">
		<div class="search-results-footer-branding">
			<?php esc_html_e( 'Powered by', 'algolia' ); ?>
			<a href="#" class="algolia-powered-by-link" title="Algolia">
				<img class="algolia-logo" src="https://www.algolia.com/assets/algolia128x40.png" alt="Algolia" />
			</a>
		</div>
	</div>
	<?php
	echo '</div>';
}
