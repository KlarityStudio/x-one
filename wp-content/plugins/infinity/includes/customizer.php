<?php
/**
 * Infinity Theme Customizer.
 *
 * @package Infinity
 */



function get_parts_array($id) {
	$parts = get_builder_elements($id);

	$infinity_options = views();
	$custom_fields_array = $infinity_options->getOption( 'custom-fields_333' );

	if( is_array($custom_fields_array) )
		foreach ($custom_fields_array as $field_name => $value) {
			$parts['custom-field-'.$value] = $value;
		}

	return $parts;

}


function infinity_options() {

	 $args = array(
	     'post_type' => 'ib_views',
	     'posts_per_page'        => '-1',
	 );

	 $the_query = new WP_Query( $args );

	 if ( $the_query->have_posts() ) :

	     while($the_query->have_posts()) : $the_query->the_post();

	         $id = $the_query->post->ID;

	         $query_mode = 1;'';//$options['query-mode'];

	         $title = get_the_title();
	         $view_name = strtolower(str_replace(' ', '-', get_the_title()));

					 /**
					 * Add the theme configuration
					 */
					 Infinity_Kirki::add_config( 'infinity_'.$id, array(
					 	'option_type' => 'option',
					 	'option_name' => 'infinity_options_view_'.$id,
					 	'capability'  => 'edit_theme_options',
					 ) );

					 // TODO: Add textdomain for translation to alkl labels
					 Infinity_Kirki::add_panel( 'panel_'.$view_name, array(
					     'priority'    => 10,
					     'title'       => __( get_the_title() . ' (View)', 'eezy' )
					 ) );

					 //generic sections
					 ///layout
					Infinity_Kirki::add_section( 'layout_'.$id, array(
						'title'      => esc_attr__( 'Choose a Layout', 'eezy' ),
						'priority'   => 1,
						'panel' => 'panel_'.$view_name,
						'capability' => 'edit_theme_options',
					) );
					 		//layout fields
							Infinity_Kirki::add_field( 'infinity_'.$id, array(
									'section'  => 'layout_'.$id,
									'label' => '',
									'settings' => 'view-layout-' . $id,
									'type' => 'select',//'radio-image',
									'choices' => get_layouts_list(),
									'default' => 'blog',
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'label' => esc_html__( 'Columns:', 'eezy' ),
									'settings' => 'postopts-columns-' . $id . '',
									'type' => 'slider',
									'description' => 'The number of columns to display for grid, masonry and carousel modes.',
									'choices'     => array(
										'min'  => '2',
										'max'  => '8',
										'step' => '1',
									),
									'section'  => 'layout_'.$id,
									'default' => '4'
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'label' => 'Spacing:',
									'settings' => 'postopts-post-spacing-' . $id,
									'description' => 'The amount spacing in pixels between each item.',
									'type' => 'slider',
									'default' => '20',
									'choices'     => array(
										'min'  => '0',
										'max'  => '100',
										'step' => '1',
									),
									'section'  => 'layout_'.$id,
							) );

							//Query content
							Infinity_Kirki::add_section( 'query_content_'.$id, array(
								'title'      => esc_attr__( 'Query Content', 'eezy' ),
								'priority'   => 1,
								'panel' => 'panel_'.$view_name,
								'capability' => 'edit_theme_options',
							) );
								//Query fields
								Infinity_Kirki::add_field( 'infinity_'.$id, array(
										'label' => esc_html__( 'Show Advanced Options?', 'eezy' ),
										'settings' => 'advanced-options_'.$id,
										'type' => 'switch',
										'section'  => 'query_content_'.$id,
								) );
								Infinity_Kirki::add_field( 'infinity_'.$id, array(
										'label' => esc_html__( 'Posts:', 'eezy' ),
										'settings' => 'postopts-post-count-' . $id . '',
										'description' => 'The total number of posts to show per view',
										'type' => 'slider',
										'choices'     => array(
											'min'  => '1',
											'max'  => '50',
											'step' => '1',
										),
										'section'  => 'query_content_'.$id
								) );
								Infinity_Kirki::add_field( 'infinity_'.$id, array(
										'section'  => 'query_content_'.$id,
										'settings' => 'postopts-post-type-' . $id . '',
										'type' => 'select',
										'label' => __('Content Types', 'eezy'),
										'description' => __('Select post types to fetch content for', 'eezy'),
										'choices' => get_post_types_list(),
										'multiple' => 1,
										'default' => array('post')
								) );
								Infinity_Kirki::add_field( 'infinity_'.$id, array(
									'section'  => 'query_content_'.$id,
									'label' => 'Categories',
									'settings' => 'postopts-post-categories-' . $id,
									'type' => 'select',
									'choices' => list_categories(),
									'multiple' => 2,
									'required'  => array(
										array(
											'settings'  => 'postopts-post-type-' . $id . '',
											'operator' => '==',
											'value'    => 'post',
										),
									),
								) );

								Infinity_Kirki::add_field( 'infinity_'.$id, array(
									'section'  => 'query_content_'.$id,
									'label' => 'Product Categories',
									'settings' => 'postopts-woo-categories-' . $id,
									'type' => 'select',
									'choices' => list_woo_categories(),
									'multiple' => 2,
									'required'  => array(
										array(
											'settings'  => 'postopts-post-type-' . $id . '',
											'operator' => '==',
											'value'    => 'product',
										),
									),
								) );

								//Carousel
							Infinity_Kirki::add_section( 'carousel_'.$id, array(
								'title'      => esc_attr__( 'Layout - Carousel', 'eezy' ),
								'priority'   => 1,
								'panel' => 'panel_'.$view_name,
								'capability' => 'edit_theme_options',
							) );

							Infinity_Kirki::add_field( 'infinity_'.$id, array(
									'section'  => 'carousel_'.$id,
									'settings' => 'carousel-js-'.$id,
	                'label' => 'Carousel JS',
	                'type' => 'code',
	                'default' => ''
	            ) );







	     endwhile;

	     endif;

	 wp_reset_postdata();

 }

 add_action('wp_loaded', 'infinity_options');
