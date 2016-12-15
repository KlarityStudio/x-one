<?php
/**
 * View Template: Slider Tabs
 *
 * Display posts in slider tabs
 *
 * @package View Builder
 * @since 0.2
 */

views()->count = -1;
$infinity_options = views();
$view_name = strtolower(str_replace(' ', '-', views()->view_name));
$view_id = views()->id;
$style_name = views()->get_infinity_option( 'style-name-' . $view_name . '', 'headway' );

$grid_spacing = $infinity_options->getOption( 'postopts-post-spacing-' . $view_id . '', '20');

?>

<style>

#view-<?php echo views()->id; ?> article { margin-bottom: <?php echo $grid_spacing; ?>px}

</style>



<div id="view-<?php echo views()->id; ?>" class="view-wrapper slider-tabs <?php echo $view_name; ?>-view <?php echo $style_name; ?> clearfix" data-view="<?php echo $view_name; ?>">

	<?php


	$title = '';
	$sub_title = '';//get from meta
	$image_src = '';//get from img src
	$image_width = '40';
	$image_width = $image_width ? ' width="' . $image_width . '"' : null;


	 ?>
	<!-- Tab Titles -->

		<ul>

			<?php if ( have_posts() ) : ?>

				<?php while( have_posts() ) : the_post(); ?>

					<li class="slide">

						<a href="#tab-<?php echo get_the_id(); ?>">

							<!-- <img src="<?php echo $image_src; ?>" <?php echo $image_width; ?> /> -->

							<span class="ui-slider-titles">
								<span class="ui-slider-title"><?php echo get_the_title()  ?></span>
								<!-- <span class="ui-slider-subtitle">SUBTITLE</span> -->
							</span>

						</a>

					</li>


				<?php endwhile; ?>

			<?php endif; ?>

		</ul>

	<!-- Tab Content -->

	<?php if ( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php views()->count++; ?>

			<div id="tab-<?php echo get_the_id(); ?>">

				<article id="post-<?php the_ID(); ?>" class="article-<?php echo views()->count; ?> article item clearfix">

					<div class="article-inner">
						<?php View_Builder_Shortcodes::get_post_parts(); ?>
					</div>

				</article>

			</div>

		<?php endwhile; ?>

	<?php else : ?>

		<?php load_template( views()->plugin_dir . 'parts/layout/not-found.php' ); ?>

	<?php endif; ?>

	<?php load_template( views()->plugin_dir . 'parts/layout/pagination.php' ); ?>

</div>

	<script>

		(function ($) {
			$(document).ready(function() {

				var slider = $("#view-<?php echo views()->id; ?>").sliderTabs();

			});
		})(jQuery);

	</script>
