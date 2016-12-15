<?php
/**
 * View Template: Blog
 *
 * Display a post title and excerpt
 *
 * @package View Builder
 * @since 0.2
 */

views()->count = -1;
$infinity_options = views();
$view_name = strtolower(str_replace(' ', '-', views()->view_name));
$view_id = views()->id;
$style_name = $infinity_options->getOption( 'style-name-' . $view_id, 'boxed' );
$grid_spacing = $infinity_options->getOption( 'postopts-post-spacing-' . $view_id, '20' );
?>

<style>
/* TODO: move spacing to dynamic_css */
#view-<?php echo $view_id; ?> article { margin-bottom: <?php echo $grid_spacing; ?>px}
</style>

<div id="view-<?php echo views()->id; ?>" class="view-wrapper blog <?php echo $view_name; ?>-view <?php echo $style_name; ?> clearfix" data-view="<?php echo $view_name; ?>">

	<?php //echo content builder before zone ?>

	<?php if ( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php views()->count++; ?>

			<article id="post-<?php the_ID(); ?>" class="article-<?php echo views()->count; ?> article item clearfix">

				<div class="article-inner">
					<?php View_Builder_Shortcodes::get_post_parts(); ?>
				</div>

			</article>

		<?php endwhile; ?>

	<?php else : ?>

		<?php load_template( views()->plugin_dir . 'parts/layout/not-found.php' ); ?>

	<?php endif; ?>

	<?php load_template( views()->plugin_dir . 'parts/layout/pagination.php' ); ?>

</div>


<?php
$infinite_scroll = $infinity_options->getOption( 'pagination-infinite-' . $view_id );
if($infinite_scroll) : ?>

	<script>

		(function ($) {

	      var view = $('#view-<?php echo $view_id; ?>');
	      var wrapper = $('#wrapper-<?php echo $view_id; ?>');
				var article = $('#view-<?php echo $view_id; ?> article');

	      view.infinitescroll({ // .magnet  contains items
		        loading: {
		            msgText: "<em>Loading the next set of posts...</em>",
		            img: '<?php echo views()->plugin_url ?>images/loading.gif',
		        },
		        navSelector: '#pagenav',
		        nextSelector: '#pagenav a',
		        itemSelector: '.item'
		    });

		})(jQuery);

	</script>

<?php endif; ?>
