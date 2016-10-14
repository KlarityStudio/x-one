<?php
/**
 * @class AW_Admin_Controller_Logs
 * @since 2.5
 */

class AW_Admin_Controller_Logs extends AW_Admin_Controller_Abstract
{
	static function output()
	{
		switch ( self::get_current_route() )
		{
			case 'bulk_delete':
				self::action_bulk_edit( str_replace( 'bulk_', '', self::get_current_route() ) );
				self::output_list_table();
				break;

			default:
				self::output_list_table();
				break;
		}
	}


	/**
	 *
	 */
	private static function output_list_table()
	{
		include_once AW()->admin_path( '/report-list-table.php' );
		include_once AW()->admin_path( '/reports/logs.php' );

		$table = new AW_Report_Logs();
		$table->prepare_items();

		AW()->admin->get_view( 'page-logs', [
			'table' => $table
		]);
	}


	/**
	 *
	 */
	private static function verify_nonce()
	{
		$nonce = aw_clean( aw_request( '_wpnonce' ) );
		if ( ! wp_verify_nonce( $nonce, 'logs-action' ) ) wp_die( 'Security check failed.' );
	}


	/**
	 * @param $action
	 */
	private static function action_bulk_edit( $action )
	{
		self::verify_nonce();

		$ids = aw_clean( aw_request( 'log_ids' ) );

		if ( empty( $ids ) )
		{
			self::$errors[] = __('Please select some logs to bulk edit.', 'automatewoo');
			return;
		}

		foreach ( $ids as $id )
		{
			$log = AW()->get_log( $id );

			if ( ! $log )
				continue;

			switch ( $action )
			{
				case 'delete':
					$log->delete();
					break;
			}
		}

		self::$messages[] = __('Bulk edit completed.', 'automatewoo');
	}
}