    </main>
    <footer>
        <div class="footer-widgets">
            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
            <div class="footer-widget">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
            <div class="footer-widget">
                <?php dynamic_sidebar( 'footer-2' ); ?>
            </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
            <div class="footer-widget">
                <?php dynamic_sidebar( 'footer-3' ); ?>
            </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
            <div class="footer-widget">
                <?php dynamic_sidebar( 'footer-4' ); ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="copyright">
             <p>&copy; <?php echo date('Y');?> <?php echo get_bloginfo( 'name' );  ?> - All images and content belongs to x-one and is subject to copyright laws.</p>
        </div>
      </footer>
    </div>
    <?php  wp_footer(); ?>
  </body>
</html>
