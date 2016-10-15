<?php
/**
 * Page d'accueil
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

      <?php the_telabotanica_module('bandeau', array(
        'titre' => 'Actualités',
        'soustitre' => 'Toute l\'actualité, les offres d\'emploi et les évènements',
      )); ?>

      <div class="layout-col-gauche">
        <div class="layout-wrapper">
          <aside class="layout-colonne">
            <?php the_telabotanica_module('categories', array(
            )); ?>
          </aside>
          <div class="layout-contenu">
            Contenu
          </div>
        </div>
      </div>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
