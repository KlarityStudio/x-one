<?php
/**
 * @class 		AW_Reports_Tab_Guests
 */

class AW_Reports_Tab_Guests extends AW_Admin_Reports_Tab_Abstract
{
	function __construct()
	{
		$this->id = 'guests';
		$this->name = __( 'Guests', 'automatewoo' );
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

				$ids = aw_clean( aw_request( 'guest_ids' ) );

				if ( empty( $ids ) )
				{
					AW_Admin_Controller_Reports::$errors[] = __( 'Please select some guests to bulk edit.', 'automatewoo');
					return;
				}

				foreach ( $ids as $id )
				{
					$guest = AW()->get_guest( $id );

					if ( ! $guest )
						continue;

					switch ( $action )
					{
						case 'bulk_delete':
							$guest->delete();
							break;
					}
				}

				AW_Admin_Controller_Reports::$messages[] = __( 'Bulk edit completed.', 'automatewoo');

				break;
		}
	}


	/**
	 * @return object
	 */
	function get_report_class()
	{
		include_once AW()->admin_path( '/report-list-table.php' );
		include_once AW()->admin_path( '/reports/guests.php' );

		return new AW_Report_Guests();
	}
}

return new AW_Reports_Tab_Guests();
