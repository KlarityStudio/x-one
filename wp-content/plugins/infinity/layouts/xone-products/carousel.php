<?php
/**
 * View Template: Carousel
 *
 * Build your own layout
 *
 * @package View Builder
 * @since 1.0.0
 */

 $view_id = views()->id;
 $style_name = $infinity_options->getOption( 'style-name-' . $view_id, 'boxed' );

$query = vb_loop_query( $view_id );

?>

	<?php //echo content builder before zone ?>

	<?php if ( $query->have_posts() ) : ?>

		<div id="view" class="product-view">

		<?php while( $query->have_posts() ) : $query->the_post(); ?>

			<?php views()->count++; ?>

			<article id="post-<?php the_ID(); ?>" class="article-<?php echo views()->count; ?> article item clearfix hentry">

				<div class="article-inner">
					<?php echo do_shortcode('[vb_categories]'); ?>
					<?php echo do_shortcode('[vb_title]'); ?>
					<?php echo do_shortcode('[vb_image thumbnail_width="500" thumbnail_height="500" thumb_cover_type="flip"]'); ?>
					<?php echo do_shortcode('[vb_wc_add_to_cart]'); ?>
				</div>

			</article>

		<?php endwhile; ?>

		</div>


	<?php else : ?>

		<?php load_template( views()->plugin_dir . 'parts/layout/not-found.php' ); ?>

	<?php endif; ?>

	<?php //load_template( views()->plugin_dir . 'parts/layout/pagination.php' ); ?>
	<?php //echo content builder before zone ?>

	<?php view_builder_assets()->carousel_js( $view_id ); ?>
