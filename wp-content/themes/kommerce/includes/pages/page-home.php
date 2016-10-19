<section class="home-content">
  <?php
  if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
  <aside class="sidebar">
    <ul id="sidebar">
      <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </ul>
  </aside>
  <?php endif; ?>
  <article class="">
    <?php the_title('<h1>', '</h1>'); ?>
    <?php the_content(); ?>
  </article>
</section>
