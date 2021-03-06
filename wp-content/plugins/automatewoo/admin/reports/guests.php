<?php
/**
 * @class		AW_Report_Logs
 * @package		AutomateWoo/Admin/Reports
 * @since 		2.4.9
 */

class AW_Report_Guests extends AW_Report_List_Table
{
	public $_column_headers;

	public $max_items;


	/**
	 * __construct function.
	 */
	function __construct()
	{
		parent::__construct( array(
			'singular'  => __( 'Guest', 'automatewoo' ),
			'plural'    => __( 'Guests', 'automatewoo' ),
			'ajax'      => false
		) );
	}

	/**
	 * No items found text
	 */
	function no_items()
	{
		_e( 'No active guests found.', 'automatewoo' );
	}


	/**
	 * get_columns function.
	 */
	function get_columns()
	{
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'id' => __( 'Guest', 'automatewoo' ),
			'email' => __( 'Email', 'automatewoo' ),
			'created' => __( 'Created', 'automatewoo' ),
			'last_active' => __( 'Last Active', 'automatewoo' ),
		);

		if ( AW()->integrations()->is_wpml() )
		{
			$columns['language'] = __( 'Language', 'automatewoo' );
		}

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
		$query = new AW_Query_Guests();
		$query->set_limit( $per_page );
		$query->set_offset( ($current_page - 1 ) * $per_page );
		$query->set_ordering('last_active', 'DESC');
		$res = $query->get_results();

		$this->items = $res;

		$this->max_items = $query->found_rows;
	}


	/**
	 * @param $guest AW_Model_Guest
	 * @return string
	 */
	function column_cb( $guest )
	{
		return '<input type="checkbox" name="guest_ids[]" value="' . absint( $guest->id ) . '" />';
	}


	/**
	 * @var $guest AW_Model_Guest
	 * @return string
	 */
	function column_id( $guest )
	{
		return '#' . $guest->id;
	}


	/**
	 * @var $guest AW_Model_Guest
	 * @return string
	 */
	function column_email( $guest )
	{
		return "<a href='mailto:$guest->email'>$guest->email</a>";
	}


	/**
	 * @var $guest AW_Model_Guest
	 * @return string
	 */
	function column_created( $guest )
	{
		return aw_display_time( $guest->created );
	}


	/**
	 * @var $guest AW_Model_Guest
	 * @return string
	 */
	function column_last_active( $guest )
	{
		return aw_display_time( $guest->last_active );
	}


	/**
	 * @var $guest AW_Model_Guest
	 * @return string
	 */
	function column_language( $guest )
	{
		if ( ! AW()->integrations()->is_wpml() )
			return;

		return AW()->language_helper->get_guest_language( $guest );
	}


	/**
	 * Retrieve the bulk actions
	 */
	function get_bulk_actions()
	{
		$actions = array(
			'bulk_delete' => __( 'Delete', 'automatewoo' ),
		);

		return $actions;
	}

}
