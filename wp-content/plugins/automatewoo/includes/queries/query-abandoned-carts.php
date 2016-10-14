<?php
/**
 * @class       AW_Query_Abandoned_Carts
 * @since       2.0.0
 * @package     AutomateWoo/Queries
 */

class AW_Query_Abandoned_Carts extends AW_Query_Custom_Table
{
	protected $model = 'AW_Model_Abandoned_Cart';

	public $table_columns = array( 'id', 'user_id', 'last_modified', 'items', 'total', 'token' );


	function __construct()
	{
		$this->table_name = AW()->table_name_abandoned_cart;
	}
}