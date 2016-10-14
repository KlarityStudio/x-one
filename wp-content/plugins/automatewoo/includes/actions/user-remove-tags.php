<?php
/**
 * User Remove Tags Action
 *
 * @class       AW_Action_User_Remove_Tags
 * @package     AutomateWoo/Actions
 * @since       2.0.0
 */

class AW_Action_User_Remove_Tags extends AW_Action
{
	public $name = 'user_remove_tag';

	public $group = 'User';

	public $required_data_items = array(
		'user',
	);


	function init()
	{
		$this->title = __('Remove Tags from User', 'automatewoo');

		// Registers the actions
		parent::init();
	}


	function load_fields()
	{
		$tags = new AW_Field_User_Tags();

		$this->add_field($tags);
	}


	/**
	 */
	function run()
	{
		if ( ! $user = $this->workflow->get_data_item('user') )
			return;

		$tags = $this->get_option('user_tags', false );

		if ( ! $user->ID || empty($tags) )
			return;

		wp_remove_object_terms( $user->ID, $tags, 'user_tag' );
	}

}
