<?php

	extract( shortcode_atts( array(
		'before' => false,
		'display_as' => 'block',
		'custom_meta' => '',
		'acf_field_type' => '',
		'is_acf_field' => false
	), $atts ) );

	global $post, $authordata;

	$before = $before != false ? '<span>' . $before . '</span>' : null;
	$display_as = $display_as != null ? ' display-' . $display_as : null;

	$output = get_post_meta($post->ID, $custom_meta, true); ?>

	<?php if( !$is_acf_field ) : ?>
 
		<?php if ($output) : ?>

			<span class="vb-part custom-field-part<?php echo $display_as ?> custom-part">
			
				<?php echo $before ?><?php echo $output; ?>

			</span>

			<?php $content =  ob_get_clean(); ?>

		<?php endif; ?>

	<?php else : ?>

		<?php if ($output) : ?>

			<span class="vb-part custom-field-part<?php echo $display_as ?> custom-part custom-field-type-<?php echo $acf_field_type; ?>">

				<?php if( $acf_field_type == 'image' ) : ?>

					<?php $image = wp_get_attachment_image_src(get_field($custom_meta), 'full'); ?>
					<?php echo $before ?><img src="<?php echo $image[0] ?>" alt="<?php echo get_the_title(get_field($custom_meta)) ?>" />

				<?php else : ?>

					<?php echo $before ?><?php echo get_field($custom_meta); ?>

				<?php endif; ?>

			</span>

			<?php $content =  ob_get_clean(); ?>

		<?php endif; ?>

	<?php endif; ?>

