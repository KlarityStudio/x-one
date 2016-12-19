<?php
    do_action( 'woocommerce_before_main_content' );
    global $post;
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        $count = -1;
        $args = array(
            'post_type' 				=> 'faq',
            'order_by'					=> 'menu_order',
            'order'					=> 'DEC',
            'update_post_term_cache' 	=> false,
            'posts_per_page' 			=> $count,
            'pagination'				=> false,
            'paged'					=> $paged,
            );

    $faq= new WP_Query($args);
 ?>
     <section class="section-faq">
         <?php the_title('<h1>', '</h1>'); ?>
        <div class="section-wrapper">
             <aside class="faq-sidebar">
                 <ul>
                 <?php
                 if( $faq->have_posts() ) :
                     $data = 1;
                     while( $faq->have_posts() ) : $faq->the_post(); ?>
                     <li data-value="<?php echo $data; ?>"><div><?php the_title(); ?></div><div class="icon-arrow" ><?php get_template_part('_build/icons/icon', 'arrow'); ?></div></li>
                 <?php
                    $data++;
                    endwhile;
                 endif;
                 wp_reset_query();
                 ?>
                 </ul>
             </aside>

            <div class="article-container">
                <?php
                if( $faq->have_posts() ) :
                    $data = 1;
                    while( $faq->have_posts() ) : $faq->the_post(); ?>
                    <article data-value="<?php echo $data; ?>">
                        <div>
                            <h2><?php the_title(); ?></h2>
                            <p>
                                <?php the_content(); ?>
                            </p>
                        </div>
                    </article>
                 <?php
                    $data++;
                    endwhile;
                 endif;

                 wp_reset_postdata();
             ?>
            </div>
        </div>
    </section>
