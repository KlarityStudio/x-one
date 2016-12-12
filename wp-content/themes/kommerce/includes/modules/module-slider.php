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
			<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/images/armor-x-one.png" alt="Feature Image" />
		</div>
		<div class="product-spec-wrapper">
			<div class="product-spec-lockup">
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Ultimate-Shock-Absorption.png" alt="Ultimate Shock Absorption" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Puncture.png" alt="Puncture Protection" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Scratch.png" alt="5H+ Scratch Resistance" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Eye-Protection.png" alt="Eye Protection" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Responsive.png" alt="Responsive Smooth Touch" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Cleaning.png" alt="Easy Cleaning" />
				</div>
			</div>
		</div>
	</li>
	<li class="item">
		<div class="feature-image">
			<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/images/extreme-shock.png" alt="Feature Image" />
		</div>
		<div class="product-spec-wrapper">
			<div class="product-spec-lockup">
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Responsive.png" alt="Responsive Smooth Touch" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Ultimate-Shock-Absorption.png" alt="Ultimate Shock Absorption" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Scratch.png" alt="5H+ Scratch Resistance" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Fingerprint.png" alt="Anti Fingerprint" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Puncture.png" alt="Puncture Protection" />
				</div>
			</div>
		</div>
	</li>
	<li class="item">
		<div class="feature-image">
			<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/images/ultra-clear.png" alt="Feature Image" />
		</div>
		<div class="product-spec-wrapper">
			<div class="product-spec-lockup">
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Scratch.png" alt="5H+ Scratch Resistance" />
				</div>
				<div class="product-spec">
					<img src="<?php echo site_url(); ?>/wp-content/themes/kommerce/_build/icons/Cleaning.png" alt="Easy Cleaning" />
				</div>
			</div>
		</div>
	</li>
</ul>
