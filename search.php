<?php
// Force a small header (without use cases navigation)
$header_small = true;
get_header();

$algolia = Algolia_Plugin::get_instance();

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
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
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

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
