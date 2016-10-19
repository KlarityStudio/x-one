<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package web2feel_demo
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-md-12"> 
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'web2feel_demo' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'web2feel_demo' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'web2feel_demo' ), 'web2feel_demo', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); ?>
		</div><!-- .site-info -->
		</div>	
	</footer><!-- #colophon -->

</div><!-- #page -->
</div></div>	
<?php wp_footer(); ?>

</body>
</html>
