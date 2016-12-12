<?php
    do_action( 'woocommerce_before_main_content' );
    global $post;
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        $count = -1;
        $args = array(
            'post_type' 				=> 'post',
            'order_by'					=> 'menu_order',
            'order'					    => 'DEC',
            'update_post_term_cache' 	=> false,
            'posts_per_page' 			=> $count,
            'pagination'				=> false,
            'paged'					    => $paged,
            );

    $pressRelease= new WP_Query($args); ?>
    <div class="loading-gif">
        <center>
            <img class="loading-image" src="/wp-content/themes/kommerce/_build/icons/ajax-loader.gif" alt="loading..">
        </center>
    </div>
    <section class="section-press-release">
        <?php the_title('<h1>', '</h1>'); ?>
        <div class="section-wrapper">
            <div class="tag-filter" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
                <?php get_template_part('includes/modules/module', 'tagsList'); ?>
            </div>
            <?php
            if( $pressRelease->have_posts() ) :
                $data = 1;
                while( $pressRelease->have_posts() ) : $pressRelease->the_post(); ?>
                <article data-value="<?php echo $data; ?>" data-post="<?php echo $post->ID; ?>">
                    <script type="application/ld+json">
    					{
    					  "@context": "http://schema.org",
    					  "@type": "NewsArticle",
    					  "mainEntityOfPage": {
    					    "@type": "WebPage",
    					    "@id": "<?php echo the_permalink(); ?>"
    					  },
    					  "headline": "<?php the_title(); ?>",
    					  "image": {
    					    "@type": "ImageObject",
    					    "url": "<?php the_post_thumbnail_url(); ?>",
    					    "height": 800,
    					    "width": 800
    					  },
    					  "datePublished": "<?php echo the_date(); ?>",
    					  "dateModified": "<?php echo the_modified_date(); ?>",
    					  "author": {
    					    "@type": "Person",
    					    "name": "<?php the_author(); ?>"
    					  },
    					   "publisher": {
    					    "@type": "Organization",
    					    "name": "X-One",
    					    "logo": {
    					      "@type": "ImageObject",
    						  "url": "<?php echo get_site_url() . '/wp-content/uploads/2016/10/cropped-logo.png'?>",
    					      "width": 600,
    					      "height": 60
    					    }
    					  },
    					  "description": "<?php echo the_excerpt(); ?>"
    					}
    					</script>
                    <div class="featured-image">
                        <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
                        <div style="background-image:url(<?php echo $thumb[0]; ?>)">

                        </div>
                    </div>
                    <div class="article-content">
                        <div class="article-meta">
                            <p><span><?php the_author() ?></span> / <?php echo get_the_date(); ?></p>
                        </div>
                        <?php the_title('<h1>', '</h1>'); ?>
                        <div class="post-tags">
                            <?php the_tags('<ul><li>', '</li><li>', '</li></ul>'); ?>
                        </div>
                        <p>
                            <?php the_excerpt(); ?>
                        </p>
                        <div class="post-footer">
                            <div class="read-more-button">
                                <a id="read-more" href="#" data-post="<?php echo $post->ID; ?>" data-url="<?php echo admin_url('admin-ajax.php'); ?>">Read More</a>
                            </div>
                            <span class="divider"></span>
                            <div class="social-wrapper">
                                <div class="social-container">
                                    <?php get_template_part('includes/modules/module', 'socialShare'); ?>
                                </div>
                                <div class="social-link">
                                    <a href="#"><?php get_template_part('_build/icons/icon', 'share'); ?> Share</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
             <?php
                $data++;
                endwhile;
             endif;

             wp_reset_postdata(); ?>
            </div>
        </div>
        <div class="modal-wrapper">

        </div>
    </section>
