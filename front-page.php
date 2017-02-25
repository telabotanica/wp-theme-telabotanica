<?php
/**
 * Page d'accueil
 */

get_header();

$category_actualites = get_category_by_slug( 'actualites' );
$category_evenements = get_category_by_slug( 'evenements' );
$category_emploi = get_category_by_slug( 'offres-emploi' );
?>

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

						$latest_post = new WP_Query([
							'post_type' => 'post',
							'cat' => 10, // TODO
							'posts_per_page' => 1
						]);
						while ( $latest_post->have_posts() ) : $latest_post->the_post();
							$latest_post_id = get_the_ID();
							the_telabotanica_module('article', [
								'href' => get_the_permalink(),
								'title' => get_the_title(),
								'image' => has_post_thumbnail() ? get_the_post_thumbnail( null, 'home-latest-post' ) : false,
								'text' => get_the_excerpt()
							]);
						endwhile;


						the_telabotanica_module('button', [
							'href' => get_permalink(),
							'text' => __('Lire la suite', 'telabotanica')
						]);

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
										'url' => get_permalink( get_page_by_path( 'outils' ) )
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

						the_telabotanica_module('column-articles', [
							'query' => new WP_Query([
								'post_type' => 'post',
								'cat' => implode(',', [
									$category_actualites->cat_ID//,
									// $category_evenements->cat_ID,
									// $category_emploi->cat_ID
							 	]),
								'posts_per_page' => 5,
								// évite d'afficher 2 fois l'actu à la Une
								'post__not_in' => [$latest_post_id]
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
									'text' => __("Proposer une actualité", "telabotanica"),
									'href' => get_permalink( get_page_by_path( 'proposer-une-actualite' ) ),
									'icon' => 'edit'
								]
							],
							'modifiers' => 'layout-column-item'
						] );

						the_telabotanica_module('newsletter', [
							'modifiers' => ['layout-column-item', 'background-white', 'with-shadow', 'with-padding']
						] );
						?>
					</aside>
				</div>
			</div>

			<div class="layout-content-col reversed reversed-colors">
				<div class="layout-wrapper">
					<div class="layout-content">
					</div>
					<aside class="layout-column">
						<?php
						the_telabotanica_module('title', [
							'title' => __('Cartographies', 'telabotanica'),
							'level' => 2,
							'modifiers' => 'with-margin-top'
						]);

						the_telabotanica_module('column-features', [
							'items' => [
								[
									'href' => '#', // TODO
									'icon' => 'news',
									'color' => '#009fb8',
									'title' => "110 pays",
									'text' => __("Le réseau Tela Botanica rassemble des passionnés de tous pays", 'telabotanica'),
								],
								[
									'href' => '#', // TODO
									'icon' => 'members',
									'color' => '#ff5d55',
									'title' => "28 214 telabotanistes",
									'text' => __("Trouvez les inscrits près de chez vous et prenez contact", 'telabotanica'),
								],
								[
									'href' => '#', // TODO
									'icon' => 'home',
									'color' => '#918a6f',
									'title' => "172 structures",
									'text' => __("À travers le monde, les structures locales vous accompagnent dans vos découvertes naturalistes", 'telabotanica'),
								]
							],
							'modifiers' => 'layout-column-item'
						]);

						the_telabotanica_module('button', [
							'href' => '#', // TODO
							'text' => __('Explorer les cartographies', 'telabotanica'),
							'modifiers' => ['block', 'orange']
						]);
						?>
					</aside>
				</div>
			</div>

			<?php
			the_telabotanica_block('contribute', [
				'background_color' => '#f8f5ef',
				'title' => __('Contribuez dès maintenant', 'telabotanica'),
				'query' => new WP_Query([
					'post_type' => 'tb_participer',
					'posts_per_page' => 3,
					'orderby' => 'rand'
				]),
				'buttons' => [
					'display' => 'buttons',
					'items' => [
						[
							'href' => get_permalink( get_page_by_path( 'comment-participer' ) ),
							'text' => __('Trouver un moyen de participer', 'telabotanica'),
							'modifiers' => 'orange'
						]
					]
				]
			]);

			the_telabotanica_block('focus', [
				'background_color' => '#f8f5ef',
				'title' => __('Rejoignez un projet citoyen', 'telabotanica'),
				'intro' => __('Un programme de <strong>science participative</strong> est un programme conduit en partenariat entre des observateurs (citoyens) et un laboratoire ou une structure à vocation scientifique, visant à observer ou étudier un phénomène dans le cadre d’un protocole bien défini.', 'telabotanica'),
				'display_buttons' => ['intro'],
				'intro_buttons' => [
					'display' => 'buttons',
					'items' => [
						[
							'href' => get_permalink( get_page_by_path( 'projets' ) ),
							'text' => __('Voir tous les projets', 'telabotanica')
						]
					]
				]
			]);

			the_telabotanica_block('list-projects', [
				'background_color' => '#f8f5ef',
				'query' => [
					'type' => 'popular', // TODO filter only "science participative"
					'max' => 4
				]
			]);
			?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
