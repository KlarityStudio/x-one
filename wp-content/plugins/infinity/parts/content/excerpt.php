<?php

	extract( shortcode_atts( array(
			'content_to_show' 	=> 'excerpt',
			'excerpt_length'		=> '140',
			'excerpt_more'			=> '...',
			'custom_class' => null,
			'display_as' => null
		), $atts ) );

	global $post;
	$id = $post->ID;

	$display_as = $display_as != null ? ' display-' . $display_as : null;
	$custom_class = $custom_class != null ? ' ' . $custom_class : null;
	$classes = $display_as . $custom_class;
	ob_start();

	if ( $content_to_show == 'excerpt' ) {

		echo '<div class="vb-part content-part entry-content' . $classes . '"><p>' . get_trimmed_excerpt($excerpt_length, $excerpt_more) . '</p></div>';

	} elseif ( $content_to_show == 'content' ) {

		echo '<div class="vb-part content-part entry-content' . $classes . '">' . get_formatted_content() . '</div>';

	}

	$content = ob_get_contents();

 	ob_end_clean();

?>
