<?php
/**
 * TelaBotanica functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 */
if (!defined('ABSPATH')) {
  exit;
}
// Ce thème requiert WordPress 4.4 ou ultérieur
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
  require get_template_directory() . '/inc/back-compat.php';
}

// Chargement des dépendances installées avec Composer
require get_template_directory() . '/vendor/autoload.php';
require get_template_directory() . '/inc/utile.php';
require get_template_directory() . '/inc/excerpt.php';
require get_template_directory() . '/inc/custom-post-types.php';
require get_template_directory() . '/inc/custom-taxonomies.php';
require get_template_directory() . '/inc/wpml.php';
require get_template_directory() . '/inc/styleguide.php';
require get_template_directory() . '/inc/login.php';
require get_template_directory() . '/inc/remove-toolbar.php';
require get_template_directory() . '/inc/acf.php';
require get_template_directory() . '/inc/validate-post-title.php';
require get_template_directory() . '/inc/rest-api-posts-per-page.php';
require get_template_directory() . '/inc/rest-api-posts-category-hierarchy.php';


if ( ! function_exists( 'telabotanica_setup' ) ) :
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   *
   * Create your own telabotanica_setup() function to override in a child theme.
   */
  function telabotanica_setup() {

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );

    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 220, 160, ['center', 'center'] );
    add_image_size( 'medium_square', 250, 250, ['center', 'center'] );
    add_image_size( 'home-latest-post', 600, 365, ['center', 'center'] );
    add_image_size( 'home-post-thumbnail', 65, 50, ['center', 'center'] );
    add_image_size( 'cover-background', 1920, 500, ['center', 'center'] );

    register_nav_menus( [
      'principal'       => 'Menu principal',
      'secondary'       => 'Menu secondaire',
      'footer-bar'      => 'Pied de page - bandeau',
      'footer-columns'  => 'Pied de page - en colonnes',
    ] );

    add_theme_support( 'html5', [
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ] );

    add_editor_style( 'dist/editor-style.css' );
  }
endif; // telabotanica_setup

add_action( 'after_setup_theme', 'telabotanica_setup' );
/**
 * ✅ Chargement des traductions (fix WP 6.7)
 */
function telabotanica_load_textdomain() {
  load_theme_textdomain( 'telabotanica' );
}
add_action( 'init', 'telabotanica_load_textdomain' );

/**
 * ✅ Ajout du rôle (fix WP 6.7)
 */
function telabotanica_add_roles() {
  add_role( 'tb_president', __('PrésidentTB', 'telabotanica' ),
    [
      'read' => true,
      'create_posts' => true,
      'edit_posts' => true,
      'delete_posts' => true,
      'publish_posts' => true,
      'upload_files' => true
    ]
  );
}
add_action('init', 'telabotanica_add_roles');

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function telabotanica_content_width() {
  $GLOBALS['content_width'] = apply_filters( 'telabotanica_content_width', 840 );
}
add_action( 'after_setup_theme', 'telabotanica_content_width', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function telabotanica_scripts() {
  // Theme stylesheet.
  wp_enqueue_style( 'telabotanica-style', get_template_directory_uri() . '/dist/bundle.css' );

  // Theme script.
  wp_enqueue_script( 'telabotanica-script', get_template_directory_uri() . '/dist/bundle.js', [ 'jquery', 'wp-util' ], null, true );
}
add_action( 'wp_enqueue_scripts', 'telabotanica_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since TelaBotanica 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array $size Image size. Accepts an array of width and height
 *                    values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function telabotanica_content_image_sizes_attr( $sizes, $size ) {
  $width = $size[0];

  840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

  if ( 'page' === get_post_type() ) {
    840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
  } else {
    840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
    600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
  }

  return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'telabotanica_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since TelaBotanica 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function telabotanica_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
  if ( 'post-thumbnail' === $size ) {
    is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
    ! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
  }
  return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'telabotanica_post_thumbnail_sizes_attr', 10 , 3 );

/*
 * Ajout d'un style spécifique pour l'admin
 */
function telabotanica_admin_theme_style() {
  wp_enqueue_style('telabotanica', get_template_directory_uri() . '/admin/style.css');
}
add_action('admin_enqueue_scripts', 'telabotanica_admin_theme_style');

/**
 * Adds "upload_files" capability to "contributor" role after theme switch
 *
 * @since TelaBotanica 0.1
 */
function telabotanica_add_upload_capability_to_contributor_role() {
  $contributor = get_role('contributor');
  $contributor->add_cap('upload_files');
}
add_action( 'after_switch_theme', 'telabotanica_add_upload_capability_to_contributor_role' );

/*
 * Visibilité du lien récupération de mot de passe dans l'email texte
 * (utilisation de chevrons non supportée par plusieurs clients mails)
 */
function fix_password_reset_link($message, $key, $user_login, $user_data) {
  $message .= "\r\n".__( 'Le lien n’apparaît pas ? Copiez-collez l’adresse ci-dessous dans la barre d’adresse de votre navigateur : ', 'telabotanica' )."\r\n\r\n";
  $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
  return $message;
}
add_filter( 'retrieve_password_message', 'fix_password_reset_link', 10, 4);

/*
* Petit message aux utilisateurs au moment de saisir un nouveau mot de passe
*/
function reset_password_message($hint){
  return __( '<span style="font-weight:900"><span style="color:#E16E38">Warning : </span> Change the password above or remember it well.</span><br><br>Hint: The password should be at least twelve characters long.</span>' );
}
add_filter('password_hint','reset_password_message');

// Modify TinyMCE editor to remove H1.
// from https://www.jowaltham.com/modify-tinymce-editor/
function tiny_mce_remove_unused_formats($init) {
  $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Address=address;Pre=pre';
  return $init;
}
add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );
