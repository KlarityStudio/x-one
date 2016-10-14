<?php
/**
 *
 *
 * @class       AW_Action_Active_Campaign_Remove_Tag
 * @package     AutomateWoo/Actions
 * @since       2.0.0
 */

class AW_Action_Active_Campaign_Remove_Tag extends AW_Action
{
	public $name = 'active_campaign_remove_tag';

	public $group = 'ActiveCampaign';

	public $required_data_items = array(
		'user',
	);


	function init()
	{
		$this->title = __('Remove Tag From User', 'automatewoo');
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
		$tag = new AW_Field_Text_Input();
		$tag->set_title(__( 'Tag', 'automatewoo' ));
		$tag->set_name('tag');
		$tag->set_required(true);

		$this->add_field($tag);
	}


	/**
	 * @return void
	 */
	function run()
	{
		if ( ! $user = $this->workflow->get_data_item('user') )
			return;

		$tag = $this->get_option('tag');

		if ( empty( $tag ) ) return;

		$data = array(
			'email' => $user->user_email,
			'tags' => $tag
		);

		AW()->integrations()->activecampaign()->request( 'contact/tag/remove', $data );

	}

}
