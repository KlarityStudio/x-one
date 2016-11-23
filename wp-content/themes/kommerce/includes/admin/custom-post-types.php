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



//Adding a textarea meat pox to posts for the h1 support text displayed on the single post
/*-----------     Post Type Metaboxes    -----------*/

	function post_custom_metaboxes(){
		add_meta_box(
			'postAdd',
			"Post Title Support Description",
			'post_meta_callback',
			'post'
		);

	}

	add_action('add_meta_boxes', 'post_custom_metaboxes');


	function post_meta_callback( $post ){

		wp_nonce_field( basename( __FILE__ ), 'news_nonce');
		$news_stored_meta = get_post_meta( $post->ID ); ?>
		<div class="meta_row">
			<div class="meta_row author_name">
				<div class="meta_th">
					<label for="post_support" class="meta_label">Enter the posts title support description</label>
				</div>
		        <div class="meta_editor excerpt">
				<?php

		    		$content = get_post_meta( $post->ID,'excerpt', true);
		    		$editor = 'excerpt';
		    		$settings = array(
		    			'textarea_rows' => 10,
		    			'media_buttons' => false,
		    			);

		    		wp_editor( $content, $editor, $settings);

					?>
				</div>
			</div>
		</div>
		<?php
	}

	function post_meta_save( $post_id ){
		//checks save status

		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST['kommerce_post_nonce'] ) && wp_verify_nonce( $_POST['kommerce_post_nonce'], basename( __FILE__ ) ) ) ? 'true' : 'false';

		//Exit script depending on save status

		if ( $is_autosave || $is_revision || !$is_valid_nonce ){
			return;
		}
	    if ( isset( $_POST[ 'excerpt' ] ) ) {
			update_post_meta( $post_id, 'excerpt', sanitize_text_field($_POST[ 'excerpt' ] ) );
		}
	}

	add_action('save_post', 'post_meta_save');
