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

// Ce thème requiert WordPress 4.4 ou ultérieur
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

// Chargement des dépendances installées avec Composer
require get_template_directory() . '/vendor/autoload.php';

// Création d'une instance de Pug pour le rendu des templates *.pug
// TODO: configurer le cache, voir https://github.com/pug-php/pug
$pug = new \Pug\Pug([
	'expressionLanguage' => 'js'
]);

// Fonctions utiles
require get_template_directory() . '/inc/utile.php';

// Filtres pour l'extrait
require get_template_directory() . '/inc/excerpt.php';

// Pages d'options (avec ACF)
require get_template_directory() . '/inc/options.php';

/**
 * Chargement des types de contenus sur mesure (Custom Post Types)
 * cf. https://codex.wordpress.org/Post_Types#Custom_Post_Types
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Chargement des taxonomies sur mesure (Custom Taxonomies)
 * cf. https://codex.wordpress.org/Taxonomies#Custom_Taxonomies
 */
require get_template_directory() . '/inc/custom-taxonomies.php';

// Options WPML
require get_template_directory() . '/inc/wpml.php';

// Chargement du styleguide
require get_template_directory() . '/inc/styleguide.php';

// Amélioration du flux RSS
require get_template_directory() . '/inc/rss.php';

// Personnalisation de la page de login
require get_template_directory() . '/inc/login.php';

// Synchronisation et améliorations des profils wordpress et buddypress
require get_template_directory() . '/inc/profile.php';

// Customisation du plugin Algolia
if ( class_exists( 'Algolia_Plugin' ) ) {
	require get_template_directory() . '/inc/algolia.php';
}


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
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'telabotanica' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 220, 160, array( 'center', 'center') );
	add_image_size( 'home-latest-post', 600, 365, array( 'center', 'center') );
	add_image_size( 'home-post-thumbnail', 65, 50, array( 'center', 'center') );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( [
		'principal'       => __( 'Menu principal', 'telabotanica' ),
		'secondary'       => __( 'Menu secondaire', 'telabotanica' ),
		'footer-bar'      => __( 'Pied de page - bandeau', 'telabotanica' ),
		'footer-columns'  => __( 'Pied de page - en colonnes', 'telabotanica' ),
	] );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	] );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( 'dist/editor-style.css' );
}
endif; // telabotanica_setup
add_action( 'after_setup_theme', 'telabotanica_setup' );


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
