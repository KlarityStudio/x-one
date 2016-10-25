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
			elseif(is_page('shop-by-brands')) {
				get_template_part( 'includes/pages/page', 'shopBrand' );
			}
			else {
				get_template_part( 'includes/pages/page' );
			}
		endwhile;

	endif;

get_footer();
