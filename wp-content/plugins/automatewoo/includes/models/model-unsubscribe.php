<?php
/**
 * Model for unsubscribe objects
 *
 * @class       AW_Model_Unsubscribe
 * @package     AutomateWoo/Models
 * @since       2.1.0
 *
 * @property $workflow_id int
 * @property $user_id int
 * @property $date string
 */

class AW_Model_Unsubscribe extends AW_Model
{
	/** @var string */
	public $model_id = 'unsubscribe';

	/**
	 * @param bool|int $id
	 */
	function __construct( $id = false )
	{
		$this->table_name = AW()->table_name_unsubscribes;

		if ( $id ) $this->get_by( 'id', $id );
	}

}

