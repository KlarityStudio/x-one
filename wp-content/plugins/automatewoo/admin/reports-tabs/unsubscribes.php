<?php
/**
 * @class 		AW_Reports_Tab_Unsubscribes
 */

class AW_Reports_Tab_Unsubscribes extends AW_Admin_Reports_Tab_Abstract
{
	function __construct()
	{
		$this->id = 'unsubscribes';
		$this->name = __( 'Unsubscribes', 'automatewoo' );
	}

	/**
	 * @return object
	 */
	function get_report_class()
	{
		include_once AW()->admin_path( '/report-list-table.php' );
		include_once AW()->admin_path( '/reports/unsubscribes.php' );

		return new AW_Report_Unsubscribes();
	}
}

return new AW_Reports_Tab_Unsubscribes();