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
							'level' => 2
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

						the_telabotanica_module('form-newsletter', [
							'modifiers' => 'layout-column-item background-white with-shadow with-padding'
						] ); ?>
					</aside>
				</div>
			</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
