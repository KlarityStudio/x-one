<?php
/**
 * View Template: Carousel
 *
 * Build your own layout
 *
 * @package View Builder
 * @since 1.0.0
 */

$infinity_options = views();
$view_name = strtolower(str_replace(' ', '-', views()->view_name));
$view_id = views()->id;
$style_name = $infinity_options->getOption( 'style-name-' . $view_id, 'boxed' );

?>

	<?php //echo content builder before zone ?>

	<?php if ( have_posts() ) : ?>

<div id="view-<?php echo $view_id; ?>" class="view-wrapper carousel <?php echo $view_name; ?>-view <?php echo $style_name; ?>" data-view="<?php echo $view_name; ?>">

		<?php while( have_posts() ) : the_post(); ?>

			<?php views()->count++; ?>

			<article id="post-<?php the_ID(); ?>" class="article-<?php echo views()->count; ?> article item clearfix hentry">

				<div class="article-inner">
					<?php View_Builder_Shortcodes::get_post_parts(); ?>
				</div>

			</article>

		<?php endwhile; ?>

		</div>


	<?php else : ?>

		<?php load_template( views()->plugin_dir . 'parts/layout/not-found.php' ); ?>

	<?php endif; ?>

	<?php load_template( views()->plugin_dir . 'parts/layout/pagination.php' ); ?>
	<?php //echo content builder before zone ?>

	<?php view_builder_assets()->carousel_js( $view_id ); ?>
