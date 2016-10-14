<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * AW_Report_Unsubscribes
 */
class AW_Report_Unsubscribes extends AW_Report_List_Table
{
	public $_column_headers;
	public $max_items;


	/**
	 * __construct function.
	 */
	function __construct()
	{
		parent::__construct( array(
			'singular'  => __( 'Unsubscribe', 'automatewoo' ),
			'plural'    => __( 'Unsubscribes', 'automatewoo' ),
			'ajax'      => false
		) );
	}


	/**
	 * No items found text
	 */
	function no_items()
	{
		_e( 'No unsubscribes found.', 'automatewoo' );
	}



	/**
	 * column_default function.
	 *
	 * @param $item AW_Model_Unsubscribe
	 * @param mixed $column_name
	 */
	function column_default( $item, $column_name )
	{
		switch( $column_name )
		{
			case 'workflow':
				$this->format_workflow_title( new AW_Model_Workflow( $item->workflow_id ) );
				break;

			case 'user':
				$user = get_user_by( 'id', $item->user_id );
				$this->format_user($user);
				break;

			case 'time':
				$this->format_date( $item->date );
				break;
		}
	}


	/**
	 * get_columns function.
	 */
	function get_columns()
	{
		$columns = array(
			'workflow'  => __( 'Workflow', 'automatewoo' ),
			'user' => __( 'User', 'automatewoo' ),
			'time' => __( 'Time', 'automatewoo' ),
		);

		return $columns;
	}


	/**
	 * prepare_items function.
	 */
	function prepare_items()
	{
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );
		$current_page = absint( $this->get_pagenum() );
		$per_page = apply_filters( 'automatewoo_report_items_per_page', 20 );

		$this->get_items( $current_page, $per_page );

		/**
		 * Pagination
		 */
		$this->set_pagination_args( array(
			'total_items' => $this->max_items,
			'per_page'    => $per_page,
			'total_pages' => ceil( $this->max_items / $per_page )
		) );
	}



	/**
	 * Get Products matching stock criteria
	 */
	function get_items( $current_page, $per_page )
	{
		$query = new AW_Query_Unsubscribes();
		$query->set_limit( $per_page );
		$query->set_offset( ($current_page - 1 ) * $per_page );
		$query->set_ordering('date', 'ASC');
		$res = $query->get_results();

		$this->items = $res;

		$this->max_items = $query->found_rows;
	}

}
