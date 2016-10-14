<?php

class WOO_Product_Stock_Alert_Export {
	
	public function __construct() {
		
		$this->export_stock_alert_data();
	}
	
	function export_stock_alert_data() {
		global $WOO_Product_Stock_Alert;
	
		?>
			<div class="wrap">
				<h1><?php _e('WC Stock Alert Export', $WOO_Product_Stock_Alert->text_domain) ?></h1>
				<p><?php _e('When you click the button below, this will export all out of stock products with subscribers email.', $WOO_Product_Stock_Alert->text_domain) ?></p>
				<button class="wc_stock_alert_export_data button-primary"><?php _e('Export CSV', $WOO_Product_Stock_Alert->text_domain) ?></button>
			</div>
		<?php
	}
}

?>
