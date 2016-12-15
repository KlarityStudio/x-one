<?php
/**
 * Infinity Theme Customizer.
 *
 * @package Infinity
 */

/**
* Add the theme configuration
*/
Infinity_Kirki::add_config( 'infinity', array(
	'option_type' => 'option',
	'capability'  => 'edit_theme_options',
) );

function get_parts_array($id) {
	$parts = get_builder_elements($id);

	$infinity_options = views();
	$custom_fields_array = $infinity_options->getOption( 'custom-fields_'.$id );

	if( is_array($custom_fields_array) )
		foreach ($custom_fields_array as $field_name => $value) {
			$parts['custom-field-'.$value] = $value;
		}

	return $parts;

}


function infinity_options() {

	 $args = array(
	     'post_type' => 'view',
	     'posts_per_page'        => '-1',
	 );

	 $the_query = new WP_Query( $args );

	 if ( $the_query->have_posts() ) :

	     while($the_query->have_posts()) : $the_query->the_post();

	         $id = $the_query->post->ID;

	         $query_mode = '';//$options['query-mode'];

	         $title = get_the_title();
	         $view_name = strtolower(str_replace(' ', '-', get_the_title()));

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
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'layout_'.$id,
									'label' => 'Select a style',
									'description' => 'Set a preset style that is applied to each item in the view.',
									'settings' => 'style-name-' . $id,
									'type' => 'select',
									'choices' => get_styles_list(),
									'default' => 'boxed'
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'layout_'.$id,
									'label' => '',
									'settings' => 'view-layout-' . $id,
									'type' => 'select',//'radio-image',
									'choices' => get_layouts_list(),
									'default' => 'blog',
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'layout_'.$id,
									'type'        => 'sortable',
									'settings'    => 'builder_parts' . $id,
									'label'       => __( 'This is the label', 'eezy' ),
									'default' => array('title', 'image', 'excerpt', 'date', 'readmore'),
									'choices'     => get_parts_array($id),
									'priority'    => 10,
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

							//Pagination and infinite scroll
							//Section
							Infinity_Kirki::add_section( 'pagination_'.$id, array(
								'title'      => esc_attr__( 'Pagination', 'eezy' ),
								'priority'   => 1,
								'panel' => 'panel_'.$view_name,
								'capability' => 'edit_theme_options',
							) );

							//Fields
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'pagination_'.$id,
									'label' => 'Pagination:',
									'settings' => 'pagination-show-' . $id,
									'description' => 'Set whether to show post pagination or not.',
									'type' => 'checkbox',
									'default' => false
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'pagination_'.$id,
									'label' => 'Infinite:',
									'settings' => 'pagination-infinite-' . $id,
									'tooltip' => 'To set the initial number of posts to show. Edit the post count in query settings. Post count of 5 will show 5 posts before infinite scroll will load more',
									'description' => 'Infinite pagination will automatically fetch and load posts from other pages without the user needing to navigate to another page.',
									'type' => 'checkbox',
									'default' => false
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'pagination_'.$id,
									'label' => 'Effect:',
									'settings' => 'pagination-infinite-effect-' . $id,
									'type' => 'select',
									'description' => 'Only applies to masonry layouts. Sets the effect for new articles added to the page.',
									'choices' => array(
											'fade' => 'Fade In',
											'flyin' => 'Fly In'
									),
									'default' => 'fade'
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'pagination_'.$id,
									'label' => 'Range:',
									'settings' => 'pagination-range-' . $id,
									'description' => 'The number of page links to show before and after the current page.',
									'type' => 'text',
									'default' => '3'
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'pagination_'.$id,
									'label' => 'Align:',
									'settings' => 'pagination-alignment-' . $id,
									'type' => 'select',
									'description' => 'Sets where to align the pagination if not using infinite.',
									'choices' => array(
											'left' => 'Left',
											'center' => 'Center',
											'right' => 'Right'
									),
									'default' => 'center'
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'pagination_'.$id,
									'label' => 'Pages:',
									'settings' => 'pagination-pages-text-' . $id,
									'type' => 'text',
									'description' => 'Text that displays at the beginning of the pagination.',
									'default' => 'Pages'
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'pagination_'.$id,
									'label' => 'First:',
									'settings' => 'pagination-first-page-text-' . $id,
									'type' => 'text',
									'description' => 'Text for button that goes to first page.',
									'default' => '&laquo;'
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'pagination_'.$id,
									'label' => 'Previous',
									'settings' => 'pagination-prev-page-text-' . $id,
									'type' => 'text',
									'description' => 'Text for button that goes to the previous page.',
									'default' => '&lsaquo;'
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'pagination_'.$id,
									'label' => 'Next',
									'settings' => 'pagination-next-page-text-' . $id,
									'description' => 'Text for button that goes to next page.',
									'type' => 'text',
									'default' => '&rsaquo;'
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'pagination_'.$id,
									'label' => 'Last:',
									'settings' => 'pagination-last-page-text-' . $id,
									'description' => 'Text for button that goes to last page.',
									'type' => 'text',
									'default' => '&raquo;'
							) );

					//Query content
					Infinity_Kirki::add_section( 'query_content_'.$id, array(
						'title'      => esc_attr__( 'Query Content', 'eezy' ),
						'priority'   => 1,
						'panel' => 'panel_'.$view_name,
						'capability' => 'edit_theme_options',
					) );
						//Query fields
						Infinity_Kirki::add_field( 'infinity', array(
								'label' => esc_html__( 'Show Advanced Options?', 'eezy' ),
								'settings' => 'advanced-options_'.$id,
								'type' => 'switch',
								'section'  => 'query_content_'.$id,
						) );
						Infinity_Kirki::add_field( 'infinity', array(
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
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'query_content_'.$id,
								'settings' => 'postopts-post-type-' . $id . '',
								'type' => 'select',
								'label' => __('Content Types', 'eezy'),
								'description' => __('Select post types to fetch content for', 'eezy'),
								'choices' => get_post_types_list(),
								'multiple' => 1,
								'default' => array('post')
						) );
						Infinity_Kirki::add_field( 'infinity', array(
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

						Infinity_Kirki::add_field( 'infinity', array(
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

						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'custom',
							'settings'    => 'order_heading_' . $id,
							'section'  => 'query_content_'.$id,
							'default'     => '<h1>Order Content</h1>',
							'priority'    => 10,
						) );

						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'query_content_'.$id,
								'label' => 'Order by:',
								'settings' => 'postopts-order-by-' . $id . '',
								'description' => 'What to order the posts by.',
								'tooltip' => 'Set to <b>Meta value</b> or Meta value (Numeric) to order by custom meta values.',
								'type' => 'select',
								'default' => 'date',
								'choices' => array(
										'date' => 'Date Published',
										'ID' => 'ID',
										'author' => 'Author',
										'title' => 'Title',
										'modified' => 'Date Modified',
										'parent' => 'Parent ID',
										'rand' => 'Random order',
										'likes' => 'Order by post likes',
										'comment_count' => 'Comment Count',
										'menu_order' => 'Page order',
										'meta_value' => 'Meta value',
										'meta_value_num' => 'Meta value (Numeric)'
								)
						) );

						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'query_content_'.$id,
								'label' => 'Order by key:',
								'settings' => 'postopts-order-meta-key-' . $id . '',
								'tooltip' => 'Set a meta key to order content by. The key will be the meta key set when adding a custom meta element.',
								'type' => 'text',
								'default' => '',
								'required'  => array(
						      array(
						        'settings'  => 'advanced-options_'.$id,
						        'operator' => '==',
						        'value'    => true,
						      ),
						    ),
						) );

						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'query_content_'.$id,
								'label' => 'Order:',
								'settings' => 'postopts-order-' . $id . '',
								'type' => 'select',
								'default' => 'description',
								'choices' => array(
										'ASC' => 'ASC',
										'DESC' => 'DESC'
								)
						) );

						Infinity_Kirki::add_field( 'infinity', array(
								'label' => esc_html__( 'Offset:', 'eezy' ),
								'settings' => 'postopts-post-offset-' . $id . '',
								'tooltip' => 'Offset results by x number of posts',
								'type' => 'text',
								'section'  => 'query_content_'.$id,
								'default' => null
						) );

						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'custom',
							'settings'    => 'taxonomy_heading_' . $id,
							'section'  => 'query_content_'.$id,
							'default'     => '<h1>By Taxonomy</h1>',
							'priority'    => 10,
						) );

						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'query_content_'.$id,
								'type' => 'select',
								'settings' => 'post-taxonomies-relation_'.$id,
								'label' => __('Select Relation', 'eezy'),
								'tooltip' => 'Select a relation first then use the taxonomy query builder below to write powerful queries to fetch any content by any custom taxonomy. eg: All vehicles with the color taxonomy of red',
								'description' => __('Sets the logical relationship between each taxonomy when more than one.', 'eezy'),
								'choices' => array(
										'none' => 'No Taxonomy Filter (Disabled)',
										'AND' => 'Match ALL taxonomy queries',
										'OR' => 'Match ANY taxonomy queries',
								),
								'default' => 'none'
						) );

						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'repeater',
							'label'       => esc_attr__( 'Taxonomy Query Builder', 'eezy' ),
							'section'  => 'query_content_'.$id,
							'settings'    => 'taxonomy-group_' .$id,
							'required'  => array(
								array(
									'settings'  => 'post-taxonomies-relation_'.$id,
									'operator' => '==',
									'value'    => 'AND',
								)
							),
							'default'     => array(
								array(
									'post-taxonomies-taxonomy' => 'categories',
									'post-taxonomies-exclude'  => 'agree',
								)
							),
							'fields' => array(
									'post-taxonomies-taxonomy' => array(
											'label' => 'Select Taxonomy',
											'type' => 'select',
											'choices' => get_taxonomies_list()
									),
									'post-taxonomies-terms' => array(
											'type'=> 'text',
											'label' => 'Terms',
											'description' => 'Use only term slug or term ID\'s. Can be separated by comma eg: term1, term2 OR 1,4,9. Do not mix terms and ID\'s '
									),
									'post-taxonomies-exclude' => array(
											'type'=> 'checkbox',
											'label' => 'Exclude',
											'description'=> 'Excludes terms from results',
											'choices' => array(
													'agree' => __('Exclude terms', 'eezy')
											),
									),
									'post-taxonomies-include-children' => array(
											'type'=> 'checkbox',
											'label' => 'Include',
											'description'=> 'For hierarchical taxonomies',
											'choices' => array(
													'agree' => __('Include children', 'eezy')
											),
									),
							)
						) );


						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'custom',
							'settings'    => 'content_byid_heading_' . $id,
							'section'  => 'query_content_'.$id,
							'default'     => '<h1>By post ID\'s</h1>',
							'priority'    => 10,
						) );

						Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'query_content_'.$id,
								'type' => 'text',
								'settings' => 'post-individual-posts_' .$id,
								'label' => __('Content by ID\'s', 'eezy'),
								'tooltip' => __('Enter the ID\'s of specific posts to show', 'eezy')
						) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'query_content_'.$id,
								'type'=> 'checkbox',
								'settings' => 'post-exclude-individual-posts_' .$id,
								'label' => 'Excludes posts with above ID\'s',
								'choices' => array(
										'yes' => __('Exclude id\'s', 'eezy')
								),
						) );
						Infinity_Kirki::add_field( 'infinity', array(
							  'section'  => 'query_content_'.$id,
								'settings' => 'post-parent_' .$id,
								'type' => 'text',
								'label' => __('Posts of parent', 'eezy'),
								'tooltip' => __('Enter a page/post id to return only child pages of hierarchial structures.', 'eezy')
						) );
						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'custom',
							'settings'    => 'post_status_heading_' . $id,
							'section'  => 'query_content_'.$id,
							'default'     => '<h1>By Status</h1>',
							'priority'    => 10,
						) );
						Infinity_Kirki::add_field( 'infinity', array(
							  'section'  => 'query_content_'.$id,
								'settings' => 'post-status_'.$id,
								'type' => 'select',
                'title' => __('Status', 'eezy'),
                'choices' => get_statuses(),
                'multiple' => 4,
                'default' => array('publish')
						) );

						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'custom',
							'settings'    => 'post_date_heading_' . $id,
							'section'  => 'query_content_'.$id,
							'default'     => '<h1>By Date</h1>',
							'priority'    => 10,
						) );

						Infinity_Kirki::add_field( 'infinity', array(
							  'section'  => 'query_content_'.$id,
								'settings' => 'date-filter-'.$id,
								'type' => 'select',
								'label' => __( 'Date Filter', 'eezy' ),
								'choices' => array(
										'no-date-filter' => __( 'No Date Filter', 'eezy' ),
										'date-range' => __( 'Date Range', 'eezy' ),
										'days-range' => __( 'Days Range', 'eezy' )
								),
								'default' => 'no-date-filter',

						) );
						Infinity_Kirki::add_field( 'infinity', array(
							  'section'  => 'query_content_'.$id,
								'settings' => 'date-from-'.$id,
								'type' => 'date',
								'label' => __( 'From', 'eezy' ),
								//TODO: add conditionals
								'required'  => array(
						      array(
						        'settings'  => 'date-filter-'.$id,
						        'operator' => '==',
						        'value'    => 'date-range',
						      ),
						    ),
						) );
						Infinity_Kirki::add_field( 'infinity', array(
							  'section'  => 'query_content_'.$id,
								'settings' => 'date-to-'.$id,
								'type' => 'date',
								'label' => __( 'To', 'eezy' ),
								'required'  => array(
						      array(
						        'settings'  => 'date-filter-'.$id,
						        'operator' => '==',
						        'value'    => 'date-range',
						      ),
						    ),
						) );

						Infinity_Kirki::add_field( 'infinity', array(
							  'section'  => 'query_content_'.$id,
								'settings' => 'min-days-'.$id,
								'type' => 'number',
								'label' => __( 'From Max Days', 'eezy' ),
								'description' => 'eg: 7 days to show latest this week or 365 for a year',
								'required'  => array(
						      array(
						        'settings'  => 'date-filter-'.$id,
						        'operator' => '==',
						        'value'    => 'days-range',
						      ),
						    ),
						) );
						Infinity_Kirki::add_field( 'infinity', array(
							  'section'  => 'query_content_'.$id,
								'settings' => 'max-days-'.$id,
								'type' => 'number',
								'label' => __( 'To Min Days', 'eezy' ),
								'description' => 'eg: 0 for today or 1 for yesterday only',
								'required'  => array(
						      array(
						        'settings'  => 'date-filter-'.$id,
						        'operator' => '==',
						        'value'    => 'days-range',
						      ),
						    ),
						) );

						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'custom',
							'settings'    => 'post_search_heading_' . $id,
							'section'  => 'query_content_'.$id,
							'default'     => '<h1>By Search Terms</h1>',
							'priority'    => 10,
						) );

						Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'query_content_'.$id,
							'settings' => 'post-search-terms_'.$id,
							'type' => 'text',
							'label' => __('Search terms', 'eezy'),
							'description' => __('Display items that match these search terms', 'eezy')
						) );
						Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'query_content_'.$id,
							'settings' => 'post-search-exact_'.$id,
							'description' => 'Match posts that contain these words',
							'label' => __('Search exact term matches', 'eezy'),
							'type'=> 'switch',
							'choices' => array(
							    'yes'  => esc_attr__( 'Enable', 'eezy' ),
							    'no' => esc_attr__( 'Disable', 'eezy' )
							)
						) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'query_content_'.$id,
								'settings' => 'post-search-sentence_'.$id,
								'description' => 'Match posts that contain this phrase',
								'label' => __('Search as a sentence', 'eezy'),
								'type'=> 'switch',
								'choices' => array(
								    'yes'  => esc_attr__( 'Enable', 'eezy' ),
								    'no' => esc_attr__( 'Disable', 'eezy' )
								)
						) );


						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'custom',
							'settings'    => 'post_permission_heading_' . $id,
							'section'  => 'query_content_'.$id,
							'default'     => '<h1>By Permission</h1>'
						) );
						Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'query_content_'.$id,
							'settings' => 'post-permission_'.$id,
							'type' => 'select',
							'label' => __('Permission', 'eezy'),
							'choices' => array(
									'readable' => 'Posts are readable',
									'editable' => 'Posts are editable'
							)
						) );

						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'custom',
							'settings'    => 'post_custom_fields_heading_' . $id,
							'section'  => 'query_content_'.$id,
							'default'     => '<h1>By Custom Fields</h1>'
						) );



						//custom fields filter
						Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'query_content_'.$id,
							'settings'    => 'post-custom-fields-relation_' . $id,
							'type' => 'select',
							'label' => __('Select Relation', 'eezy'),
							'tooltip' => __('The logical relationship between each custom field when more than one.', 'eezy'),
							'choices' => array(
									'none' => 'Do not filter by custom fields',
									'AND' => 'Match ALL custom field queries',
									'OR' => 'Match ANY custom field queries',
							),
							'default' => 'none'
						) );


							Infinity_Kirki::add_field( 'infinity', array(
								'type'        => 'repeater',
								'label'       => esc_attr__( 'Custom Fields Query Builder', 'eezy' ),
								'section'  => 'query_content_'.$id,
								'settings'    => 'custom-fields-group_' .$id,
								'fields' => array(
									'post-custom-fields-compare' => array(
											'type' => 'select',
											'label' => __('Compare Operator', 'eezy'),
											'description' => __('Compare key and value using', 'eezy'),
											'choices' => array(
													'IN' => 'Equal to',
													'NOT IN' => 'Not Equal to',
													'LIKE' => 'Contains',
													'NOT LIKE' => 'Does not contain',
													'BETWEEN' => 'Between',
													'NOT BETWEEN' => 'Not Between',
													'<=' => 'Less than or equal to',
													'<' => 'Less than',
													'>=' => 'Greater than or equal to',
													'>' => 'Greater than',

											),
											'default' => 'IN'
									),
									'post-custom-fields-key' => array(
											'type'=> 'text',
											'label' => 'Key',
											'description' => 'The meta key to search for eg: "_post_like_count" for posts with likes'
									),
									'post-custom-fields-values' => array(
											'type'=> 'text',
											'label' => 'Values',
											'description' => 'Separate values with a ","',
									),
									'post-custom-fields-type' => array(
											'type' => 'select',
											'label' => __('Field Type', 'eezy'),
											'description' => __('Custom field type', 'eezy'),
											'choices' => array(
													'CHAR' => 'CHAR',
													'NUMERIC' => 'NUMERIC',
													'BINARY' => 'BINARY',
													'DATE' => 'DATE',
													'DATETIME' => 'DATETIME',
													'DECIMAL' => 'DECIMAL',
													'SIGNED' => 'SIGNED',
													'TIME' => 'TIME',
													'UNSIGNED' => 'UNSIGNED'
											),
											'default' => 'CHAR'
									),
								)
							) );



						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'custom',
							'settings'    => 'post_sticky_posts_heading_' . $id,
							'section'  => 'query_content_'.$id,
							'description' => 'Control how sticky content is added to the query',
							'default'     => '<h1>Sticky Posts</h1>'
						) );

						infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'query_content_'.$id,
							'settings' => 'post-sticky-posts_'.$id,
							'type' => 'radio',
							'label' => __('Sticky Posts', 'eezy'),
							'description' => __('Set where to display sticky posts', 'eezy'),
							'choices' => array(
									'hide' => __('Hide all sticky posts', 'eezy'),
									'only' => __('Show only posts that are sticky', 'eezy'),
									'ignore' => __('Show sticky posts in normal post order', 'eezy'),
									'top' => __('Show sticky posts before other posts', 'eezy'),
									'first' => __('Show only the first sticky post', 'eezy'),
							),
							'default' => 'top',
						) );

					//Custom Fields
					Infinity_Kirki::add_section( 'custom_fields_section_'.$id, array(
						'title'      => esc_attr__( 'Add Custom Fields', 'eezy' ),
						'panel' => 'panel_'.$view_name,
						'capability' => 'edit_theme_options',
					) );

					//custom fields options
					// TODO: Add custom fields - needs to add a section for each CF
				 Infinity_Kirki::add_field( 'infinity', array(
					 'section'  => 'custom_fields_section_'.$id,
					 'settings' => 'custom-fields_'.$id,
					 'type' => 'select',
					 'description' => 'Select custom fields below to add them to Infinity so you can add them to your page. ',
					 'label' => __('Add Custom Fields', 'eezy'),
					 'choices' => get_custom_fields_list(),
					 'multiple' => 2
					) );

					 //creates section for each part
					 $parts = get_parts_array($id);

					 foreach ($parts as $part_key => $part_name) {

						 //sections
						 Infinity_Kirki::add_section( $part_key . '_'.$id, array(
  					 	'title'      => esc_attr__( $part_name, 'eezy' ),
  					 	'priority'   => 1,
  					 	'panel' => 'panel_'.$view_name,
  					 	'capability' => 'edit_theme_options',
  					 ) );

					 }

					 //title options
					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'title_'.$id,
						'label' => 'Before title',
						'settings' => 'title-option-before-text-' . $id,
						'type' => 'text',
						'default' => ''
					) );

					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'title_'.$id,
							'label' => 'Title Markup',
							'settings' => 'title-option-html-tag-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'h1' => 'H1',
									'h2' => 'H2',
									'h3' => 'H3',
									'h4' => 'H4',
									'h5' => 'H5',
									'h6' => 'H6',
							),
							'default' => 'h2',
							'livepreview' => '',
					) );

					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'title_'.$id,
							'label' => 'Link title',
							'settings' => 'title-option-link-' . $id,
							'type' => 'switch',
							'choices' => array(
									'link' => 'Link',
									'unlink' => 'UnLink'
							),
							'default' => 'link'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'title_'.$id,
							'label' => 'Shorten Title',
							'settings' => 'title-option-shorten-title-' . $id,
							'type' => 'switch',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'on'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'title_'.$id,
							'label' => 'Limit to characters',
							'settings' => 'title-option-shorten-limit-' . $id,
							'type' => 'number',
							'default' => '50'
					) );

					// TODO: move display as to styles
					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'title_'.$id,
							'label' => 'Display As',
							'settings' => 'title-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => '',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					Infinity_Kirki::add_field( 'infinity', array(
						'settings' => 'title-styles-custom-class-' . $id,
						'label'    => __( 'Custom Class', 'eezy' ),
						'section'  => 'title_'.$id,
						'type'     => 'text',
					) );

					//excerpt options
					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'excerpt_'.$id,
						'settings' => 'excerpt_switch_'.$id,
						'type'=> 'radio-buttonset',
						'transport' => 'postMessage',
						'active_callback' => 'my_custom_callback',
						'choices' => array(
								'build'  => esc_attr__( 'Build Mode', 'eezy' ),
								'design' => esc_attr__( 'Design Mode', 'eezy' )
						),
						'default' => 'build'
					) );
					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'excerpt_'.$id,
							'label' => 'Content to show',
							'settings' => 'excerpt-option-content-to-show-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'excerpt' => 'Excerpt',
									'content' => 'Full Content'
							),
							'default' => 'excerpt'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'excerpt_'.$id,
							'label' => 'Excerpt Length',
							'settings' => 'excerpt-option-length-' . $id,
							'type' => 'text',
							'default' => '140',
							'required'  => array(
								array(
									'settings'  => 'excerpt-option-content-to-show-' . $id,
									'operator' => '==',
									'value'    => 'excerpt',
								),
							)
					) );

					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'excerpt_'.$id,
							'label' => 'Excerpt more:',
							'settings' => 'excerpt-option-more-' . $id,
							'type' => 'text',
							'default' => '...',
							'required'  => array(
								array(
									'settings'  => 'excerpt-option-content-to-show-' . $id,
									'operator' => '==',
									'value'    => 'excerpt',
								),
							)
					) );

					Infinity_Kirki::add_field( 'infinity', array(
						'section'  => 'excerpt_'.$id,
							'label' => 'Display As',
							'settings' => 'excerpt-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => null,
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							),
							'required'  => array(
								array(
									'settings'  => 'excerpt_switch_'.$id,
									'operator' => '==',
									'value'    => 'design',
								),
							)
					) );

					Infinity_Kirki::add_field( 'infinity', array(
						'settings' => 'excerpt-styles-custom-class-' . $id,
						'label'    => __( 'Custom Class', 'eezy' ),
						'section'  => 'excerpt_'.$id,
						'type'     => 'text',
					) );

					//Date Options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'date_'.$id,
							'label' => 'Before Text',
							'settings' => 'date-option-before-text-' . $id,
							'type' => 'text',
							'default' => ''
					) );
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'date_'.$id,
							'label' => 'Date Format',
							'type' => 'select',
							'settings' => 'date-option-meta-date-format-' . $id,
							'choices' => array(
									'wordpress-default' => 'WordPress Default',
									'F j, Y' => date('F j, Y'),
									'm/d/y' => date('m/d/y'),
									'd/m/y' => date('d/m/y'),
									'M j' => date('M j'),
									'M j, Y' => date('M j, Y'),
									'F j' => date('F j'),
									'F jS' => date('F jS'),
									'F jS, Y' => date('F jS, Y')
							),
							'default' => 'wordpress-default'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'date_'.$id,
							'label' => 'Display As',
							'settings' => 'date-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'inline-block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					//Image Options

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => '',
							'settings' => 'image-option-thumb-align-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'left' => 'Left',
									'none' => 'None',
									'right' => 'Right'
							),
							'default' => 'left'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Automatically Size Thumb',
							'description' => 'Auto resizes to fit the full width of the article column.',
							'settings' => 'image-option-auto-size-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'on'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Auto size container width',
							'settings' => 'image-option-autosize-container-width-' . $id,
							'type' => 'text',
							'default' => '940',
							'required'  => array(
								array(
									'settings'  => 'image-option-auto-size-' . $id,
									'operator' => '==',
									'value'    => 'on',
								),
							)

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Thumb Width',
							'settings' => 'image-option-thumbnail-width-' . $id,
							'type' => 'text',
							'default' => '250',
							'required'  => array(
								array(
									'settings'  => 'image-option-auto-size-' . $id,
									'operator' => '==',
									'value'    => 'off',
								),
							)
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Thumb Height',
							'settings' => 'image-option-thumbnail-height-' . $id,
							'type' => 'text',
							'default' => '200',
							'required'  => array(
								array(
									'settings'  => 'image-option-auto-size-' . $id,
									'operator' => '==',
									'value'    => 'off',
								),
							)

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Crop thumb vertically',
							'description' => 'Makes the height of all images the same even if originals are not.',
							'settings' => 'image-option-crop-vertically-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'on',
							'required'  => array(
								array(
									'settings'  => 'image-option-auto-size-' . $id,
									'operator' => '==',
									'value'    => 'on',
								),
							)
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Crop vertical ratio',
							'settings' => 'image-option-crop-vertically-height-ratio-' . $id,
							'type' => 'text',
							'default' => '60',
							'required'  => array(
								array(
									'settings'  => 'image-option-auto-size-' . $id,
									'operator' => '==',
									'value'    => 'on',
								),
							)
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Icon Animation',
							'settings' => 'image-icon-type-effect-' . $id,
							'type' => 'select',
							'choices' => array(
									'StyleH' => 'Fade In',
									'StyleHe' => 'Slide Top',
									'StyleLi' => 'Slide Bottom',
									'StyleBe' => 'Slide Right',
									'StyleB' => 'Slide Left',
									'StyleC' => 'Zoom In',
									'StyleN' => 'Twirl In',
									'StyleO' => 'Rotate In',
									'StyleF' => 'Flip In',
									'StyleNe' => 'Zoom Twirl',
									'StyleMg' => 'Left Right In',
									'StyleAl' => 'Top Bottom In',
									'StyleP' => 'Corners In 1',
									'StyleS' => 'Corners In 2',
									'StyleSc' => 'Left Right & Top',
									'StyleTi' => 'Left Right & Center',
									'StyleV' => 'Drop from top',
									'CStyleH' => 'Cubic Top',
									'CStyleHe' => 'Cubic Bottom',
									'CStyleLi' => 'Cubic Right',
									'CStyleBe' => 'Cubic Left',
									'CStyleB' => 'Cubic Zoom In',
									'CStyleC' => 'Cubic Center Zoom Left & Right'
							),
							'default' => 'StyleH'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Icon Cover Effect',
							'settings' => 'image-icon-type-cover-effect-' . $id,
							'type' => 'select',
							'choices' => array(
									'ImageFade' => 'Fade In',
									'ImageFadeExpand' => 'Expand Outwards Top & Bottom',
									'ImageOverlayLi' => 'Expand Inwards Top & Bottom',
									'ImageOverlayB' => 'Expand Outwards Left & Right',
									'ImageOverlayC' => 'Expand Inwards Left & Right',
									'ImageOverlayO' => 'In from top left',
									'ImageOverlayF' => 'In from top right',
									'ImageOverlayNe' => 'In from bottom left',
									'ImageOverlayNa' => 'In from bottom right',
									'ImageOverlayMg' => 'Expand In from Top',
									'ImageOverlayAl' => 'Expand In from Bottom',
									'ImageOverlaySi' => 'Expand In from Right',
									'ImageOverlayP' => 'Expand In from Left',
									'ImageOverlayS' => 'Twirl In',
									'ImageOverlayCl' => 'Twirl In Bottom Right',
									'ImageOverlayK' => 'Flip In Bottom Left',
									'ImageOverlayCa' => 'Flip In Top',
									'ImageOverlaySc' => 'Flip In Bottom',
									'ImageOverlayTi' => 'Flip In Top Right',
							),
							'default' => 'ImageFade'
					) );
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Icon Style',
							'settings' => 'image-icon-type-style-' . $id,
							'type' => 'select',
							'choices' => array(
									'Headway' => 'Style in Headway',
									'WhiteRounded' => 'White Rounded',
									'BlackRounded' => 'Black Rounded',
									'WhiteHollowRounded' => 'White Hollow Rounded',
									'BlackHollowRounded' => 'Black Hollow Rounded',
									'WhiteSquare' => 'White Square',
									'BlackSquare' => 'Black Square',
									'WhiteHollowSquare' => 'White Hollow Square',
									'BlackHollowSquare' => 'Black Hollow Square',

							),
							'default' => 'WhiteRounded'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Cover Content Effect',
							'settings' => 'image-content-type-hover-effect-' . $id,
							'type' => 'select',
							'choices' => array(
									'ShowFirst' => 'Show On Load',
									'H' => 'Fade In',
									'He' => 'Scale In',
									'Li' => 'Scale Out & In',
									'Be' => 'Zoom In',
									'B' => 'Slide from Top',
									'C' => 'Slide from Bottom',
									'N' => 'Slide from Right',
									'O' => 'Slide from Left',
									'F' => 'Flip half Left',
									'Ne' => 'Flip half Top',
									'Na' => 'Flip half Right',
									'Mg' => 'Flip half Bottom',
									'Al' => 'Spin Zoom Horizontal',
									'Si' => 'Spin Zoom Vertical',
									'P' => 'Spin Horizontal',
									'S' => 'Spin Vertical',
									'Cl' => 'Push Up',
									'Ar' => 'Push Top',
									'K' => 'Push Right',
									'Ca' => 'Push Left',
									'Sc' => 'Slide Down',
									'Ti' => 'Slide Left',
									'V' => 'Slide Right',
									'Cr' => 'Slide Bottom',
									'Mn' => 'Rotate in Bottom Left',
									'Fe' => 'Rotate in Top Right',
									'Cu' => 'Flip Horizontal',
									'Zn' => 'Flip Vertical'
							),
							'default' => 'H'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Center Content Vertically',
							'settings' => 'image-content-type-content-vertical-align-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'top' => 'Top',
									'center' => 'Center',
									'bottom' => 'Bottom'
							),
							'default' => 'center'

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Lightbox Image Width',
							'settings' => 'image-icon-type-lightbox-width-' . $id,
							'type' => 'text',
							'default' => '1024'

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Lightbox Image Height',
							'settings' => 'image-icon-type-lightbox-height-' . $id,
							'type' => 'text',
							'default' => '768'

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Show Hover Cover',
							'settings' => 'image-show-cover-hide-' . $id,
							'type' => 'checkbox',
							'default' => true
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Cover Type',
							'settings' => 'thumb-cover-type-hide-' . $id,
							'type' => 'select',
							'choices' => array(
									'icons' => 'Icons',
									'content' => 'Content',
									'flip' => 'Image Flip'
							),
							'default' => 'icons'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Cover Icon Builder',
							'settings' => 'image-cover-icon-type-icons-' . $id,
							'type' => 'sortable',
							'choices' => array(
									'btn1' => 'Icon 1',
									'btn2' => 'Icon 2',
									'btn3' => 'Icon 3',
									'btn4' => 'Icon 4'
							),
							'default' => array('btn1', 'btn2')

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Icon 1',
							'settings' => 'btn1-option-icon-' . $id,
							'type' => 'select',
							'default' => 'search',
							'choices' => font_awesome_icons(),

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Link 1',
							'settings' => 'btn1-option-link-' . $id,
							'description' => 'Add an http:// link or use <strong>lightbox</strong> or content (links to the full content item)',
							'type' => 'text',
							'default' => 'lightbox'

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Icon 2',
							'settings' => 'btn2-option-icon-' . $id,
							'type' => 'select',
							'default' => 'link',
							'choices' => font_awesome_icons(),
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Link 2',
							'settings' => 'btn2-option-link-' . $id,
							'type' => 'text',
							'default' => 'content'

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Icon 3',
							'settings' => 'btn3-option-icon-' . $id,
							'type' => 'select',
							'choices' => font_awesome_icons(),
							'default' => null

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Link 3',
							'settings' => 'btn3-option-link-' . $id,
							'type' => 'text',
							'default' => null

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Icon 4',
							'settings' => 'btn4-option-icon-' . $id,
							'type' => 'select',
							'choices' => font_awesome_icons(),
							'default' => 'check'

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Link 4',
							'settings' => 'btn4-option-link-' . $id,
							'type' => 'text',
							'default' => 'check'

					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Display As',
							'settings' => 'image-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'B',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );


					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'image_'.$id,
							'label' => 'Cover Content Builder',
							'settings' => 'image-parts-content-type-' . $id,
							'description' => 'Add <b>Icons</b> or <b>Content Parts</b> to the Image cover using the builder below. Then set the animation effect.',
							'type' => 'sortable',
							'choices' => get_cover_builder_elements($id),
							'default' => array('title', 'categories')
					) );







					//Read more options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'readmore_'.$id,
							'label' => 'Read more text',
							'settings' => 'readmore-option-more-text-' . $id ,
							'type' => 'text',
							'default' => 'Read More'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'readmore_'.$id,
							'label' => 'Show Always',
							'settings' => 'readmore-option-show-always-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'off'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'readmore_'.$id,
							'label' => 'Display As',
							'settings' => 'readmore-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					//Time since options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'time_'.$id,
							'label' => 'Before time text',
							'settings' => 'time-option-time-before-' . $id,
							'type' => 'text',
							'default' => null
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'time_'.$id,
							'label' => 'Time format',
							'settings' => 'time-option-time-format-' . $id,
							'type' => 'Select',
							'choices' => array(
									'wordpress-default' => 'WordPress Default',
									'g:i A' => date('g:i A'),
									'g:i A T' => date('g:i A T'),
									'g:i:s A' => date('g:i:s A'),
									'G:i' => date('G:i'),
									'G:i T' => date('G:i T')
							),
							'default' => 'wordpress-default'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'time_'.$id,
							'label' => 'Show as Time Since',
							'settings' => 'time-option-time-since-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'on'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'time_'.$id,
							'label' => 'Display As',
							'settings' => 'time-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'inline-block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					//Categories options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'categories_'.$id,
							'label' => 'Before categories text',
							'settings' => 'categories-option-before-' . $id,
							'type' => 'text',
							'default' => null
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'categories_'.$id,
							'label' => 'Display As',
							'settings' => 'categories-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'inline-block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					//Tags options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'tags_'.$id,
							'label' => 'Before tags text',
							'settings' => 'tags-option-before-' . $id,
							'type' => 'text',
							'default' => null
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'tags_'.$id,
							'label' => 'Display As',
							'settings' => 'tags-styles-display-as-' . $id,
							'type' => 'rad',
							'default' => 'inline-block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					//Post Format options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'post_format_'.$id,
							'label' => 'Before post format text',
							'settings' => 'post-format-option-before-' . $id,
							'type' => 'text',
							'default' => null
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'post_format_'.$id,
							'label' => 'Display format as',
							'settings' => 'post-format-option-type-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'text' => 'Text',
									'icon' => 'Icon'
							),
							'default' => 'icon'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'post_format_'.$id,
							'label' => 'Icon Size',
							'settings' => 'post-format-option-icon-size-' . $id,
							'type' => 'text',
							'default' => '32'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'post_format_'.$id,
							'label' => 'Display As',
							'settings' => 'post-format-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'inline-block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					//Author options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'author_'.$id,
							'label' => 'Link to author page?',
							'settings' => 'author-option-linked-' .  $id . '',
							'type' => 'radio-buttonset',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'on'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'author_'.$id,
							'label' => 'Before author text',
							'settings' => 'author-option-before-' . $id,
							'type' => 'text',
							'default' => ''
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'author_'.$id,
							'label' => 'Display As',
							'settings' => 'author-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'inline-block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					//Avatar options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'avatar_'.$id,
							'label' => 'Link to author page?',
							'settings' => 'avatar-option-linked-' .  $id . '',
							'type' => 'radio-buttonset',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'on'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'avatar_'.$id,
							'label' => 'Before avatar text',
							'settings' => 'avatar-option-before-' . $id,
							'type' => 'text',
							'default' => ''
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'avatar_'.$id,
							'label' => 'Avatar size',
							'settings' => 'avatar-option-size-' . $id,
							'type' => 'text',
							'default' => 32
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'avatar_'.$id,
							'label' => 'Display As',
							'settings' => 'avatar-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'inline-block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					//Comments Options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'comments_'.$id,
							'label' => 'If Several Comments',
							'settings' => 'comments-option-comments-format-' . $id,
							'type' => 'text',
							'default' => '%num% Comments'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'comments_'.$id,
							'label' => 'If 1 Comment',
							'settings' => 'comments-option-comments-format-1-' . $id,
							'type' => 'text',
							'default' => '%num% Comment'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'comments_'.$id,
							'label' => 'If no Comments',
							'settings' => 'comments-option-comments-format-0-' . $id,
							'type' => 'text',
							'default' => '%num% Comments'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'comments_'.$id,
							'label' => 'Before comments text',
							'settings' => 'comments-option-before-' . $id,
							'type' => 'text',
							'default' => ''
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'comments_'.$id,
							'label' => 'Display As',
							'settings' => 'comments-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'inline-block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					//share options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => 'Before share text',
							'settings' => 'share-option-before-' . $id,
							'type' => 'text',
							'default' => 'Share this: '
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => 'Twitter Icon',
							'settings' => 'share-option-icon-twitter-heading-' . $id,
							'type' => 'custom'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => '',
							'settings' => 'share-option-icon-fa-twitter-' . $id,
							'type' => 'select',
							'default' => 'fa-twitter',
							'choices' => array(
									'hide' => 'None (Hide)',
									'fa-twitter' => 'Twitter',
									'fa-twitter-square' => 'Twitter Square'
							),
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => 'New Window',
							'settings' => 'share-option-twitter-target-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'on'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => 'Facebook Icon',
							'settings' => 'share-option-icon-fa-facebook-heading-' . $id,
							'type' => 'custom'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => '',
							'settings' => 'share-option-icon-fa-facebook-' . $id,
							'type' => 'select',
							'default' => 'fa-facebook',
							'choices' => array(
									'hide' => 'None (Hide)',
									'fa-facebook' => 'Facebook',
									'fa-facebook-square' => 'Facebook Square'
							),
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => 'New Window',
							'settings' => 'share-option-facebook-target-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'on'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => 'Google Plus Icon',
							'settings' => 'share-option-icon-fa-google-plus-heading-' . $id,
							'type' => 'custom'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => '',
							'settings' => 'share-option-icon-fa-google-plus-' . $id,
							'type' => 'select',
							'default' => 'fa-google-plus',
							'choices' => array(
									'hide' => 'None (Hide)',
									'fa-google-plus' => 'Google Plus',
									'fa-google-plus-square' => 'Google Plus Square'
							),
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => 'New Window',
							'settings' => 'share-option-googleplus-target-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'on'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => 'Linkedin Icon',
							'settings' => 'share-option-icon-fa-linkedin-heading-' . $id,
							'type' => 'custom'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => '',
							'settings' => 'share-option-icon-fa-linkedin-' . $id,
							'type' => 'select',
							'default' => 'fa-linkedin',
							'choices' => array(
									'hide' => 'None (Hide)',
									'fa-linkedin' => 'Linkedin',
									'fa-linkedin-square' => 'Linkedin Square'
							),
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => 'New Window',
							'settings' => 'share-option-linkedin-target-' . $id,
							'type' => 'radio-buttonset',
							'choices' => array(
									'on' => 'Yes',
									'off' => 'No'
							),
							'default' => 'on'
					) );

					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'share_'.$id,
							'label' => 'Display As',
							'settings' => 'share-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					//likes options
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'likes_'.$id,
							'label' => 'Before likes text',
							'settings' => 'likes-option-before-' . $id,
							'type' => 'text',
							'default' => 'Likes: '
					) );
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'likes_'.$id,
							'label' => 'Show like/unlike text',
							'settings' => 'likes-option-show_like_text-' . $id,
							'type' => 'radio-buttonset',
									'choices' => array(
											'show' => 'Show',
											'hide' => 'Hide'
									),
							'default' => 'show'
					) );
					Infinity_Kirki::add_field( 'infinity', array(
							'section'  => 'likes_'.$id,
							'label' => 'Display As',
							'settings' => 'likes-styles-display-as-' . $id,
							'type' => 'radio-buttonset',
							'default' => 'block',
							'choices' => array(
									'' => 'None',
									'block' => 'Block',
									'inline' => 'Inline',
									'inline-block' => 'Inline Block'
							)
					) );

					if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

							//Woocommerce Price options
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-price_'.$id,
									'label' => 'Before Price text',
									'settings' => 'wc-price-option-before-' . $id,
									'type' => 'text',
									'default' => null
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-price_'.$id,
									'label' => 'Display As',
									'settings' => 'wc-price-styles-display-as-' . $id,
									'type' => 'select',
									'default' => 'inline-block',
									'choices' => array(
											'' => 'None',
											'block' => 'Block',
											'inline' => 'Inline',
											'inline-block' => 'Inline Block'
									)
							) );

							//Woocommerce Rating options
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-rating_'.$id,
									'label' => 'Show as stars',
									'settings' => 'wc-rating-option-show-as-stars-' . $id,
									'type' => 'radio-buttonset',
									'choices' => array(
											'on' => 'Yes',
											'off' => 'No'
									),
									'default' => 'on'
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-rating_'.$id,
									'label' => 'Show review count',
									'settings' => 'wc-rating-option-show-review-count-' . $id,
									'type' => 'radio-buttonset',
									'choices' => array(
											'on' => 'Yes',
											'off' => 'No'
									),
									'default' => 'off'
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-rating_'.$id,
									'label' => 'Before Rating text',
									'settings' => 'wc-rating-option-before-' . $id,
									'type' => 'text',
									'default' => null
							) );
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-rating_'.$id,
									'label' => 'Display As',
									'settings' => 'wc-rating-styles-display-as-' . $id,
									'type' => 'select',
									'default' => 'inline-block',
									'choices' => array(
											'' => 'None',
											'block' => 'Block',
											'inline' => 'Inline',
											'inline-block' => 'Inline Block'
									)
							) );

							//Woocommerce Sale Flash
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-sale-flash_'.$id,
									'label' => 'Before Sale Flash text',
									'settings' => 'wc-sale-flash-option-before-' . $id,
									'type' => 'text',
									'default' => null
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-sale-flash_'.$id,
									'label' => 'After Sale Flash text',
									'settings' => 'wc-sale-flash-option-after-' . $id,
									'type' => 'text',
									'default' => null
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-sale-flash_'.$id,
									'label' => 'On Sale Flash text',
									'settings' => 'wc-sale-flash-option-text-' . $id,
									'type' => 'text',
									'default' => 'On Sale!'
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-sale-flash_'.$id,
									'label' => 'Show sale as percent',
									'description' => 'Replaces on sale flash text',
									'settings' => 'wc-sale-flash-option-as-percent-off-' . $id,
									'type' => 'radio-buttonset',
									'choices' => array(
											'on' => 'Yes',
											'off' => 'No'
									),
									'default' => 'off'
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-sale-flash_'.$id,
									'label' => 'Display As',
									'settings' => 'wc-sale-flash-styles-display-as-' . $id,
									'type' => 'select',
									'default' => 'inline-block',
									'choices' => array(
											'' => 'None',
											'block' => 'Block',
											'inline' => 'Inline',
											'inline-block' => 'Inline Block'
									)
							) );

							//Woocommerce Add Cart options
							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-add-to-cart_'.$id,
									'label' => 'Add to cart text',
									'settings' => 'wc-add-to-cart-option-add-text-' . $id,
									'type' => 'text',
									'default' => 'Add to cart'
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'wc-add-to-cart_'.$id,
									'label' => 'Display As',
									'settings' => 'wc-add-to-cart-styles-display-as-' . $id,
									'type' => 'select',
									'default' => 'inline-block',
									'choices' => array(
											'' => 'None',
											'block' => 'Block',
											'inline' => 'Inline',
											'inline-block' => 'Inline Block'
									)
							) );

							Infinity_Kirki::add_field( 'infinity', array(
								'settings' => 'wc-add-to-cart-styles-custom-class-' . $id,
								'label'    => __( 'Custom Class', 'eezy' ),
								'section'  => 'wc-add-to-cart_'.$id,
								'type'     => 'text',
							) );

					} //end woocommerce check

					//creates section for custom fields
					$infinity_options = views();
					$custom_fields_array = $infinity_options->getOption( 'custom-fields_'.$id );

					if( is_array($custom_fields_array) )
						foreach($custom_fields_array as $key => $field_slug) {

							Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'custom-field-' . $field_slug.'_'.$id,
								'label' => 'Before text',
								'settings' => 'custom-field-'.$field_slug.'-option-before-' . $id,
								'type' => 'text',
								'default' => null
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'custom-field-' . $field_slug.'_'.$id,
									'label' => 'Display As',
									'settings' => 'custom-field-'.$field_slug.'-styles-display-as-' . $id,
									'type' => 'select',
									'default' => 'block',
									'choices' => array(
											'' => 'None',
											'block' => 'Block',
											'inline' => 'Inline',
											'inline-block' => 'Inline Block'
									)
							) );

						}

						//Layout fields
						//Grid
						Infinity_Kirki::add_section( 'grid_'.$id, array(
							'title'      => esc_attr__( 'Layout - Grid', 'eezy' ),
							'priority'   => 1,
							'panel' => 'panel_'.$view_name,
							'capability' => 'edit_theme_options',
						) );

						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'repeater',
							'label'       => esc_attr__( 'Grid responsive layout', 'eezy' ),
							'section'  => 'grid_'.$id,
							'settings'    => 'grid-responsive-settings_' .$id,
							'fields' => array(
									'grid-width' => array(
											'label' => 'At Breakpoint',
											'description' => 'When the screen is equal to or larger than',
											'type' => 'text'
									),
									'grid-columns' => array(
											'label' => 'Display how many columns?',
											'description' => 'Modify number of columns per row to',
											'type' => 'text'
									)
							)
						) );

						//Masonry
						Infinity_Kirki::add_section( 'masonry_'.$id, array(
							'title'      => esc_attr__( 'Layout - Masonry', 'eezy' ),
							'priority'   => 1,
							'panel' => 'panel_'.$view_name,
							'capability' => 'edit_theme_options',
						) );

						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-filter-header_'.$id,
                'type' => 'custom',
                'default'=> '<h3>Filter Navigation</h3>'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-disable-filter_'.$id,
                'label' => 'Disable Filter?',
                'type' => 'switch',
                'choices' => array(
                    'yes' => __('Yes', 'eezy'),
										'no' => __('No', 'eezy')
                )
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-nav-position_'.$id,
                'label' => 'Filter Nav Position?',
                'type' => 'select',
                'choices' => array(
                    'left' => __('Left', 'eezy'),
                    'centered' => __('Centered', 'eezy')
                ),
                'default' => 'centered'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-alltext_'.$id,
                'label' => 'All Button Text',
                'type' => 'text',
                'default' => 'Show All',
                'description' => 'Text to show for all items button'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-before-filter-text_'.$id,
                'label' => 'Before Filter Text',
                'type' => 'text',
                'default' => null,
                'description' => 'Text to display before the filters'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-filter-type_'.$id,
                'type' => 'select',
                'label' => __('Filter Type', 'eezy'),
                'choices' => array(
                    'buttons' => 'Buttons',
                    'select'  => 'Select'
                ),
                'default' => 'buttons'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-filter-animation_'.$id,
                'type' => 'select',
                'label' => __('Filter Animation', 'eezy'),
                'choices' => array(
                    'scale' => 'Scale',
                    'fade'  => 'Fade',
                    'flip' => 'Flip',
                    'turn' => 'Turn',
                    'rotate' => 'Rotate',
                ),
                'default' => 'scale'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-taxonomy_'.$id,
                'label' => 'Filter taxonomy',
                'type' => 'select',
                'choices' => get_filter_taxonomy_list()
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-childof_'.$id,
                'label' => 'Child Of',
                'type' => 'select',
                'choices' => get_taxonomies_by_taxonomy_list(),
                'description' => 'If you change the Filter taxonomy above please save to update this field.'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-exclude_'.$id,
                'label' => 'Exclude',
                'type' => 'select',
                'choices' => get_taxonomies_by_taxonomy_list(),
                'multiple' => 5,
                'description' => 'If you change the Filter taxonomy above please save to update this field.'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'masonry_'.$id,
								'settings' => 'masonry-include_'.$id,
                'label' => 'Include',
                'type' => 'select',
                'choices' => get_taxonomies_by_taxonomy_list(),
                'multiple' => 5,
                'description' => 'If you change the Filter taxonomy above please save to update this field.'
            ) );

						Infinity_Kirki::add_field( 'infinity', array(
							'type'        => 'repeater',
							'label'       => esc_attr__( 'Masonry responsive layout', 'eezy' ),
							'section'  => 'masonry_'.$id,
							'settings'    => 'masonry-responsive-settings_' .$id,
							'fields' => array(
									'masonry-width' => array(
											'title' => 'At Breakpoint',
											'description' => 'When the screen is equal to or larger than',
											'type' => 'text',
											'width' => '10'
									),
									'masonry-columns' => array(
											'title' => 'Display how many columns?',
											'description' => 'Modify number of columns per row to',
											'type' => 'text',
											'width' => '10'
									)

							)
						) );

						//Slider
						Infinity_Kirki::add_section( 'slider_'.$id, array(
							'title'      => esc_attr__( 'Layout - Slider', 'eezy' ),
							'priority'   => 1,
							'panel' => 'panel_'.$view_name,
							'capability' => 'edit_theme_options',
						) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-mousedrag'.$id,
                'label' => 'Mouse Drag',
                'type' => 'switch',
                'choices' => array(
                    'false' => 'Off',
                    'true' => 'On'
                ),
                'default' => 1
						) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-autoplay'.$id,
                'label' => 'Autoplay',
                'type' => 'switch',
                'choices' => array(
                    'true' => __('On', 'eezy'),
                    'false' => __('Off', 'eezy'),
                ),
                'default' => 0
						) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-autoplay-hover-pause'.$id,
                'label' => 'Pause Autoplay on Hover',
                'type' => 'switch',
                'choices' => array(
                    'true' => __('On', 'eezy'),
                    'false' => __('Off', 'eezy'),
                ),
                'default' => 1
						) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-autoplay-timeout'.$id,
                'label' => 'Autoplay Timeout',
                'type' => 'text',
                'default' => '5000'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-show-nav'.$id,
                'label' => 'Show Next & Prev Nav',
                'type' => 'switch',
                'choices' => array(
                    'true' => __('On', 'eezy'),
                    'false' => __('Off', 'eezy'),
                ),
                'default' => 1
						) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-show-dotsnav'.$id,
                'label' => 'Show Dots Navigation',
                'type' => 'switch',
                'choices' => array(
                    'true' => __('On', 'eezy'),
                    'false' => __('Off', 'eezy'),
                ),
                'default' => 1
						) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-navtext-next'.$id,
                'label' => 'Navigation Text (Next)',
                'type' => 'textarea',
                'rows' => '1',
                'default' => '<span class="dashicons dashicons-arrow-right-alt2"></span>'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-navtext-prev'.$id,
                'label' => 'Navigation Text (Prev)',
                'type' => 'textarea',
                'rows' => '1',
                'default' => '<span class="dashicons dashicons-arrow-left-alt2"></span>'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-nav-type'.$id,
                'label' => 'Navigation Type',
                'type' => 'select',
                'choices' => array(
                    'dots' => 'Dots',
                    'numbers' => 'Numbers',
                    'thumbs' => 'Thumbnails'
                ),
                'default' => 'dots'
						) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-nav-position'.$id,
                'label' => 'Navigation Y Position',
                'type' => 'select',
                'choices' => array(
                    'top' => 'Top',
                    'center' => 'Center',
                    'bottom' => 'Bottom'
                ),
                'default' => 'center'
						) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-nav-thumb-width'.$id,
                'label' => 'Thumb Width',
                'type' => 'text',
                'default' => '36',
							) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-nav-thumb-height'.$id,
                'label' => 'Thumb Height',
                'type' => 'text',
                'default' => '36'
							) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-animate-in'.$id,
                'label' => 'Animate In',
                'type' => 'select',
                'description' => '',
                'default' => 'fadeIn',
                'choices' => array(
                    'bounceIn' => 'bounceIn',
                    'bounceInDown' => 'bounceInDown',
                    'bounceInLeft' => 'bounceInLeft',
                    'bounceInRight' => 'bounceInRight',
                    'bounceInUp' => 'bounceInUp',
                    'fadeIn' => 'fadeIn',
                    'fadeInDown' => 'fadeInDown',
                    'fadeInDownBig' => 'fadeInDownBig',
                    'fadeInLeft' => 'fadeInLeft',
                    'fadeInLeftBig' => 'fadeInLeftBig',
                    'fadeInRight' => 'fadeInRight',
                    'fadeInRightBig' => 'fadeInRightBig',
                    'fadeInUp' => 'fadeInUp',
                    'fadeInUpBig' => 'fadeInUpBig',
                    'flip' => 'flip',
                    'flipInX' => 'flipInX',
                    'flipInY' => 'flipInY',
                    'lightSpeedIn' => 'lightSpeedIn',
                    'rotateIn' => 'rotateIn',
                    'rotateInDownLeft' => 'rotateInDownLeft',
                    'rotateInDownRight' => 'rotateInDownRight',
                    'rotateInUpLeft' => 'rotateInUpLeft',
                    'rotateInUpRight' => 'rotateInUpRight',
                    'hinge' => 'hinge',
                    'rollIn' => 'rollIn',
                    'zoomIn' => 'zoomIn',
                    'zoomInDown' => 'zoomInDown',
                    'zoomInLeft' => 'zoomInLeft',
                    'zoomInRight' => 'zoomInRight',
                    'zoomInUp' => 'zoomInUp',
                )
							) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'slider_'.$id,
								'settings' => 'slider-animate-out'.$id,
                'label' => 'Animate Out',
                'type' => 'select',
                'description' => '',
                'default' => 'fadeOut',
                'choices' => array(
                    'bounceOut' => 'bounceOut',
                    'bounceOutDown' => 'bounceOutDown',
                    'bounceOutLeft' => 'bounceOutLeft',
                    'bounceOutRight' => 'bounceOutRight',
                    'bounceOutUp' => 'bounceOutUp',
                    'fadeOut' => 'fadeOut',
                    'fadeOutDown' => 'fadeOutDown',
                    'fadeOutDownBig' => 'fadeOutDownBig',
                    'fadeOutLeft' => 'fadeOutLeft',
                    'fadeOutLeftBig' => 'fadeOutLeftBig',
                    'fadeOutRight' => 'fadeOutRight',
                    'fadeOutRightBig' => 'fadeOutRightBig',
                    'fadeOutUp' => 'fadeOutUp',
                    'fadeOutUpBig' => 'fadeOutUpBig',
                    'flip' => 'flip',
                    'flipOutX' => 'flipOutX',
                    'flipOutY' => 'flipOutY',
                    'lightSpeedOut' => 'lightSpeedOut',
                    'rotateOut' => 'rotateOut',
                    'rotateOutDownLeft' => 'rotateOutDownLeft',
                    'rotateOutDownRight' => 'rotateOutDownRight',
                    'rotateOutUpLeft' => 'rotateOutUpLeft',
                    'rotateOutUpRight' => 'rotateOutUpRight',
                    'hinge' => 'hinge',
                    'rollOut' => 'rollOut',
                    'zoomIn' => 'zoomIn',
                    'zoomInDown' => 'zoomInDown',
                    'zoomInLeft' => 'zoomInLeft',
                    'zoomInRight' => 'zoomInRight',
                    'zoomInUp' => 'zoomInUp',
                    'zoomOut' => 'zoomOut',
                    'zoomOutDown' => 'zoomOutDown',
                    'zoomOutLeft' => 'zoomOutLeft',
                    'zoomOutRight' => 'zoomOutRight',
                    'zoomOutUp' => 'zoomOutUp'
                )
							) );

							//Carousel
							Infinity_Kirki::add_section( 'carousel_'.$id, array(
								'title'      => esc_attr__( 'Layout - Carousel', 'eezy' ),
								'priority'   => 1,
								'panel' => 'panel_'.$view_name,
								'capability' => 'edit_theme_options',
							) );

							Infinity_Kirki::add_field( 'infinity', array(
									'section'  => 'carousel_'.$id,
									'settings' => 'carousel-mousedrag-'.$id,
                'label' => 'Mouse Drag',
                'description' => 'Enable click drag mouse to page carousel',
                'type' => 'switch',
                'labels' => array(
                    'true' => __('On', 'eezy'),
                    'false' => __('Off', 'eezy'),
                ),
                'default' => 1,
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'carousel_'.$id,
								'settings' => 'carousel-autoplay-'.$id,
                'label' => 'Autoplay',
                'type' => 'switch',
                'choices' => array(
                    'true' => __('On', 'eezy'),
                    'false' => __('Off', 'eezy'),
                ),
                'default' => 0,
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'carousel_'.$id,
								'settings' => 'carousel-autoplay-hover-pause-'.$id,
                'label' => 'Pause autoplay',
                'type' => 'switch',
                'choices' => array(
                    'on' => __('On', 'eezy'),
                    'off' => __('Off', 'eezy'),
                ),
                'default' => 1,
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'carousel_'.$id,
								'settings' => 'carousel-autoplay-timeout-'.$id,
                'label' => 'Autoplay Timeout',
                'type' => 'text',
                'default' => '5000'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'carousel_'.$id,
								'settings' => 'carousel-auto_height-'.$id,
                'label' => 'Auto Height',
                'type' => 'switch',
                'choices' => array(
                    'true' => __('On', 'eezy'),
                    'false' => __('Off', 'eezy'),
                ),
                'default' => 1,
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'carousel_'.$id,
								'settings' => 'carousel-navtext-next-'.$id,
                'label' => 'Navigation Text (Next)',
                'type' => 'textarea',
                'rows' => '1',
                'default' => '<span class="dashicons dashicons-arrow-right-alt2"></span>'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'carousel_'.$id,
								'settings' => 'carousel-navtext-prev-'.$id,
                'label' => 'Navigation Text (Prev)',
                'type' => 'textarea',
                'default' => '<span class="dashicons dashicons-arrow-left-alt2"></span>'
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'carousel_'.$id,
								'settings' => 'carousel-nav-position-'.$id,
                'label' => 'Navigation Y Position',
                'type' => 'select',
                'choices' => array(
                    'top' => 'Top',
                    'center' => 'Center',
                    'bottom' => 'Bottom'
                ),
                'default' => 'center',
            ) );
						Infinity_Kirki::add_field( 'infinity', array(
								'section'  => 'carousel_'.$id,
								'settings' => 'carousel-show-nav-'.$id,
                'label' => 'Show Next & Prev Nav',
                'type' => 'switch',
                'choices' => array(
                    'true' => __('On', 'eezy'),
                    'false' => __('Off', 'eezy'),
                ),
                'default' => 1,
            ) );





	     endwhile;

	     endif;

	 wp_reset_postdata();

 }

 add_action('wp_loaded', 'infinity_options');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
// function _s_customize_preview_js() {
// 	wp_enqueue_script( '_s_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
// }
// add_action( 'customize_preview_init', '_s_customize_preview_js' );
