<?php

/*

@package Kommerce

    ==================================================
        Kommerce Framework Custom Post Types
    ==================================================
*/

/*----------     New Faq Custom Post Type     ----------*/
function newFaqCustomPostType(){

	$singular 	    = 'Faq';
	$plural 	    = "Faq's";
	$labels 	    = array(
		'name' 					  => $plural,
		'singular_name' 		  => $singular,
		'add_name' 				  => 'Add New',
		'add_new_item' 			  => 'Add New ' . $singular,
		'edit' 					  => 'Edit',
		'edit_item'				  => 'Edit ' . $singular,
		'new_item'				  => 'New ' . $singular,
		'view'					  => 'View ' . $singular,
		'view_item'			  	  => 'View ' . $singular,
		'search_item'			  => 'Search ' . $plural,
		'parent'				  => 'Parent ' . $singular,
		'not_found' 			  => 'No ' . $plural . ' found',
		'not_found_in_trash' 	  => 'No ' . $plural . ' in Trash',
	);
	$args = array(
		'labels'			 	  => $labels,
		'public' 				  => true,
		'public_queryable' 		  => true,
		'exclude_from_search'     => false,
		'show_in_nav_menus' 	  => true,
		'show_in_ui' 			  => true,
		// 'show_in_menu' 	      => 'nos_menu',
		'show_in_admin_bar' 	  => true,
		'can_export' 			  => true,
		'delete_with_user' 		  => false,
		'hierarchical' 			  => false,
		'query_var' 			  => true,
		'capability_type' 		  => 'page',
		'map_meta_cap' 		      => true,
		'rewrite' 				  => array(
			'slug' 				          => 'faq',
			'with_front' 		          => true,
			'pages' 			          => true,
			'feeds' 			          => true,
		),
		'supports' 				     => array(
			'title',
			'editor',
			'custom_fields',
			'thumbnail',
			'post-formats',
		)
	);
	register_post_type('faq', $args);
}
add_action('init', 'newFaqCustomPostType');
