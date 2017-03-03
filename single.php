<?php
/**
 * Post
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>
				<div class="layout-central-col">
					<div class="layout-wrapper">
						<?php while ( have_posts() ) : the_post(); ?>
							<aside class="layout-aside">
								<?php the_telabotanica_module('meta-news'); ?>
							</aside>
							<div class="layout-content">
								<?php the_telabotanica_module('breadcrumbs'); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?>>
									<?php

									the_title( '<h1 class="article-title">', '</h1>' );

									if ( get_field('intro') ) :

										the_telabotanica_component('intro', [
											'text' => get_field('intro')
										]);

									endif;

									// EN KIOSQUE
									if ( has_category('en-kiosque') ) :

										the_telabotanica_component('text', [
											'text' => get_field('presentation')
										]);

										if ( get_field('author') ) :

											the_telabotanica_component('title', [
												'title' => __( "L'auteur", 'telabotanica' )
											]);
											the_telabotanica_component('text', [
												'text' => get_field('author')
											]);

										endif;

										if ( get_field('references') ) :

											the_telabotanica_component('title', [
												'title' => __( "Informations pratiques", 'telabotanica' )
											]);
											the_telabotanica_component('text', [
												'text' => get_field('references')
											]);

										endif;

										the_telabotanica_component('title', [
											'title' => __( "Comment se procurer l'ouvrage ?", 'telabotanica' )
										]);
										the_telabotanica_component('text', [
											'text' => get_field('how_to_buy')
										]);

									endif; // FIN EN KIOSQUE

									if ( get_field('description') ) :

										the_telabotanica_component('text', [
											'text' => get_field('description')
										]);

									endif;

									if ( !empty( get_the_content() ) ) :

										the_telabotanica_component('text', [
											'text' => apply_filters('the_content', get_the_content())
										]);

									endif;

									// Si la page utilise des composants
									if( have_rows('components') ) :

											// On boucle sur les composants
											while ( have_rows('components') ) : the_row();

												the_telabotanica_component(get_row_layout(), []);

											endwhile;

									endif;

									// EVENEMENT
									if ( post_is_in_descendant_category( 'evenements' ) ) :

										$info_items = [];

										$info_items[] = [
											'title' => 'Adresse',
											'text' => get_field('place')->value
										];

										$info_items[] = [
											'title' => 'Tarif',
											'text' => get_field('is_free') === true ? __( 'Gratuit', 'telabotanica') : get_field('prices')
										];

										the_telabotanica_component('info', [
											'items' => $info_items
										]);

										if ( get_field('contact') && !empty( get_field('contact')->name ) ) {
											the_telabotanica_component('contact', get_field('contact'));
										}

									endif; // FIN EVENEMENT
									?>
								</article>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			<?php endif; ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
