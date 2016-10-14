<?php
/**
 * @class 		AW_Tool_Manual_Orders_Trigger
 * @since		2.5
 */

class AW_Tool_Manual_Orders_Trigger extends AW_Tool
{
	public $id = 'manual_orders_trigger';

	/**
	 * Constructor
	 */
	function __construct()
	{
		$this->title = __( 'Manual Orders Trigger', 'automatewoo' );
		$this->description = __( 'Manually trigger a workflow for any orders that match a date range. For example if you create a workflows using the Order Completed trigger and want to have that workflows apply to orders that are already completed.', 'automatewoo' );

		$this->additional_description = sprintf(
			__( 'If you are processing a large amount of orders they will be processed in the background at the rate of %d every %s minutes.', 'automatewoo' ),
			AW()->tools->get_batch_size(),
			round( AW()->tools->get_batch_delay() / 60 )
		);
	}


	/**
	 *
	 */
	function get_form_fields()
	{
		$fields = [];

		$fields[] = ( new AW_Field_Workflow() )
			->set_name_base('args')
			->set_required()
			->add_query_arg( 'meta_query', [[
				'key' => 'trigger_name',
				'value' => [
					'order_placed',
					'order_status_changed',

					'order_cancelled',
					'order_completed',
					'order_on_hold',
					'order_pending',
					'order_processing',
					'order_refunded',

					'users_order_count_reaches',
					'user_purchases_from_category',
					'user_purchases_from_tag',
					'user_purchases_from_taxonomy_term',
					'users_total_spend',
				]
				]]);

		$fields[] = ( new AW_Field_Date() )
			->set_name('date_from')
			->set_title(__( 'Order Created Date - Range From','automatewoo' ))
			->set_name_base('args')
			->set_required();

		$fields[] = ( new AW_Field_Date() )
			->set_name('date_to')
			->set_title(__( 'Order Created Date - Range To','automatewoo' ))
			->set_name_base('args')
			->set_required();

		return $fields;
	}


	/**
	 * @param $args
	 * @return bool|WP_Error
	 */
	function validate_process( $args )
	{
		if ( empty( $args['workflow'] ) || empty( $args['date_from'] ) || empty( $args['date_to'] ) )
		{
			return new WP_Error( 1, __('Missing a required field.', 'automatewoo') );
		}

		$workflow = new AW_Model_Workflow( absint( $args['workflow'] ) );

		if ( ! $workflow->exists || ! $workflow->is_active() )
		{
			return new WP_Error( 2, __('The selected workflow is not currently active.', 'automatewoo') );
		}

		$orders = $this->get_orders( $args['date_from'], $args['date_to'] );

		if ( empty( $orders ) )
		{
			return new WP_Error( 3, __( 'No orders match that date range.', 'automatewoo') );
		}

		return true;
	}


	/**
	 * @param $date_from
	 * @param $date_to
	 * @return array
	 */
	function get_orders($date_from, $date_to )
	{
		$query = new WP_Query([
			'post_type' => wc_get_order_types( 'view-orders' ),
			'post_status' => array_keys( wc_get_order_statuses() ),
			'fields' => 'ids',
			'posts_per_page' => -1,
			'date_query' => [
				[
					'after' => $date_from,
					'before' => $date_to,
					'inclusive' => true
				]
			]
		]);

		return $query->posts;
	}


	/**
	 * @param $args
	 * @return bool|WP_Error
	 */
	function process( $args )
	{
		$workflow = new AW_Model_Workflow( absint( $args['workflow'] ) );
		$orders = $this->get_orders( $args['date_from'], $args['date_to'] );

		AW()->tools->new_background_process( $this->id, [
			'workflow_id' => $workflow->id,
			'order_ids' => $orders
		]);

		return true;
	}


	/**
	 * Do validation in the validate_process() method not here
	 *
	 * @param $args
	 */
	function display_confirmation_screen( $args )
	{
		$workflow = new AW_Model_Workflow( absint( $args['workflow'] ) );
		$orders = $this->get_orders( $args['date_from'], $args['date_to'] );

		$number_to_preview = 25;

		echo '<p>' . sprintf(
				__('Are you sure you want to manually trigger the <strong>%s</strong> workflow for '
					.'<strong>%s</strong> orders? This can not be undone.', 'automatewoo'),
				$workflow->title, count($orders) ) . '</p>';

		echo '<p>' . __( '<strong>Please note:</strong> This list only indicates the orders that match your selected date period. '
				. "These orders have yet to be validated against the selected workflow.", 'automatewoo' ) . '</p>';

		echo '<p>';

		foreach ( $orders as $i => $order_id )
		{
			if ( $i == $number_to_preview )
				break;

			$order = wc_get_order( $order_id );

			echo '#<a href="'. get_edit_post_link( $order->id ).'">'.$order->id.'</a> for ' . $order->get_formatted_billing_full_name();
			echo '<br>';
		}

		if ( count( $orders ) > $number_to_preview )
		{
			echo '+ ' . ( count( $orders ) - $number_to_preview ) . ' more orders...';
		}

		echo '</p>';


	}


	/**
	 * @param $args
	 * @param $batch_size
	 * @return bool
	 */
	function background_process_batch( $args, $batch_size )
	{
		$workflow = new AW_Model_Workflow( absint( $args['workflow_id'] ) );

		if ( ! $workflow->exists || ! $workflow->is_active() )
			return false;

		$order_ids = $args['order_ids'];

		$orders_in_batch = array_slice( $order_ids, 0, $batch_size );
		$remaining_orders = array_slice( $order_ids, $batch_size );

		foreach ( $orders_in_batch as $order )
		{
			$order = wc_get_order( $order );

			$workflow->maybe_run([
				'order' => $order,
				'user' => $order->get_user()
			]);
		}

		if ( ! empty( $remaining_orders ) )
		{
			$args['order_ids'] = $remaining_orders;
			return $args;
		}
	}

}

return new AW_Tool_Manual_Orders_Trigger();