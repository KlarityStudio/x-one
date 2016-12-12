<nav role="navigation">
  <div class="logo">
    <?php the_custom_logo();?>
  </div>
    <div id="nav-toggle">
        <span></span>
    </div>
  <div class="menu-container">
      <?php wp_nav_menu(array('theme_location'=>'primary')); ?>
      <div class="shopping-cart cart-menu">
          <div class="cart-count">

            <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

                $count = WC()->cart->cart_contents_count;
                get_template_part('_build/icons/icon', 'cart');
                ?>
                <!-- <?php get_template_part('_build/icons/icon', 'shoppingCircle'); ?> -->
                <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php

                if ( $count > 0 ) {
                  ?>
                  <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
                  <?php
                }
                  ?></a>

            <?php } ?>
            <ul>
                <li><a href="<?php echo site_url('/cart') ?>">Cart</a></li>
                <li><a href="<?php echo site_url('/checkout') ?>">Checkout</a></li>
            </ul>
          </div>
      </div>
  </div>
</nav>
