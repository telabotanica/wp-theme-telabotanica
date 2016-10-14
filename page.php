<?php
/**
 * Page
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php the_telabotanica_module('bandeau', array()); ?>

      <article class="article">
        <?php
        // check if the flexible content field has rows of data
        if( have_rows('composants') ):

            // loop through the rows of data
            while ( have_rows('composants') ) : the_row();

                switch ( get_row_layout() ) {
                    case 'intertitre':
                        $niveau = get_sub_field('niveau');
                        echo '<h' . $niveau . ' id="' . get_sub_field('ancre') . '">' . get_sub_field('titre') . '</h' . $niveau . '>';
                        break;

                    case 'texte':
                        the_sub_field('texte');

                    case 'liens':
                        echo '<h3>' . get_sub_field('titre') . '</h3>';

                        if( have_rows('lien') ):

                            echo '<ul>';

                            while ( have_rows('lien') ) : the_row();

                                $lien_interne = get_sub_field('lien_interne');
                                if ($lien_interne) {
                                    $href = $lien_interne;
                                }
                                else {
                                    $href = get_sub_field('url');
                                }

                                echo '<li><a href="' . $href . '">' . get_sub_field('intitule') . '</a></li>';

                            endwhile;

                            echo '</ul>';

                        endif;
                        break;

                    case 'outils':
                        if( have_rows('outils') ):

                            while ( have_rows('outils') ) : the_row();
                                echo '<h3>' . get_sub_field('titre') . '</h3>';
                                echo '<p>' . get_sub_field('description') . '</p>';
                                echo '<a href="' . get_sub_field('lien') . '">' . get_sub_field('intitule_du_lien') . ' &rsaquo;</a>';
                                endwhile;

                        endif;
                        break;

                    case 'bouton':
                        echo '<p><a href="' . get_sub_field('lien_interne') . '">' . get_sub_field('intitule') . '</a></p>';
                        break;
                }

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

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
