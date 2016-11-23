    </main>
    <footer>
        <div class="copyright">
             <p>&copy; <?php echo date('Y');?> <?php echo get_bloginfo( 'name' );  ?></p>
        </div>
        <?php get_template_part('includes/modules/module', 'footerNav'); ?>
        <?php  wp_footer(); ?>  
    </footer>

  </body>
</html>
