<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kommerce
 */

get_header();

	if ( have_posts() ) :

		/* Start the Loop */

		while ( have_posts() ) : the_post();
			if( is_front_page() ){
          		get_template_part( 'includes/pages/page', 'home' );
			}
			elseif (is_singular() ) {
				if(is_page('shop-by-brands')) {
					get_template_part( 'includes/pages/page', 'shopBrand' );
				}
				if(is_page('faqs')) {
					get_template_part( 'includes/pages/page', 'faq' );
				}
				if (is_page('cart')){
					get_template_part( 'includes/pages/page' );
				}
				if (is_page('checkout')){
					get_template_part( 'includes/pages/page' );
				}
				if (is_page('my-account')){
					get_template_part( 'includes/pages/page' );
				}
				if (is_page('press-release')){
					get_template_part( 'includes/pages/page', 'press' );
				}
				if (is_page('privacy-policy')){
					get_template_part( 'includes/pages/page' );
				}
				if (is_page('terms-conditions')){
					get_template_part( 'includes/pages/page' );
				}
				if (is_page('refunds')){
					get_template_part( 'includes/pages/page' );
				}
				if (is_page('shipping')){
					get_template_part( 'includes/pages/page' );
				}
				else{
					if (is_page('contact')) {
						get_template_part('includes/pages/page', 'generic');
					}
				}

			}
		endwhile;

	endif;


get_footer();
