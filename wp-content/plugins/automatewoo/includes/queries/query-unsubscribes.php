<?php
/**
 * @class       AW_Query_Unsubscribes
 * @package     AutomateWoo/Queries
 */

class AW_Query_Unsubscribes extends AW_Query_Custom_Table
{
	protected $model = 'AW_Model_Unsubscribe';

	public $table_columns = array( 'id', 'workflow_id', 'user_id', 'date' );


	function __construct()
	{
		$this->table_name = AW()->table_name_unsubscribes;
	}
}