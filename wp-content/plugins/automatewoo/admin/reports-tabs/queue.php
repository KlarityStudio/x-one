<?php
/**
 * @class 		AW_Reports_Tab_Queue
 */

class AW_Reports_Tab_Queue extends AW_Admin_Reports_Tab_Abstract
{
	function __construct()
	{
		$this->id = 'queue';
		$this->name = __( 'Queue', 'automatewoo' );
	}

	/**
	 * @return object
	 */
	function get_report_class()
	{
		include_once AW()->admin_path( '/report-list-table.php' );
		include_once AW()->admin_path( '/reports/queue.php' );

		return new AW_Report_Queue();
	}


	/**
	 *
	 */
	function output_before_report()
	{
		$text = __( 'Queued events are checked for at 15 minute intervals so the actual run time may vary.', 'automatewoo' );
		return '<div class="automatewoo-info-box"><span class="dashicons dashicons-info"></span> ' . $text . '</div>';
	}



	/**
	 * @param $action
	 */
	function handle_actions( $action )
	{
		switch ( $action )
		{
			case 'run_now':

				AW_Admin_Controller_Reports::verify_nonce();

				$queued_event = AW()->get_queued_event( absint( aw_request( 'queued_event_id' ) ) );

				if ( ! $queued_event )
					return;

				if ( $queued_event->run() )
				{
					AW_Admin_Controller_Reports::$messages[] = __( 'Queued Event Run', 'automatewoo' );
				}
				else
				{
					AW_Admin_Controller_Reports::$errors[] = __( 'Queued event could not be run.', 'automatewoo');
				}

				break;


			case 'bulk_delete':

				AW_Admin_Controller_Reports::verify_nonce();

				$ids = aw_clean( aw_request( 'queued_event_ids' ) );

				if ( empty( $ids ) )
				{
					AW_Admin_Controller_Reports::$errors[] = __( 'Please select some queued events to bulk edit.', 'automatewoo');
					return;
				}

				foreach ( $ids as $id )
				{
					$queued_event = AW()->get_queued_event( $id );

					if ( ! $queued_event )
						continue;

					switch ( $action )
					{
						case 'bulk_delete':
							$queued_event->delete();
							break;
					}
				}

				AW_Admin_Controller_Reports::$messages[] = __( 'Bulk edit completed.', 'automatewoo');

				break;
		}
	}

}

return new AW_Reports_Tab_Queue();
