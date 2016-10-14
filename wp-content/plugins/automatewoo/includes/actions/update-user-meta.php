<?php
/**
 * Update User Meta Action
 *
 * @class       AW_Action_Update_User_Meta
 * @package     AutomateWoo/Actions
 * @since       1.0.0
 */

class AW_Action_Update_User_Meta extends AW_Action
{
	public $name = 'update_user_meta';

	public $group = 'User';

	public $required_data_items = array(
		'user',
	);


	function init()
	{
		$this->title = __('Add/Update User Meta', 'automatewoo');

		// Registers the actions
		parent::init();
	}


	function load_fields()
	{
		$meta_key = new AW_Field_Text_Input();
		$meta_key->set_name('meta_key');
		$meta_key->set_title(__('Meta Key', 'automatewoo'));
		$meta_key->set_required(true);

		$meta_value = new AW_Field_Text_Input();
		$meta_value->set_name('meta_value');
		$meta_value->set_title(__('Meta Value', 'automatewoo'));

		$this->add_field($meta_key);
		$this->add_field($meta_value);
	}


	/**
	 * Requires a WC Order object
	 */
	function run()
	{
		// Do we have an order object?
		if ( ! $user = $this->workflow->get_data_item('user') )
			return;

		$meta_key = $this->get_option('meta_key', true );
		$meta_value = $this->get_option('meta_value', true );

		// Make sure there is a meta key but a value is not required
		if ( $meta_key )
		{
			update_user_meta( $user->ID, $meta_key, $meta_value );
		}

	}

}
