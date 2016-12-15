<?php
/**
 * View Template: Simple Masonry
 *
 * Display content in a Simple Masonry Layout
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


//filter settings
// $disable_filter = isset(views()->options['masonry-disable-filter']) ? views()->options['masonry-disable-filter'] : false;
// $filter_type = isset( views()->options['masonry-filter-type'] ) ? views()->options['masonry-filter-type'] : null;
$disable_filter = $infinity_options->getOption( 'masonry-disable-filter_' . $view_id, false);
$filter_type = $infinity_options->getOption( 'masonry-filter-type_' . $view_id, false);


if ( !$disable_filter ) {

	$taxonomy = $infinity_options->getOption( 'masonry-taxonomy_' . $view_id, 'post');
	$all_text = $infinity_options->getOption( 'masonry-alltext_' . $view_id, 'Show All');
	$child_of = $infinity_options->getOption( 'masonry-childof_' . $view_id, false);
	$exclude  = $infinity_options->getOption( 'masonry-exclude_' . $view_id, false);
	$include  = $infinity_options->getOption( 'masonry-include_' . $view_id, false);

	$taxonomies = array( $taxonomy );

	/* arguments to build nav query */
	$args = array ('taxonomy' => $taxonomy, 'child_of' => $child_of, 'exclude' => $exclude, 'include' => $include);
	/* query categories to build nav */
	$terms = get_terms( $taxonomies, $args );

}


$filter_before_text = $infinity_options->getOption( 'masonry-before-filter-text_' . $view_id, null);
$nav_position = $infinity_options->getOption( 'masonry-nav-position_' . $view_id, null);

?>
<style>
#view-<?php echo views()->id; ?> article { margin: <?php echo $grid_spacing; ?>px}
</style>

<div id="wrapper-<?php echo views()->id; ?>">

	<?php if ( !$disable_filter ) : ?>

		<?php if( $filter_type == 'buttons' ) : ?>

		<nav class="magnet-filter infinity-filter<?php echo $nav_position; ?>">

			<ul class="reset-list clearfix">

				<?php if( $filter_before_text ) : ?>
					<li class="before-filter"><?php echo $filter_before_text; ?></li>
				<?php endif; ?>

				<?php if( $all_text ) : ?>
				<li class="active"><a href="#" data-filter="*"><?php echo $all_text; ?></a></li>
				<?php endif; ?>

				<?php
					foreach ( $terms as $term ) {
						echo '<li><a href="#filter'. $term->name .'" data-filter="'. strtolower(str_replace (" ", "-", $term->name)) .'" data-termid="'. $term->term_taxonomy_id .'">' . $term->name . '</a></li>';
					}
				?>

			</ul>

		</nav>

		<?php endif; ?>

		<?php if( $filter_type == 'select' ) : ?>

		<div class="infinity-filter<?php echo $nav_position; ?>">
			<?php if( $filter_before_text ) : ?>
				<div class="before-filter"><?php echo $filter_before_text; ?></div>
			<?php endif; ?>
			<select id="size" name="filter by" class="magnet-filter">
			<option value="">View by...</option>
			<option value="all">All</option>
			<?php
				foreach($terms as $term){
					echo '<option value="' . strtolower(str_replace (" ", "-", $term->name)) . '" data-filter="' . strtolower(str_replace (" ", "-", $term->name)) . '">' . $term->name . '</option>';
				}
			 ?>
			</select>
		</div>

		<?php endif; ?>

	<?php endif; ?>

	<?php //echo content builder before zone ?>

	<?php if ( have_posts() ) : ?>

	<div id="view-<?php echo views()->id; ?>" class="view-wrapper magnet <?php echo $view_name; ?>-view <?php echo $style_name; ?>" data-view="<?php echo $view_name; ?>">

	<?php while( have_posts() ) : the_post(); ?>

		<?php views()->count++; ?>

		<article id="post-<?php the_ID(); ?>" class="article-<?php echo views()->count; ?> article magnet-item item clearfix hentry <?php echo tax_term_classes( $taxonomy ) ?>">

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

</div>

<?php

	$masonry_settings = $infinity_options->getOption( 'masonry-responsive-settings_' . $view_id );
	$responsive_js = '';

	/* Masonry Group  */
	if ( ! empty( $masonry_settings ) ) {

		$meta_query = array();

		$numItems = count( $masonry_settings );
		$i = 0;

		foreach ( $masonry_settings as $option ) {

			$width = $option['masonry-width'];
			$columns = $option['masonry-columns'];


			if(++$i === $numItems) {
				$responsive_js .= '['. $width .', '. $columns .']';
			} else {
				$responsive_js .= '['. $width .', '. $columns .'],';
			}

		}

	}

	//get customizer columns instead
	$columns = $infinity_options->getOption( 'postopts-columns-' . $view_id . '', '4' );
	$filter_animation = $infinity_options->getOption( 'masonry-filter-animation_' . $view_id, null);

	$infinite_scroll = $infinity_options->getOption( 'pagination-infinite-_' . $view_id, false);
	$infinite_scroll_effect = $infinity_options->getOption( 'pagination-infinite-effect-_' . $view_id, 'fade');

 ?>

<script>

	(function ($) {
		$(document).ready(function() {

	      var view = $('#view-<?php echo views()->id; ?>');
	      var wrapper = $('#wrapper-<?php echo views()->id; ?>');
			var article = $('#view-<?php echo views()->id; ?> article');
	      <?php if( $filter_type == 'select' ) : ?>

	      //initiate select filter
			filterSelect(wrapper);

			<?php endif; ?>

			//Initiate boxfish for layout
			initBoxfish(article, <?php echo $columns; ?>, <?php echo '['.$responsive_js.']'; ?>);

			//Initiate magnet
			initMagnet(wrapper, 900, '<?php echo $filter_animation ?>');

			<?php if( $infinite_scroll ) : ?>

			initInfiniteScroll(
				view,
				wrapper,
				<?php echo $columns; ?>,
				<?php echo '['.$responsive_js.']'; ?>,
				'<?php echo views()->plugin_url ?>images/loading.gif',
				'<?php echo $infinite_scroll_effect; ?>'
			);

			<?php endif; ?>

			<?php if ( ! empty( $masonry_settings ) ) : ?>

			addResizeEvent(function() {
				setTimeout(function(){
			      wrapper.magnet('refresh');
				}, 700);
			});

			<?php endif; ?>

		});
	})(jQuery);
</script>
