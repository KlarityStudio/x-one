<?php
/**
 * @package		AutomateWoo/Admin/Views
 *
 * @var $table AW_Report_Logs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="wrap automatewoo-logs-page">

	<h1><?php _e( 'Logs', 'automatewoo' ) ?></h1>

	<?php AW_Admin_Controller_Logs::output_messages(); ?>

	<div id="poststuff" class="woocommerce-reports-wide">
		<?php $table->display(); ?>
	</div>

</div>

