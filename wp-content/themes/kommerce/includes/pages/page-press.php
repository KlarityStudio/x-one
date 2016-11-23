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

    <section class="section-press-release">
        <?php the_title('<h1>', '</h1>'); ?>
        <div class="section-wrapper">
            <div class="tag-filter">
                <?php get_template_part('includes/modules/module', 'tagsList'); ?>
            </div>
            <?php
            if( $pressRelease->have_posts() ) :
                $data = 1;
                while( $pressRelease->have_posts() ) : $pressRelease->the_post(); ?>
                <article data-value="<?php echo $data; ?>" data-post="<?php echo $post->ID; ?>">
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
                        <p>
                            <?php the_excerpt(); ?>
                        </p>
                        <div class="post-tags">
                            <?php the_tags('<ul><li>', '</li><li>', '</li></ul>'); ?>
                        </div>
                        <div class="post-footer">
                            <a id="read-more" href="#" data-post="<?php echo $post->ID; ?>" data-url="<?php echo admin_url('admin-ajax.php'); ?>">Read More</a>
                            <div class="article-social">
                                <?php get_template_part('includes/modules/module', 'postFooter'); ?>
                                <?php echo getPostLikeLink($post->ID); ?>
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
