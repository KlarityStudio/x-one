<?php


function custom_post_type() {
  $name = 'View';//name will be converted to lowercase with underscores for spaces and dashes
  // Register Custom Post Type
	$labels = array(
    'name'               => sprintf(__('%ss', 'infinity'), 'Views'),
    'singular_name'      => $name,
    'menu_name'          => sprintf(__( '%ss', 'infinity' ), 'Infinity View'),
    'name_admin_bar'     => sprintf(__( '%s', 'infinity' ), $name),
    'add_new'            => __( 'Add New', 'infinity' ),
    'add_new_item'       => sprintf(__( 'Add New %s', 'infinity' ), $name),
    'new_item'           => sprintf(__( 'New %s', 'infinity' ), $name),
    'edit_item'          => sprintf(__( 'Editing %s', 'infinity' ), $name),
    'view_item'          => sprintf(__( 'View %s', 'infinity' ), $name),
    'all_items'          => sprintf(__( 'All %ss', 'infinity' ), $name),
    'search_items'       => sprintf(__( 'Search %ss', 'infinity' ), $name),
    'parent_item_colon'  => sprintf(__( 'Parent %ss:', 'infinity' ), $name),
    'not_found'          => sprintf(__( 'No %ss found.', 'infinity' ), strtolower($name)),
    'not_found_in_trash' => sprintf(__( 'No %ss found in Trash.', 'infinity' ), strtolower($name))
	);
	$args = array(
		'labels'                => $labels,
    'public'               => true,
    'hierarchical'         => false,
    'exclude_from_search'  => null,
    'publicly_queryable'   => null,
    'show_ui'              => null,
    'show_in_menu'         => null,
    'show_in_nav_menus'    => null,
    'show_in_admin_bar'    => null,
    'menu_position'        => null,
    'menu_icon'            => null,
    'capability_type'      => 'post',
    'map_meta_cap'         => null,
    'supports'             => array( 'title' ),
    'register_meta_box_cb' => null,
    'taxonomies'           => array(),//default is empty array, we have assigned the tag taxonomy for demostration purposes. Any taxonomies added here must be builtin or registered before the init priority 10. If you want to assign Fluent_Taxonomies you need to declare this post type when registering the taxonomy.
    'has_archive'          => true,//default = false but we have set to true so you can see the archive template overwrite
    'rewrite'              => true,
    'query_var'            => true,
    'can_export'           => true,
    'delete_with_user'     => null,
    '_edit_link'           => 'post.php?post=%d',
    //our custom messages array, defaults detailed below. this allows you to change the notices when posts are changed in some way without adding yet more filters
    'messages' => array(
        0  => '', // Unused. Messages start at index 1.
        1  => __( '%s updated.', 'domain' ),
        2  => __( 'Custom field updated.', 'domain' ),
        3  => __( 'Custom field deleted.', 'domain' ),
        4  => __( '%s updated.', 'domain' ),
        5  => __( '%s restored to revision from %s', 'domain' ),
        6  => __( '%s published.', 'domain' ),
        7  => __( '%s saved.', 'domain' ),
        8  => __( '%s submitted.', 'domain' ),
        9  => __( '%s scheduled for: <strong>%s</strong>.', 'domain' ),
        10 => __( '%s draft updated.', 'domain' )
    ),
    //want to disable people adding new posts?
    'disable_add_new' => false,
	);
	register_post_type( 'ib_views', $args );

}
add_action( 'init', 'custom_post_type', 0 );
