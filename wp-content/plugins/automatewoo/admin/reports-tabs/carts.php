<?php
/**
 * @class 		AW_Reports_Tab_Carts
 */

class AW_Reports_Tab_Carts extends AW_Admin_Reports_Tab_Abstract
{
	function __construct()
	{
		$this->id = 'carts';
		$this->name = __( 'Active Carts', 'automatewoo' );
	}


	/**
	 * @return object
	 */
	function get_report_class()
	{
		include_once AW()->admin_path( '/report-list-table.php' );
		include_once AW()->admin_path( '/reports/carts.php' );

		return new AW_Report_Carts();
	}


	/**
	 * @param $action
	 */
	function handle_actions( $action )
	{
		switch ( $action )
		{
			case 'bulk_delete':

				AW_Admin_Controller_Reports::verify_nonce();

				$ids = aw_clean( aw_request( 'cart_ids' ) );

				if ( empty( $ids ) )
				{
					AW_Admin_Controller_Reports::$errors[] = __( 'Please select some carts to bulk edit.', 'automatewoo');
					return;
				}

				foreach ( $ids as $id )
				{
					$cart = AW()->get_cart( $id );

					if ( ! $cart )
						continue;

					switch ( $action )
					{
						case 'bulk_delete':
							$cart->delete();
							break;
					}
				}

				AW_Admin_Controller_Reports::$messages[] = __('Bulk edit completed.', 'automatewoo');

				break;
		}


	}


}

return new AW_Reports_Tab_Carts();