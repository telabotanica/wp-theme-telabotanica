<?php
if (!defined('ABSPATH')) {
  exit;
}

if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
  require get_template_directory() . '/inc/back-compat.php';
}

require get_template_directory() . '/vendor/autoload.php';
require get_template_directory() . '/inc/helpers.php';
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
endif;
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

function telabotanica_content_width() {
  $GLOBALS['content_width'] = apply_filters( 'telabotanica_content_width', 840 );
}
add_action( 'after_setup_theme', 'telabotanica_content_width', 0 );

function telabotanica_enqueue_frontend_assets() {
  $bundle_js = get_template_directory() . '/dist/bundle.js';
  if ( file_exists( $bundle_js ) ) {
    wp_enqueue_script(
      'telabotanica-frontend-script',
      get_template_directory_uri() . '/dist/bundle.js',
      [],
      null,
      true
    );
  }

  wp_enqueue_style(
    'telabotanica-frontend-style',
    get_stylesheet_directory_uri() . '/dist/bundle.css',
    [],
    filemtime(get_stylesheet_directory() . '/dist/bundle.css')
  );
}
add_action( 'wp_enqueue_scripts', 'telabotanica_enqueue_frontend_assets' );

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

function telabotanica_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
  if ( 'post-thumbnail' === $size ) {
    is_active_sidebar( 'sidebar-1' )
      ? $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px'
      : $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
  }
  return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'telabotanica_post_thumbnail_sizes_attr', 10 , 3 );

function telabotanica_admin_theme_style() {
  wp_enqueue_style(
    'telabotanica',
    get_template_directory_uri() . '/admin/style.css',
    [],
    filemtime(get_template_directory() . '/admin/style.css')
  );
}
add_action('admin_enqueue_scripts', 'telabotanica_admin_theme_style');

function telabotanica_add_upload_capability_to_contributor_role() {
  $contributor = get_role('contributor');
  $contributor->add_cap('upload_files');
}
add_action( 'after_switch_theme', 'telabotanica_add_upload_capability_to_contributor_role' );

function fix_password_reset_link($message, $key, $user_login, $user_data) {
  $message .= "\r\n".__( 'Le lien n’apparaît pas ? Copiez-collez l’adresse ci-dessous dans la barre d’adresse de votre navigateur : ', 'telabotanica' )."\r\n\r\n";
  $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
  return $message;
}
add_filter( 'retrieve_password_message', 'fix_password_reset_link', 10, 4);

function reset_password_message($hint){
  return __( '<span style="font-weight:900"><span style="color:#E16E38">Warning : </span> Change the password above or remember it well.</span><br><br>Hint: The password should be at least twelve characters long.</span>' );
}
add_filter('password_hint','reset_password_message');

function tiny_mce_remove_unused_formats($init) {
  $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Address=address;Pre=pre';
  return $init;
}
add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );

function tb_menu_aria($atts, $item, $args) {
  if (in_array('menu-item-has-children', $item->classes)) {
    $atts['aria-haspopup'] = 'true';
    $atts['aria-expanded'] = 'false';
  }
  return $atts;
}
add_filter('nav_menu_link_attributes', 'tb_menu_aria', 10, 3);
