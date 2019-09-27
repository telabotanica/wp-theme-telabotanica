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
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-57885-1', 'auto');
      ga('send', 'pageview');

  </script>
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
