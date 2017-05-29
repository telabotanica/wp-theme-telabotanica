<?php
/**
 * Page.
 */
get_header();

$taxonomy_name = 'tb_participer_category';
$participer_categories = get_terms([
	'taxonomy'   => $taxonomy_name,
	'hide_empty' => false,
	'fields'     => 'all',
	'parent'     => 0,
]);

function participer_category($term)
{
    global $taxonomy_name;

    the_telabotanica_component('title', [
		'level'  => $term->parent === 0 ? 2 : 3,
		'anchor' => $term->slug,
		'title'  => $term->name,
	]);

    if (!empty($term->description)) {
        the_telabotanica_component('text', [
			'text' => sprintf('<p>%s</p>', $term->description),
		]);
    }

    $items = get_posts([
		'post_type' => 'tb_participer',
		'tax_query' => [
			[
				'taxonomy'         => $taxonomy_name,
				'field'            => 'term_id',
				'terms'            => $term->term_id,
				'include_children' => false,
			],
		],
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
		'numberposts' => -1,
	]);

    the_telabotanica_component('articles', [
		'title_level' => $term->parent === 0 ? 3 : 4,
		'items'       => $items,
	]);
}

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php the_telabotanica_module('cover'); ?>

			<div class="layout-content-col">
				<div class="layout-wrapper">
					<aside class="layout-column">
						<?php
						$toc_items = [];

						// Si la page utilise des composants
						if (have_rows('components')) {
						    $first = true;

							// On boucle sur les composants
							while (have_rows('components')) : the_row();

								// On garde seulement les intertitres
								if (get_row_layout() !== 'title') {
								    continue;
								}

								// On garde seulement les intertitres de niveau 2
								if (get_sub_field('level') !== '2') {
								    continue;
								}

						    $toc_items[] = [
									'active' => $first,
									'text'   => get_sub_field('title'),
									'href'   => '#'.get_sub_field('anchor'),
								];

						    $first = false;

						    endwhile;
						}

						$toc_items = array_merge($toc_items, $participer_categories);

						the_telabotanica_module('toc', [
							'items' => [
								['items' => $toc_items],
							],
						]);

						the_telabotanica_module('button-top');
						?>
					</aside>
					<div class="layout-content">
						<?php the_telabotanica_module('breadcrumbs', []); ?>
						<article>
							<?php
							// Si la page utilise des composants
							if (have_rows('components')):

									// On boucle sur les composants
									while (have_rows('components')) : the_row();

										the_telabotanica_component(get_row_layout(), []);

									endwhile;

							else :

									// no layouts found

							endif;

							foreach ($participer_categories as $term) :

								participer_category($term);

								foreach (get_term_children($term->term_id, $taxonomy_name) as $child) :
									$term_child = get_term_by('id', $child, $taxonomy_name);
									participer_category($term_child);
								endforeach;

							endforeach;

							?>
						</article>
					</div>
				</div>
			</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
