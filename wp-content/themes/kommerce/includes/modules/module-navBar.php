<nav role="navigation">
  <div class="logo">
    <?php the_custom_logo();?>
  </div>
  <?php wp_nav_menu(array('theme_location'=>'primary')); ?>
  <?php get_template_part('includes/modules/module', 'cart'); ?>
</nav>
