<?php
/**
 * Page d'accueil
 */

get_header();

$category = get_category( get_query_var('cat') );
$category_actualites = get_category_by_slug( 'actualites' );
$category_emploi = get_category_by_slug( 'offres-emploi' );
$category_evenements = get_category_by_slug( 'evenements' );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php
      the_telabotanica_module('cover', [
        'title' => $category_actualites->name,
        'subtitle' => sprintf(
          __('Toute l\'<a href="%s">actualité</a>, les <a href="%s">offres d\'emploi</a> et les <a href="%s">évènements</a>', 'telabotanica'),
          get_category_link( $category_actualites ),
          get_category_link( $category_emploi ),
          get_category_link( $category_evenements )
        ),
        'image' => get_field( 'cover_image', get_queried_object() )
      ] ); ?>

      <div class="layout-left-col">
        <div class="layout-wrapper">
          <aside class="layout-column">
            <?php the_telabotanica_module('categories', [
              'modifiers' => 'layout-column-item'
            ] ); ?>
            <div class="layout-column-item background-white with-shadow with-padding">
              <?php the_telabotanica_module('button', [
                'href' => '#',
                'text' => __( 'Proposer une actualité', 'telabotanica' ),
                'modifiers' => 'block'
              ] ); ?>
            </div>
            <?php the_telabotanica_module('form-newsletter', [
              'modifiers' => 'layout-column-item background-white with-shadow with-padding'
            ] ); ?>
            <?php the_telabotanica_module('upcoming-events', [
              'modifiers' => 'layout-column-item background-white with-shadow with-padding'
            ] ); ?>
            <?php the_telabotanica_module('button-top'); ?>
          </aside>
          <div class="layout-content">
            <?php
            if ( !empty( $category ) ):
              $rss_button = sprintf(
                '<a href="%s" title="%s" rel="nofollow">%s</a>',
                get_category_feed_link( $category->cat_ID ),
                esc_attr( sprintf( __( 'Flux RSS %s', 'telabotanica' ), $category->name ) ),
                get_telabotanica_module('icon', ['icon' => 'rss', 'color' => 'orange'])
              );
            endif;
            the_telabotanica_module('breadcrumbs', ['button' => $rss_button]);
            the_telabotanica_module('list-articles');
            ?>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
