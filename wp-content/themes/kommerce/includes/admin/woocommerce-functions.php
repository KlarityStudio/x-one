<?php
/**
* Ensure cart contents update when products are added to the cart via AJAX
*/

    function my_header_add_to_cart_fragment( $fragments ) {

      ob_start();
      $count = WC()->cart->cart_contents_count;
      ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
      if ( $count > 0 ) {
          ?>
          <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
          <?php
      }
          ?></a><?php

      $fragments['a.cart-contents'] = ob_get_clean();

      return $fragments;
    }
    add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );


    function product_prices( ) {

      global $product;
      //get the sale price of the product whether it be simple, grouped or variable
      $sale_price = get_post_meta( get_the_ID(), '_price', true);

      //get the regular price of the product, but of a simple product
      $regular_price = get_post_meta( get_the_ID(), '_regular_price', true);

      //oh, the product is variable to $sale_price is empty? Lets get a variation price
      if (!empty($sale_price)) {

          if ($regular_price == ""){
          #Step 1: Get product varations
          $available_variations = $product->get_available_variations();

          #Step 2: Get product variation id
          $variation_id=$available_variations[0]['variation_id']; // Getting the variable id of just the 1st product. You can loop $available_variations to get info about each variation.

          #Step 3: Create the variable product object
          $variable_product1= new WC_Product_Variation( $variation_id );

          #Step 4: You have the data. Have fun :)
          $regular_price = $variable_product1 ->regular_price;
          }

          return "R" . $sale_price . " - " . "R" . $regular_price;
      }
    }

    add_action( 'wp_enqueue_scripts', 'wcqi_enqueue_polyfill' );
    function wcqi_enqueue_polyfill() {
      wp_enqueue_script( 'wcqi-number-polyfill' );
    }

    function cloudways_product_subcategories( $args = array() ) {
        $parentid = get_queried_object_id();

        $args = array(
            'parent' => $parentid
        );

        $terms = get_terms( 'product_cat', $args );

        if ( $terms ) {

            echo '<ul class="product-cats">';

                foreach ( $terms as $term ) {

                    echo '<li class="category">';

                        woocommerce_subcategory_thumbnail( $term );

                        echo '<h2>';
                            echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
                                echo $term->name;
                            echo '</a>';
                        echo '</h2>';

                    echo '</li>';


            }

            echo '</ul>';

        }

    }


    function custom_override_checkout_fields( $fields ) {
          unset($fields['billing']['billing_company']);
          unset($fields['billing']['billing_address_2']);
          unset($fields['shipping']['shipping_company']);


         return $fields;
    }
    add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );



    function hjs_wc_checkout_fields( $fields ) {

        $fields['billing']['billing_postcode']['label'] = 'Postalcode';
        $fields['shipping']['shipping_address_2']['placeholder'] = 'Apartment, suite, unit (optional)';

        return $fields;
    }
    add_filter( 'woocommerce_checkout_fields' , 'hjs_wc_checkout_fields' );

    function productSlider($cat){
        global $post;

            $count = -1;
            $args = array(
                'post_type' 				=> 'product',
                'order_by'					=> 'menu_order',
                'order'					    => 'DEC',
                'update_post_term_cache' 	=> false,
                'posts_per_page' 			=> $count,
                'pagination'				=> false,
                'tax_query'                 => array(
                    array(
                        'taxonomy'          => 'product_cat',
                        'field'             => 'slug',
                        'terms'              => $cat,
                    ),
                ),
            );

        $prod= new WP_Query($args);
     ?>
         <?php
         if( $prod->have_posts() ) :

         ?>
            <ul id="owl-product-carousel-<?php echo $cat ?>" class="products owl-product-carousel">

             <?php while( $prod->have_posts() ) : $prod->the_post(); ?>
                 <li class="product item" >
                     <a class="product-wrapper" href="<?php the_permalink(); ?>">
                         <?php
                     	do_action( 'woocommerce_before_shop_loop_item_title' );
                        do_action( 'woocommerce_shop_loop_item_title' );

                     	/**
                     	 * woocommerce_after_shop_loop_item_title hook.
                     	 *
                     	 * @hooked woocommerce_template_loop_rating - 5
                     	 * @hooked woocommerce_template_loop_price - 10
                     	 */
                     	do_action( 'woocommerce_after_shop_loop_item_title' );

                     	/**
                     	 * woocommerce_after_shop_loop_item hook.
                     	 *
                     	 * @hooked woocommerce_template_loop_product_link_close - 5
                     	 * @hooked woocommerce_template_loop_add_to_cart - 10
                     	 */
                     	do_action( 'woocommerce_after_shop_loop_item' );

                          ?>
                     </a>
                 </li>

            <?php endwhile; ?>
            </ul>
         <?php endif;

         wp_reset_query();

    }
