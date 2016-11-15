<!-- <div  class="owl-carousel">

	<!-- <?php

	$carousel_cat = get_theme_mod('carousel_setting');
	$carousel_count = get_theme_mod('count_setting');

	$new_query = new WP_Query( array( 'cat' => $carousel_cat  , 'showposts' => $carousel_count ));
	while ( $new_query->have_posts() ) : $new_query->the_post(); ?>

	<li class="item">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'carousel-pic' ); ?></a>
		<h3> <?php the_title();?> </h3>
	</li>

	<?php
		endwhile;
	 	wp_reset_postdata();
	?>

</div> -->


<ul id="slider" class="owl-carousel">
	<li class="item">
		<div class="feature-image">
			<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/images/slider.png" alt="Feature Image" />
		</div>
		<?php if( is_front_page() ): ?>
		<div class="product-spec-wrapper">
			<div class="product-spec-lockup">
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Cleaning.png" alt="" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Cleaning.png" alt="" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Cleaning.png" alt="" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Cleaning.png" alt="" />
				</div>
			</div>
		</div>
	<?php endif;  ?>
	</li>
	<li class="item">
		<div class="feature-image">
			<img src="wp-content/themes/kommerce/_build/images/slider.png" alt="Feature Image" />
		</div>
		<?php if( is_front_page() ): ?>
		<div class="product-spec-wrapper">
			<div class="product-spec-lockup">
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Puncture.png" alt="" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Puncture.png" alt="" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Puncture.png" alt="" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Puncture.png" alt="" />
				</div>
			</div>
		</div>
	<?php endif;  ?>
	</li>
</ul>
