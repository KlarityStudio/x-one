        <?php
    	global $post, $product;

        $count = 3;

    	$args = array(
    		'post_type' 				=> 'product',
    		'orderby'					=> 'title',
    		'order'						=> 'ASC',
    		'update_post_term_cache' 	=> false,
    		'pagination'				=> false,
            'posts_per_page' 			=> 3,
    	);

    	$latest_products = new WP_Query($args);?>
        <ul class="shop_lockup">
            <li>
                <h1>Our Latest Products</h1>
                <p>
                    SEO text. Sound that is designed to bring you music the way the artists intended it – honest, clean and with passion.
                </p>
            </li>
            <?php
        	if( $latest_products->have_posts() ) :
        		while( $latest_products->have_posts() ) : $latest_products->the_post();
        			$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600, 1000), false);
                    $id = get_the_ID();
                    $cats = wp_get_post_categories($id);
        		    $term_list = wp_get_post_terms($post->ID,array($tax)); ?>
                        <li>
        				    <a href="<?php the_permalink(); ?>"><li class="all <?php the_title();?>">
        				    	<div class="shop_icon" style="background: url(<?php echo $src[0]; ?>) no-repeat center"></div>
        			  			<p><?php the_title();?></p>
                                <p>
                                </p>
                            </a>
        				</li>
                <?php
        		endwhile;
        	endif;?>
        </ul>
    <?php wp_reset_postdata();
