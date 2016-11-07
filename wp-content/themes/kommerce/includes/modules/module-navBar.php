<nav role="navigation">
  <div class="logo">
    <?php the_custom_logo();?>
  </div>
  <?php wp_nav_menu(array('theme_location'=>'primary')); ?>
  <div class="shopping-cart cart-menu">
      <?php get_template_part('includes/modules/module', 'cart'); ?>
      <ul>
          <li><a href="<?php echo site_url('/cart') ?>">Cart</a></li>
          <li><a href="<?php echo site_url('/checkout') ?>">Checkout</a></li>
      </ul>
  </div>
</nav>
