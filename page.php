<?php
/**
 * Page
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php the_telabotanica_module('bandeau', array()); ?>

      <div class="layout-col-gauche">
        <div class="layout-wrapper">
          <aside class="layout-colonne">
            <p>TODO</p>
          </aside>
          <div class="layout-contenu">
            <article class="article">
              <?php
              // Si la page utilise des composants
              if( have_rows('composants') ):

                  // loop through the rows of data
                  while ( have_rows('composants') ) : the_row();

                    the_telabotanica_composant(get_row_layout(), array());

                  endwhile;

              else :

                  // no layouts found

              endif;

              wp_link_pages( array(
                  'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
                  'after'       => '</div>',
                  'link_before' => '<span>',
                  'link_after'  => '</span>',
                  'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
                  'separator'   => '<span class="screen-reader-text">, </span>',
              ) );
              ?>
            </article>
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
