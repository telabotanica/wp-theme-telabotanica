<?php
/**
 * Toutes les thématiques.
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php the_telabotanica_module('cover', [
				'title'    => __('Toutes les thématiques', 'telabotanica'),
				'subtitle' => false,
			]); ?>

			<div class="layout-content-col">
				<div class="layout-wrapper">
					<aside class="layout-column">
						<?php the_telabotanica_module('button-top'); ?>
					</aside>
					<div class="layout-content">
						<?php
						$breadcrumbs_items = ['home'];
						$breadcrumbs_items[] = ['text' => __('Thématiques', 'telabotanica')];

						the_telabotanica_module('breadcrumbs', [
							'items' => $breadcrumbs_items,
						]);

						// Trier par ordre alphabétique et désactiver la pagination
						global $query_string;
						query_posts($query_string.'&order=ASC&orderby=name&posts_per_page=-1');

						if (have_posts()) :
							while (have_posts()) : the_post();
								the_telabotanica_module('article', [
									'title_level' => 2,
									'thumbnail'   => get_field('cover_image'),
									'text'        => get_field('cover_subtitle'),
									'modifiers'   => 'is-small',
								]);
							endwhile;

							the_telabotanica_module('pagination');
							?>
						<?php else :
							echo '<p>'.__('Aucun moyen de participer.', 'telabotanica').'</p>';
						endif; ?>
					</div>
				</div>
			</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
