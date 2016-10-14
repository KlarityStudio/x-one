<?php
/**
 *
 *
 * @class       AW_Action_Active_Campaign_Add_User_To_List
 * @package     AutomateWoo/Actions
 * @since       2.0.0
 */

class AW_Action_Active_Campaign_Add_User_To_List extends AW_Action
{
	public $name = 'add_user_to_active_campaign_list';

	public $group = 'ActiveCampaign';

	public $required_data_items = array(
		'user',
	);


	function init()
	{
		$this->title = __('Add User to List', 'automatewoo');
		parent::init();
	}


	function check_requirements()
	{
		if ( ! function_exists('curl_init') )
		{
			$this->warning( __('Server is missing CURL extension required to use the ActiveCampaign API.', 'automatewoo' ) );
		}
	}


	function load_fields()
	{
		$list_select = ( new AW_Field_Select() )
			->set_title(__( 'List', 'automatewoo' ))
			->set_name('list')
			->set_options( AW()->integrations()->activecampaign()->get_lists() )
			->set_description(__( 'Leave blank to add a contact without assigning them to any lists.', 'automatewoo' ))
			->set_required();

		$this->add_field($list_select);
	}


	/**
	 * @return void
	 */
	function run()
	{
		if ( ! $user = $this->workflow->get_data_item('user') )
			return;

		$list_id = $this->get_option('list');

		$contact = array(
			"email" => $user->user_email,
			"first_name" => $user->first_name,
			"last_name" => $user->last_name,
			'phone' => $user->billing_phone,
		);

		if ( $list_id )
		{
			$contact["p[$list_id]"] = $list_id;
			$contact["status[$list_id]"] = 1;
		}

		AW()->integrations()->activecampaign()->request( 'contact/sync', $contact );
	}

}
