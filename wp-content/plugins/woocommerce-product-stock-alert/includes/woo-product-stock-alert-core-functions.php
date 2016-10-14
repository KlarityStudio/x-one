<?php

if(!function_exists('woocommerce_inactive_notice')) {
  function woocommerce_inactive_notice() {
    ?>
    <div id="message" class="error">
      <p><?php printf( __( '%sWoocommerce Product Stock Alert is inactive.%s The %sWooCommerce plugin%s must be active for the Woocommerce Product Stock Alert to work. Please %sinstall & activate WooCommerce%s', WCS_TEXT_DOMAIN ), '<strong>', '</strong>', '<a target="_blank" href="http://wordpress.org/extend/plugins/woocommerce/">', '</a>', '<a href="' . admin_url( 'plugins.php' ) . '">', '&nbsp;&raquo;</a>' ); ?></p>
    </div>
		<?php
  }
}

if(!function_exists('get_dc_plugin_settings')) {
	function get_dc_plugin_settings() {
		$dc_plugin_settings = array();
		$dc_plugin_settings = get_option( 'dc_woo_product_stock_alert_general_settings_name' );
		if( isset($dc_plugin_settings) && !empty($dc_plugin_settings) ) {
			return $dc_plugin_settings;
		}
		return array();
	}
}

/**
* Write to log file
*/
if(!function_exists('doWooStockAlertLOG')) {
	function doWooStockAlertLOG($str) {
		$file = plugin_dir_path( __FILE__ ) .'stock_alert_log.log';
		if(file_exists($file)) {
			// Open the file to get existing content
			$current = file_get_contents($file);
			// Append a new content to the file
			$current .= "$str" . "\r\n";
			$current .= "-------------------------------------\r\n";
		} else {
			$current = "$str" . "\r\n";
			$current .= "-------------------------------------\r\n";
		}
		// Write the contents back to the file
		file_put_contents($file, $current);
	}
}

?>
