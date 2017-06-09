<?php
/**
 * Thématique
 */
get_header(); ?>

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
									'href'   => '#' . get_sub_field('anchor')
								];

						    $first = false;

						    endwhile;
						}

						the_telabotanica_module('toc', [
							'items' => [
								['items' => $toc_items]
							]
						]);

						the_telabotanica_module('button-top');
						?>
					</aside>
					<div class="layout-content">
						<?php
						$breadcrumbs_items = ['home'];
						$breadcrumbs_items[] = [
							'href' => get_post_type_archive_link('tb_thematique'),
							'text' => __('Thématiques', 'telabotanica')
						];
						$breadcrumbs_items[] = ['text' => get_the_title()];

						the_telabotanica_module('breadcrumbs', [
							'items' => $breadcrumbs_items
						]);

						?>
						<article>
							<?php
							// Si la page utilise des composants
							if (have_rows('components')):

									// On boucle sur les composants
									while (have_rows('components')) : the_row();

										the_telabotanica_component(get_row_layout());

									endwhile;

							else :

									// no layouts found

							endif;
							?>
						</article>
					</div>
				</div>
			</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
