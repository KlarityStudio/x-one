<?php

    //Page Slug Body class
    function add_slug( $classes ){
        global $post;
        if ( isset( $post ) ){
            $classes[] = $post->post_type . '-' . $post->post_name;
        }
       return $classes;
    }
    add_filter('body_class' , 'add_slug' );
