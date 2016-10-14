<?php
/**
 * @class       AW_Action_Active_Campaign_Add_Tag
 * @package     AutomateWoo/Actions
 * @since       2.0.0
 */

class AW_Action_Active_Campaign_Add_Tag extends AW_Action
{
	public $name = 'active_campaign_add_tag';

	public $group = 'ActiveCampaign';

	public $required_data_items = [ 'user' ];


	function init()
	{
		$this->title = __('Add Tag To User', 'automatewoo');
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
		$tag = ( new AW_Field_Text_Input() )
			->set_title( __( 'Tags', 'automatewoo' ) )
			->set_name('tag')
			->set_description('Tags to add to this contact (comma-separated). Example: tag1, tag2, etc')
			->set_required();

		$create_user = new AW_Field_Checkbox();
		$create_user->set_title(__( "Create Contact If Missing", 'automatewoo' ));
		$create_user->set_name('create_missing_contact');

		$this->add_field($tag);
		$this->add_field($create_user);
	}


	/**
	 * @return void
	 */
	function run()
	{
		if ( ! $user = $this->workflow->get_data_item('user') )
			return;

		$tags = $this->get_option('tag');
		$create_missing_contact = $this->get_option('create_missing_contact');

		if ( empty( $tags ) ) return;

		$ac = AW()->integrations()->activecampaign();

		if  ( $create_missing_contact )
		{
			if ( ! $ac->is_contact( $user->user_email ) )
			{
				$contact_data = [
					"email" => $user->user_email,
					"first_name" => $user->first_name,
					"last_name" => $user->last_name,
					"phone" => $user->billing_phone,
					'tags' => $tags
				];

				$ac->request( 'contact/sync', $contact_data );

				return;
			}
		}


		$data = array(
			'email' => $user->user_email,
			'tags' => $tags
		);

		$ac->request( 'contact/tag/add', $data);


	}

}
