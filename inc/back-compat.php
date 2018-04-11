<?php
/**
 * TelaBotanica back compat functionality (copied from Twenty Sixteen)
 *
 * Prevents TelaBotanica from running on WordPress versions prior to 4.4,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.4.
 *
 * @since TelaBotanica 0.1
 */

/**
 * Prevent switching to TelaBotanica on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since TelaBotanica 0.1
 */
function telabotanica_switch_theme()
{
    switch_theme(WP_DEFAULT_THEME, WP_DEFAULT_THEME);

    unset($_GET['activated']);

    add_action('admin_notices', 'telabotanica_upgrade_notice');
}
add_action('after_switch_theme', 'telabotanica_switch_theme');

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * TelaBotanica on WordPress versions prior to 4.4.
 *
 * @since TelaBotanica 0.1
 *
 * @global string $wp_version WordPress version.
 */
function telabotanica_upgrade_notice()
{
    $message = sprintf(__('TelaBotanica requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'telabotanica'), $GLOBALS['wp_version']);
    printf('<div class="error"><p>%s</p></div>', $message);
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.4.
 *
 * @since TelaBotanica 0.1
 *
 * @global string $wp_version WordPress version.
 */
function telabotanica_customize()
{
    wp_die(sprintf(__('TelaBotanica requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'telabotanica'), $GLOBALS['wp_version']), '', [
    'back_link' => true,
  ]);
}
add_action('load-customize.php', 'telabotanica_customize');

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.4.
 *
 * @since TelaBotanica 0.1
 *
 * @global string $wp_version WordPress version.
 */
function telabotanica_preview()
{
    if (isset($_GET['preview'])) {
        wp_die(sprintf(__('TelaBotanica requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'telabotanica'), $GLOBALS['wp_version']));
    }
}
add_action('template_redirect', 'telabotanica_preview');
