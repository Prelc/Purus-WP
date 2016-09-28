<?php
/**
 * purus functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package purus
 */

if ( ! function_exists( 'purus_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function purus_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on purus, use a find and replace
	 * to change 'purus' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'purus', get_template_directory() . '/languages' );

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
	 * Add support for Theme Logo -> https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 70,
		'width'       => 172,
		'flex-width' => true,
	) );
	add_theme_support( 'custom-logo' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'main-menu' => esc_html__( 'Main Menu', 'purus' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'link',
		'image',
		'video',
		'audio',
		'quote',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'purus_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'purus_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function purus_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'purus_content_width', 650 );
}
add_action( 'after_setup_theme', 'purus_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function purus_scripts() {
	wp_enqueue_style( 'purus-style', get_stylesheet_uri(), 'dashicons' );
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'purus-style', get_stylesheet_uri() );

	// array for main.js dependencies
	$main_deps = array( 'jquery' );

	// Main JS fail
	wp_enqueue_script( 'purus-main', get_template_directory_uri() . '/assets/js/main-min.js', $main_deps );

	// Pass data to the main script
	wp_localize_script( 'purus-main', 'PurusVars', array(
		'pathToTheme'  => get_template_directory_uri(),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'purus_scripts' );


/**
 * Google Fonts
 */
function purus_google_fonts() {
	$query_args = array(
		'family' => 'Open+Sans:400,700%7cLora:400,700',
		'subset' => 'latin,latin-ext',
	);
	wp_enqueue_style( 'purus_google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
	}
add_action('wp_enqueue_scripts', 'purus_google_fonts');


/**
 * Require the files in the folder /inc/
 */
$purus_files_to_require = array(
	'colors',
	'theme-customizer',
);

// Conditionally require the includes files, based if they exist in the child theme or not
foreach ( $purus_files_to_require as $file ) {
	require_once trailingslashit( get_template_directory() ) . 'inc/' . $file . '.php';
}


/**
 * Added container around videos
 */
function purus_custom_oembed_filter( $html ) {
	if (
		false !== strstr( $html, 'youtube.com' ) ||
		false !== strstr( $html, 'wordpress.tv' ) ||
		false !== strstr( $html, 'wordpress.com' ) ||
		false !== strstr( $html, 'vimeo.com' )
	) {
		$out = '<div class="embed-responsive  embed-responsive-16by9">' . $html . '</div>';
	} else {
		$out = $html;
	}
	return $out;
}
add_filter( 'embed_oembed_html', 'purus_custom_oembed_filter', 10, 4 ) ;


/**
 * Added container around SoundCloud
 */
function purus_custom_oembed_filter_soundcloud( $html_soundcloud ) {
	if (
		false !== strstr( $html_soundcloud, 'soundcloud.com' )
	) {
		$out = '<div class="embed-responsive  embed-responsive-13by8">' . $html_soundcloud . '</div>';
	} else {
		$out = $html_soundcloud;
	}
	return $out;
}
add_filter( 'embed_oembed_html', 'purus_custom_oembed_filter_soundcloud', 10, 4 ) ;


/**
 * Replaces the excerpt "more" text
 */
function purus_new_excerpt_more($more) {
	return ' &hellip;';
}
add_filter('excerpt_more', 'purus_new_excerpt_more');
