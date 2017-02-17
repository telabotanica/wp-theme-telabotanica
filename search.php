<?php
// Are we searching in a specific index?
$current_index = get_query_var( 'index', false );

// Force a small header (without use cases navigation)
$header_small = true;
get_header();

// Get Algolia instance
$algolia = Algolia_Plugin::get_instance();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			if ( $current_index ) :

				// Retrieve the label for the current index
				$indices = $algolia->get_autocomplete_config()->get_config();
				foreach ( $indices as $index ) :
					if ( $index['index_id'] === $current_index ) {
						$current_index_label = $index['label'];
						$current_index_name = $index['index_name'];
					}
				endforeach;

				// Perform the search
				$index = $algolia->get_api()->get_client()->initIndex($current_index_name);
				$results = $index->search(get_search_query());

				the_telabotanica_module('cover-search', [
					'total_results' => false
				]);
				?>

				<div class="layout-left-col">
					<div class="layout-wrapper">
							<aside class="layout-column">
								<?php
								the_telabotanica_module('search-filters');
								the_telabotanica_module('button-top');
								?>
							</aside>
							<div class="layout-content">
								<?php
								the_telabotanica_module('breadcrumbs', [
									'items' => [
										[
											'href' => esc_url( home_url( '/' ) . '?s=' . get_search_query() ),
											'text' => __('Recherche', 'telabotanica')
										],
										[
											'text' => $current_index_label
										],
										[ 'text' => sprintf( _n(
											'%s résultat trouvé',
											'%s résultats trouvés',
											$results['nbHits'],
											'telabotanica'
										), number_format_i18n( $results['nbHits'] ) ) ]
									]
								]);

								var_dump($results);
								?>
							</div>
						</div>
					</div>

			<?php
			else :
				// Perform several queries in a single API call
				$queries = [];
				$indices = $algolia->get_autocomplete_config()->get_config();

				foreach ( $indices as $index ) :
					$queries[] = [
						'indexName' => $index['index_name'],
						'query' => get_search_query(),
						'hitsPerPage' => $index['max_suggestions'] * 2,
						'facetFilters' => array_key_exists('default_facet_filters', $index) ? $index['default_facet_filters'] : null
					];
				endforeach;

				$results = $algolia->get_api()->get_client()->multipleQueries($queries);
				$total_results = array_sum(array_column($results['results'], 'nbHits'));

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
			?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
