<?php

/**
 * Dequeue default CSS files.
 *
 * Hooked to the wp_print_styles action, with a late priority (100),
 * so that it is after the stylesheets were enqueued.
 */
function telabotanica_theme_dequeue_styles() {
  // Remove the algolia-autocomplete.css.
  wp_dequeue_style( 'algolia-autocomplete' );
}
add_action( 'wp_print_styles', 'telabotanica_theme_dequeue_styles', 100 );
