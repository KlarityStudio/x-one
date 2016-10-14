<?php

class WOO_Product_Stock_Alert_Display_Form {

	public function __construct() {

	}

	/**
	 * Display Stock Alert Form
	 *
	 * @access public
	 * @param array $atts
	 * @return void
	 */
	public static function output( $attr ) {
		global $WOO_Product_Stock_Alert;
		$WOO_Product_Stock_Alert->nocache();

		do_action('woocommerce_product_stock_alert_form_before');

		$WOO_Product_Stock_Alert->frontend->get_alert_form();

		do_action('woocommerce_product_stock_alert_form_after');
	}
}


?>