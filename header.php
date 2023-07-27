<?php
/**
 * Header
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php endif; ?>
  <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php
  // TODO: add skip links ?>
  <!-- <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'telabotanica' ); ?></a> -->

  <?php
  if ( !isset($GLOBALS['is_error']) ) the_telabotanica_module('header');
  ?>

  <div id="content" class="site-content">
