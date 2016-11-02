<?php
/**
 * Page d'accueil
 */

get_header();

$category_actualites = get_category_by_slug( 'actualites' );
$category_emploi = get_category_by_slug( 'offres-emploi' );
$category_evenements = get_category_by_slug( 'evenements' );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php
      the_telabotanica_module('cover', array(
        'title' => $category_actualites->name,
        'subtitle' => sprintf(
          __('Toute l\'<a href="%s">actualité</a>, les <a href="%s">offres d\'emploi</a> et les <a href="%s">évènements</a>', 'telabotanica'),
          get_category_link( $category_actualites ),
          get_category_link( $category_emploi ),
          get_category_link( $category_evenements )
        ),
        'image' => get_field( 'cover_image', get_queried_object() )
      )); ?>

      <div class="layout-left-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
            <?php the_telabotanica_module('categories', array(
              'modifiers' => 'layout-column-item'
            )); ?>
            <div class="layout-column-item background-white with-shadow with-padding">
              <?php the_telabotanica_module('button', array(
                'href' => '#',
                'text' => __( 'Proposer une actualité', 'telabotanica' ),
                'modifiers' => 'block'
              )); ?>
            </div>
            <?php the_telabotanica_module('form-newsletter', array(
              'modifiers' => 'layout-column-item background-white with-shadow with-padding'
            )); ?>
            <?php the_telabotanica_module('upcoming-events', array(
              'modifiers' => 'layout-column-item background-white with-shadow with-padding'
            )); ?>
          </aside>
          <div class="layout-content">
            <?php the_telabotanica_module('breadcrumbs', array());

            if ( have_posts() ) : ?>
              <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                  <?php the_excerpt(); ?>
                </article>
              <?php endwhile;

              the_posts_pagination( array(
        				'prev_text'          => __( 'Page précédente', 'telabotanica' ),
        				'next_text'          => __( 'Page suivante', 'telabotanica' ),
        				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'telabotanica' ) . ' </span>',
        			) );
              ?>
            <?php else :
              echo '<p>' . __( 'Aucune actualité dans cette catégorie.', 'telabotanica' ) . '</p>';
            endif; ?>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
