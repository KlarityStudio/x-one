<?php

/**
 * Admin class
 *
 * @package View_Builder
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'View_Builder_Assets' ) ) :
class View_Builder_Assets {

	/**
	 * @var View_Builder_Assets Stores the instance of this class.
	 */
	private static $instance;

	private static $general_css;

	private static $images_css;

	/**
	 * View_Builder_Assets Instance
	 *
	 * Makes sure that there is only ever one instance of the HW Builder
	 *
	 * @since 1.0.0
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) ) {

			self::$instance = new View_Builder_Assets;
			self::$instance->init();

		}

		return self::$instance;

   }

	/**
	* A dummy constructor to prevent loading more than once.
	* @since 	1.0.0
 	* @see 	View_Builder_Assets::instance()
	*/
	private function __construct() {
		// Do nothing here
	}

	/**
	 * A dummy magic method to prevent View_Builder_Assets from being cloned
	 */
	public function __clone() { wp_die( __( 'Cheatinâ€™ uh?' ) ); }

	/**
	 * A dummy magic method to prevent View_Builder_Assets from being unserialized
	 */
	public function __wakeup() { wp_die( __( 'Cheatinâ€™ uh?' ) ); }

	/**
	 * Admin Setup
	 *
	 * @package View_Builder
	 * @since 1.0.0
	 */
	public static function init() {

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ) );

	}

	public static function enqueue() {

		wp_enqueue_script('vb-carousel', views()->plugin_url . 'layouts/assets/js/min/owl.carousel-min.js', array('jquery'), views()->version, 1);

		wp_enqueue_script('vb-images', views()->plugin_url . 'layouts/assets/js/images.js', array('jquery'), views()->version, 1);
		
	}

	function carousel_js( $view_id ) {

		$infinity_options = views();

		$carousel_js = $infinity_options->getSerializedOption( 'carousel-js-' . $view_id, null, 'infinity_options_view_'.$view_id );

	?>

	<script>

	(function ($) {
			$(document).ready(function() {

				$("#view-<?php echo $view_id; ?>.carousel").owlCarousel({

						<?php echo $carousel_js; ?>

				});
			});

	})(jQuery);

	</script>

	<?php
	}

}
endif;

/**
 * Initiate assets
 *
 * @package View_Builder
 * @since 1.0.0
 */
function view_builder_assets() {
	return View_Builder_Assets::instance();
}
add_action ( 'plugins_loaded', 'view_builder_assets' );
