        <?php
    	global $post, $product;

        $count = 3;
    	$args = array(
    		'post_type' 				=> 'product',
    		'orderby'					=> 'post_date',
    		'order'						=> 'DEC',
    		'update_post_term_cache' 	=> false,
    		'pagination'				=> false,
            'posts_per_page' 			=> 3,
    	);

    	$latest_products = new WP_Query($args);
        $email =  get_post_meta($post->ID, 'email', true);
        ?>
        <ul class="shop-lockup">
            <li class="latest-info">
                <h2>Our Latest Products</h2>
                <div class="latest-product-blurb">
                    <p>
                        SEO text. Sound that is designed to bring you music the way the artists intended it – honest, clean and with passion.
                    </p>
                </div>
            </li>
            <?php
        	if( $latest_products->have_posts() ) :
        		while( $latest_products->have_posts() ) : $latest_products->the_post();
                    // $id = get_the_ID();
                    // $cats = wp_get_post_categories($id);
        		    // $term_list = wp_get_post_terms($post->ID,array($tax)); ?>
                   <li class="latest-product all <?php the_title();?>">
                        <a href="<?php the_permalink(); ?>">
                            <?php echo get_the_post_thumbnail(); ?>
    			  			<h2><?php the_title();?></h2>
                            <span><?php echo product_prices(); ?></span>
                        </a>
    				</li>
                <?php
        		endwhile;
        	endif;?>
        </ul>
    <?php wp_reset_postdata();
