<?php

/**
	* Woocommerce theme support declaration
*/
add_action( 'after_setup_theme', 'woocommerce_support' );

function woocommerce_support() {
  add_theme_support( 'woocommerce' );
}

if ( ! function_exists( 'kommerce_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kommerce_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on kommerce, use a find and replace
	 * to change 'kommerce' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'kommerce', get_template_directory() . '/languages' );

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
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'kommerce' ),
	) );

	register_nav_menus( array(
		'secondary' => esc_html__( 'Footer', 'kommerce' ),
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

  add_theme_support( 'custom-logo', array(
  	'height'      => 100,
  	'width'       => 400,
  	'flex-height' => true,
  	'flex-width'  => true,
  	'header-text' => array( 'kommerce', 'A responsive ecommerce site' ),
  ) );

/* Added Header theme support for the customizer - Uncomment if needed */

add_theme_support( 'custom-background' );

function custom_background_size( $wp_customize ) {

	// Add the "panel" (Section).
	// If this section already exists, comment the next 3 lines out.
	$wp_customize->add_section( 'theme_settings', array(
		'title' => __( 'Theme Settings' ),
	) );

	// If they haven't set the background image, don't show these controls.
	if ( ! get_theme_mod( 'background_image' ) ) {
		return;
	}

	// Add your setting.
	$wp_customize->add_setting( 'default-size', array(
		'default' => 'inherit',
	) );

	// Add your control box.
	$wp_customize->add_control( 'default-size', array(
		'label'      => __( 'Background Image Size' ),
		'section'    => 'theme_settings',
		'settings'   => 'default-size',
		'priority'   => 200,
		'type' => 'radio',
		'choices' => array(
			'cover' => __( 'Cover' ),
			'contain' => __( 'Contain' ),
			'inherit' => __( 'Inherit' ),
		)
	) );
}

add_action( 'customize_register', 'custom_background_size' );

function custom_background_size_css() {
	$background_size = get_theme_mod( 'default-size', 'inherit' );
	echo '<style> body.custom-background { background-size: '.$background_size.'; } </style>';
}

add_action( 'wp_head', 'custom_background_size_css', 999 );


/* Customizer theme header fallback for older wordpress versions */
  global $wp_version;

  if ( version_compare( $wp_version, '3.4', '>=' ) ) :
  	add_theme_support( 'custom-header' );
  else :
  	add_custom_image_header( $wp_head_callback, $admin_head_callback );
  endif;

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'kommerce_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'kommerce_setup' );

/**
 * Enqueue scripts and styles.
 */
function kommerce_scripts() {
	wp_enqueue_style( 'kommerce-style', get_stylesheet_uri() );

	wp_register_script('kommerce_initJS', get_template_directory_uri() . '/_build/js/min/init.min.js', array('jquery'),'1.0.0', true);
	wp_enqueue_script('kommerce_initJS');
}
add_action( 'wp_enqueue_scripts', 'kommerce_scripts' );
