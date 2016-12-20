<?php

  /**
  	* Woocommerce theme support declaration
  */
  add_action( 'after_setup_theme', 'woocommerce_support' );

  function woocommerce_support() {
    add_theme_support( 'woocommerce' );
  }

    require_once('includes/admin/custom-post-types.php');
    require_once('includes/admin/woocommerce-single-product.php');
    require_once('includes/admin/admin-functions.php');
    require_once('includes/admin/woocommerce-functions.php');
    require_once('includes/admin/ajax-functions.php');
    require_once('includes/admin/theme-support.php');

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
      register_nav_menus( array(
        'megaMenu' => esc_html__( 'Mega Menu', 'kommerce'),
      ) );

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
        wp_enqueue_style('poppins-font','https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700', false);
        wp_enqueue_style( 'kommerce-style', get_stylesheet_uri() );
        wp_register_script('kommerce_initJS', get_template_directory_uri() . '/_build/js/min/init-min.js', array('jquery'),'1.0.0', true);
        wp_enqueue_script('kommerce_initJS');
        wp_register_script('kommerce_jquery', get_stylesheet_directory_uri() . '/_build/js/min/jquery-3.1.1.min.js', array(),'', false);
        wp_enqueue_script('kommerce_jquery');
    }
    add_action( 'wp_enqueue_scripts', 'kommerce_scripts' );


    function carousel_scripts() {
        // wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/_build/js/owl.carousel.js', array('jquery'), '20120206', true );
        wp_enqueue_script( 'effects', get_template_directory_uri() . '/_build/js/effects.js', array('jquery'), '20120206', true );
    }
  add_action( 'wp_enqueue_scripts', 'carousel_scripts' );

  add_image_size( 'carousel-pic', 480, 320, true );

  // Custom control for carousel category
  if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Category_Control extends WP_Customize_Control {
      public function render_content() {
        $dropdown = wp_dropdown_categories(
          array(
            'name'              => '_customize-dropdown-category-' . $this->id,
            'echo'              => 0,
            'show_option_none'  => __( '&mdash; Select &mdash;' ),
            'option_none_value' => '0',
            'selected'          => $this->value(),
          )
        );
        $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
        printf( '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>', $this->label, $dropdown );
      }
    }
  }

  // Register slider customizer section
  add_action( 'customize_register' , 'carousel_options' );

  function carousel_options( $wp_customize ) {
    $wp_customize->add_section(
      'carousel_section',
      array(
        'title'     => 'Carousel settings',
        'priority'  => 202,
        'capability'  => 'edit_theme_options',
      )
    );

    $wp_customize->add_setting(
        'carousel_setting',
         array(
        'default'   => '',
      )
    );

    $wp_customize->add_control(
        new WP_Customize_category_Control(
        $wp_customize,
        'carousel_category',
        array(
          'label'    => 'Category',
          'settings' => 'carousel_setting',
          'section'  => 'carousel_section'
        )
      )
    );

    $wp_customize->add_setting(
      'count_setting',
       array(
        'default'   => '6',
      )
    );

    $wp_customize->add_control(
      new WP_Customize_Control(
        $wp_customize,
        'carousel_count',
        array(
          'label'     => __( 'Number of posts', 'theme_name' ),
          'section'   => 'carousel_section',
          'settings'  => 'count_setting',
          'type'      => 'text',
        )
      )
    );
  }

 //Register sidebar
 add_action( 'widgets_init', 'kommerce_widgets_init' );
  function kommerce_widgets_init() {
    register_sidebar( array(
      'name' => __( 'Aside Sidebar', 'aside-sidebar' ),
      'id' => 'sidebar-1',
      'description' => __( 'A sidebar to have the product categories', 'theme-slug' ),
      'before_widget' => '<li id="%1$s" class="widget %2$s">',
    	'after_widget'  => '</li>',
    	'before_title'  => '<h2 class="widgettitle">',
    	'after_title'   => '</h2>',

    ) );
  }

function categoryDescriptions( $slug ){

    $args = array( 'taxonomy' => 'product_cat',
                    'slug'      => $slug
                );
    $terms = get_terms('product_cat', $args);

    $count = count($terms);
    echo $terms->description; ?>
    <div class="cat-description">

    <?php
    if ($count > 0) {
        foreach ($terms as $term) { ?>

            <p><?php echo $term->description; ?></p>
        <?php }

    } ?>
        </div>
    <?php
}
function woo_custom_taxonomy_in_body_class($classes){
  if( is_singular('product')) {
    $custom_terms = get_the_terms(0, 'product_cat');
    if ($custom_terms) {
      foreach ($custom_terms as $custom_term) {
        $classes[] = $custom_term->slug;
      }
    }
  }
  return $classes;
}

add_filter( 'body_class', 'woo_custom_taxonomy_in_body_class' );

add_action( 'wp_enqueue_scripts', 'wcqi_enqueue_polyfill' );
