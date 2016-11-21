<?php
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

$sidebar= new WP_Query($args);
?>
 <section class="section-faq">
     <?php the_title('<h1>', '</h1>'); ?>
    <div class="section-wrapper">
         <aside class="faq-sidebar">
             <ul>
             <?php
             if( $sidebar->have_posts() ) :
                 $data = 1;
                 while( $sidebar->have_posts() ) : $sidebar->the_post(); ?>
                 <li data-value="<?php echo $data; ?>"><?php the_title(); ?><span><?php get_template_part('_build/icons/icon', 'arrow'); ?></span></li>
             <?php
                $data++;
                endwhile;
             endif;
             wp_reset_postdata();
             die(); ?>
             ?>
             </ul>
         </aside>


 
