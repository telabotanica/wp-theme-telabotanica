<?php
/**
 * Page d'accueil
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			the_telabotanica_module('cover-home');
			?>

			<div class="layout-content-col reversed">
				<div class="layout-wrapper">
					<div class="layout-content">
						<?php
						the_telabotanica_module('title', [
							'title' => __('À la Une', 'telabotanica'),
							'level' => 2,
							'modifiers' => 'with-margin-top'
						]);

						$category_actualites = get_category_by_slug( 'actualites' );
						$front_page_post = get_posts( [
							'category' => $category_actualites->cat_ID,
							'numberposts' => 1,
							'orderby' => 'date',
							'order' => 'DESC',
						] );
						if ( $front_page_post ) :
							foreach ( $front_page_post as $post ) :
								setup_postdata( $post );
								the_telabotanica_module('article');
								the_telabotanica_module('button', [
									'href' => get_permalink(),
									'text' => 'Lire la suite'
								]);
							endforeach;
						endif;
						?>

						<?php
						the_telabotanica_module('title', [
							'title' => __('Les outils de Tela Botanica', 'telabotanica'),
							'level' => 2,
							'modifiers' => 'with-separator'
						]);

						the_telabotanica_component('tools', [
							'items' => [
								[
									'title' => "Nom de l'outil",
									'description' => "Ceci est la description de l'outil",
									'link' => '#',
									'link_text' => 'Lien',
									'color' => '#a2b93b',
									'icon' => get_template_directory_uri() . '/components/tools/sample-icon.svg'
								],
								[
									'title' => "Nom d'un autre outil",
									'description' => "Ceci est la description de l'autre outil",
									'link' => '#',
									'link_text' => 'Lien',
									'color' => '#e16e38'
								],
							]
						]);

						the_telabotanica_component('buttons', [
							'items' => [
								[
									'link' => [
										'url' => '#'
									],
									'text' => __('Voir tous les outils', 'telabotanica')
								]
							]
						]);
						?>
					</div>
					<aside class="layout-column">
						<?php
						the_telabotanica_module('title', [
							'title' => __('Les dernières actus', 'telabotanica'),
							'level' => 2,
							'modifiers' => 'with-margin-top'
						]);

						$category_actualites = get_category_by_slug( 'actualites' );
						$category_evenements = get_category_by_slug( 'evenements' );
						$category_emploi = get_category_by_slug( 'offres-emploi' );

						the_telabotanica_module('column-articles', [
							'query' => new WP_Query([
								'post_type' => 'post',
								'cat' => implode(',', [
									$category_actualites->cat_ID//,
									// $category_evenements->cat_ID,
									// $category_emploi->cat_ID
							 	]),
								'posts_per_page' => 5
							])
						]);

						the_telabotanica_module('column-links', [
					    'items' => [
					      [
					        'text' => __("Toute l'actualité", "telabotanica"),
					        'href' => get_category_link( $category_actualites ),
					        'icon' => 'news'
					      ],
					      [
					        'text' => __("Tous les évènements", "telabotanica"),
					        'href' => get_category_link( $category_evenements ),
					        'icon' => 'calendar'
					      ],
					      [
					        'text' => __("Offres d'emplois / stages", "telabotanica"),
					        'href' => get_category_link( $category_emploi ),
					        'icon' => 'laptop'
					      ],
					      [
					        'text' => __("Soumettre une actualité", "telabotanica"),
					        'href' => '#', // TODO
					        'icon' => 'edit'
					      ]
					    ],
							'modifiers' => 'layout-column-item'
					  ] );

						the_telabotanica_module('newsletter', [
							'modifiers' => 'layout-column-item background-white with-shadow with-padding'
						] );
						?>
					</aside>
				</div>
			</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
