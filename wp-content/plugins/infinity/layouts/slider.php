<?php
/**
 * View Template: Slider
 *
 * Display as a slider
 *
 * @package View Builder
 * @since 0.2
 */

$infinity_options = views();
$view_name = strtolower(str_replace(' ', '-', views()->view_name));
$view_id = views()->id;
$style_name = $infinity_options->getOption( 'style-name-' . $view_id, 'boxed' );
$grid_spacing = $infinity_options->getOption( 'postopts-post-spacing-' . $view_id, '20' );

$slider_nav_thumb_height = $infinity_options->getOption( 'slider-nav-thumb-height' . $view_id, '36' );
$slider_nav_thumb_width = $infinity_options->getOption( 'slider-nav-thumb-width' . $view_id, '36' );
$slider_nav_type = $infinity_options->getOption( 'slider-nav-type' . $view_id, 'dots' );



?>

	<?php //echo content builder before zone ?>

	<?php if ( have_posts() ) : ?>

<div id="view-<?php echo $view_id; ?>" class="view-wrapper slider <?php echo $view_name; ?>-view <?php echo $style_name; ?>" data-view="<?php echo $view_name; ?>">

		<?php while( have_posts() ) : the_post(); ?>

			<?php views()->count++; ?>

			<article id="post-<?php the_ID(); ?>" class="article-<?php echo views()->count; ?> article item clearfix hentry" <?php echo display_slider_navigation($slider_nav_type, $slider_nav_thumb_width, $slider_nav_thumb_height, views()->count); ?>>

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

	<?php view_builder_assets()->slider_js( $view_id ); ?>
