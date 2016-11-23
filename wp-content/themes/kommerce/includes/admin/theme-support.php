<?php
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
        'height'      => 50,
        'width'       => 100,
        'flex-height' => false,
        'flex-width'  => false,
        'header-text' => array( 'kommerce', 'A responsive ecommerce site' ),
    ) );

    /* Added Header theme support for the customizer*/
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


    add_filter( 'jetpack_development_mode', '__return_true' );
