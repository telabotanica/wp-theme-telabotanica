<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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

      <?php if ($wp_query->get('styleguide_type') && $wp_query->get('styleguide_nom')):
        $type = $wp_query->get('styleguide_type');
        $nom = $wp_query->get('styleguide_nom');
        echo '<h2>' . $type . ' <code>' . $nom . '</code></h2>';
        $exemples = require($type . 's/' . $nom . '/exemples.php');
        foreach ($exemples as $exemple => $data) {
          echo '<h3>' . $exemple . '</h3>';
          echo '<div class="styleguide-element">' . get_telabotanica_styleguide_element($type, $nom, $data) . '</div>';
          echo '<pre class="styleguide-data">' . json_encode($data, JSON_PRETTY_PRINT) . '</pre>';
        }
      else: ?>
      <h2>Modules</h2>
      <ul><?php
      array_walk($telabotanica_modules, function ($module) {
        echo '<li><a href="' . site_url('styleguide/module/' . $module) . '"><code>' . $module . '</code></a></li>';
      });
      ?></ul>
      <h2>Composants rédactionnels</h2>
      <ul><?php
      array_walk($telabotanica_composants, function ($composant) {
        echo '<li><a href="' . site_url('styleguide/composant/' . $composant) . '"><code>' . $composant . '</code></a></li>';
      });
      ?></ul>
      <?php
      endif;
      ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
