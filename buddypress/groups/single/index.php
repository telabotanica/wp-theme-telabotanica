<?php
/**
 * Page d'accueil de l'Espace Projets, listant les projets
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php
      the_telabotanica_module('cover-project', []);
      ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
