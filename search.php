<?php
// Are we searching in a specific index?
$current_index = get_query_var( 'index', false );

// Redirect some indices to the category or page, while preserving the query
switch ($current_index) {
	case 'actualites':
		$redirect_url = get_category_link( get_category_by_slug( 'actualites' ) );
		break;

	case 'evenements':
		$redirect_url = get_category_link( get_category_by_slug( 'evenements' ) );
		break;

	case 'projets':
		$redirect_url = get_permalink(get_page_by_path( 'projets' ));
		break;
}

if ( isset($redirect_url) ) {
	wp_redirect( $redirect_url . '?q=' . get_search_query() );
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
				$algolia_autocomplete_config = telabotanica_algolia_autocomplete_config();

				if ( $current_index ) :

					// Retrieve the label for the current index
					$indices = $algolia_autocomplete_config['sources'];
					foreach ( $indices as $index ) :
						if ( $index['index_id'] === $current_index ) {
							$current_index_label = $index['label'];
							$current_index_name = $index['index_name'];
						}
					endforeach;

					// Perform the search
					$index = $algolia_client->initIndex($current_index_name);
					$results = $index->search(get_search_query());

					the_telabotanica_module('cover-search', [
						'total_results' => false
					]);
					?>

					<div class="layout-content-col">
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

					foreach ( $algolia_autocomplete_config['sources'] as $index ) :
						$queries[] = [
							'indexName' => $index['index_name'],
							'query' => get_search_query(),
							'hitsPerPage' => $index['settings']['hitsPerPage'] * 2,
							'facetFilters' => array_key_exists('facetFilters', $index['settings']) ? $index['settings']['facetFilters'] : null
						];
					endforeach;

					$results = $algolia_client->multipleQueries($queries);
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
			endif;
			?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
