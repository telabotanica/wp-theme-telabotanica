<?php
/**
 * Template pour les pages de documentation du styleguide
 *
 * @package WordPress
 * @subpackage Tela_Botanica
 * @since TelaBotanica 0.0.1
 */

global $wp_query;

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<h1><a href="<?php echo site_url('styleguide') ?>">Styleguide</a></h1>

      <?php
      $current = false;
      if ($wp_query->get('styleguide_type') && $wp_query->get('styleguide_nom')):
        $type = $wp_query->get('styleguide_type');
        $nom = $wp_query->get('styleguide_nom');
        $current = $type . '/' . $nom;
        echo '<h2>' . $type . ' <code>' . $nom . '</code></h2>';
        $exemples = require($type . 's/' . $nom . '/exemples.php');
        foreach ($exemples as $exemple => $data) {
          echo '<h3>' . $exemple . '</h3>';
          echo '<div class="styleguide-element">' . get_telabotanica_styleguide_element($type, $nom, $data) . '</div>';
          echo '<pre class="styleguide-data">' . json_encode($data, JSON_PRETTY_PRINT) . '</pre>';
        }
      endif;
      ?>

      <aside>
        <h2>Modules</h2>
        <ul><?php
        array_walk($telabotanica_modules, function ($module) {
          global $current;
          echo '<li' . ($current === 'module/' . $module ? ' class="current"' : '') . '><a href="' . site_url('styleguide/module/' . $module) . '"><code>' . $module . '</code></a></li>';
        });
        ?></ul>
        <h2>Composants rédactionnels</h2>
        <ul><?php
        array_walk($telabotanica_composants, function ($composant) {
          global $current;
          echo '<li' . ($current === 'composant/' . $composant ? ' class="current"' : '') . '><a href="' . site_url('styleguide/composant/' . $composant) . '"><code>' . $composant . '</code></a></li>';
        });
        ?></ul>
      </aside>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
