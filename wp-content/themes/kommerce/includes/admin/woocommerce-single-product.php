<?php

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

    add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

    add_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
    add_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
    add_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );

    add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
    add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

    // woocommerce_single_product_summary hook.
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 5 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 10 );
    add_action( 'woocommerce_single_product_summary', 'xone_delivery_text', 12 );

    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );


    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 5 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

    /**
     * After Single Products Summary Div.
     *
     * @see woocommerce_output_product_data_tabs()
     * @see woocommerce_upsell_display()
     * @see woocommerce_output_related_products()
     */


    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

    function xone_delivery_text(){ ?>
      		<p class="product-delivery" ><strong>Free Delivery</strong> on all orders! (Expect 3 - 5 days for delivery)</p>  
   <?php  }
 ?>
