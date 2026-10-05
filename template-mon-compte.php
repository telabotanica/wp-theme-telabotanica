<?php
/**
 * Page Mon compte (sans BuddyPress).
 *
 * Associez cette page au slug /mon-compte/ puis ajoutez le shortcode
 * [tb_mon_compte] dans son contenu. Le shortcode est affiché en
 * repli si le contenu est vide.
 */
/*
Template Name: mon-compte
*/

get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <div class="layout-wrapper">
      <div class="layout-content">
        <?php the_telabotanica_module( 'breadcrumbs' ); ?>
        <article class="tb-account-page">
          <div class="component component-title level-2">
            <h1><?php echo esc_html( get_the_title() ); ?></h1>
          </div>
          <?php
          while ( have_posts() ) :
            the_post();
            the_content();
          endwhile;

          // Repli si la page n'a pas de contenu / shortcode.
          if ( ! has_shortcode( get_post_field( 'post_content', get_the_ID() ), 'tb_mon_compte' ) ) {
            echo do_shortcode( '[tb_mon_compte]' );
          }
          ?>
        </article>
      </div>
    </div>
  </main>
</div>

<?php get_footer(); ?>
