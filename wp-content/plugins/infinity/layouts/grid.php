<?php
/**
 * View Template: Grid
 *
 * Display content in a grid
 *
 * The "View Template:" bit above allows this to be selectable
 * from a dropdown menu on the edit loop screen.
 *
 * @package View Builder
 * @since 0.1
 */

$infinity_options = views();
$options = views()->options;
$view_name = strtolower(str_replace(' ', '-', views()->view_name));
$view_id = views()->id;
$style_name = $infinity_options->getOption( 'style-name-' . $view_id, 'boxed' );
$grid_spacing = $infinity_options->getOption( 'postopts-post-spacing-' . $view_id, '20' );
?>

<style>

#view-<?php echo $view_id; ?> article { margin: <?php echo $grid_spacing; ?>px}

</style>

<div id="wrapper-<?php echo $view_id; ?>">

	<div id="view-<?php echo $view_id; ?>" class="filter-content view-wrapper grid <?php echo $view_name; ?>-view <?php echo $style_name; ?>" data-view="<?php echo $view_name; ?>">

		<?php if ( have_posts() ) : ?>

			<?php while( have_posts() ) : the_post(); ?>

				<?php views()->count++; ?>

				<article id="post-<?php the_ID(); ?>" class="article-<?php echo views()->count; ?> article item clearfix hentry">

					<div class="article-inner">
						<?php View_Builder_Shortcodes::get_post_parts(); ?>
					</div>

				</article>

			<?php endwhile; ?>

		<?php else : ?>

			<?php load_template( views()->plugin_dir . 'parts/layout/not-found.php', false ); ?>

		<?php endif; ?>

		<?php load_template( views()->plugin_dir . 'parts/layout/pagination.php', false ); ?>

	</div>

</div>

<?php

	$responsive_js = null;
	$grid_settings = $infinity_options->getOption( 'grid-responsive-settings_' . $view_id );

	/* Carousel Group  */
	if ( ! empty( $grid_settings ) ) {

		$numItems = count( $grid_settings );
		$i = 0;

		foreach ( $grid_settings as $option ) {

			$width = $option['grid-width'];
			$columns = $option['grid-columns'];

			if(++$i === $numItems) {
				$responsive_js .= '['. $width .', '. $columns .']';
			} else {
				$responsive_js .= '['. $width .', '. $columns .'],';
			}

		}

	}

	//get customizer columns instead
	$columns = $infinity_options->getOption( 'postopts-columns-' . $view_id, '4' );
	$infinite_scroll = $infinity_options->getOption( 'pagination-infinite-' . $view_id );
	$infinite_scroll_effect = $infinity_options->getOption( 'pagination-infinite-effect-' . $view_id );

 ?>
<script>

	(function ($) {

    var view = $('#view-<?php echo $view_id; ?>');
    var wrapper = $('#wrapper-<?php echo $view_id; ?>');
		var article = $('#view-<?php echo $view_id; ?> article');

		initBoxfish(article, <?php echo $columns; ?>, <?php echo '['.$responsive_js.']'; ?>);

      <?php if( $infinite_scroll ) : ?>

		initInfiniteScroll(
			view,
			wrapper,
			<?php echo $columns; ?>,
			<?php echo '['.$responsive_js.']'; ?>,
			'<?php echo views()->plugin_url ?>images/loading.gif'
		);

		<?php endif; ?>

	})(jQuery);

</script>
