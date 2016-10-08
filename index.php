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

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php the_telabotanica_module('bouton', array('href' => '#', 'text' => 'Bouton')); ?>
			<?php
			$monbouton = get_telabotanica_module('bouton', array('href' => '#', 'text' => 'Bouton'));
			echo $monbouton;
			?>

			<?php the_telabotanica_composant('boutons', array(
				'items' => array(
					array('href' => '#', 'text' => 'Bouton 1'),
					array('href' => '#', 'text' => 'Bouton 2')
				)
			)) ?>

    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php get_footer(); ?>
