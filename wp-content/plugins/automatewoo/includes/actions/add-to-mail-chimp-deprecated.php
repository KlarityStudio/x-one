<?php
/**
 * Class AW_Action_Add_To_Mail_Chimp
 */

class AW_Action_Add_To_Mail_Chimp_DEPRECATED extends AW_Action
{
	public $name = 'add_to_mail_chimp';

	public $group = 'MailChimp';

	public $required_data_items = array(
		'user',
		'_DEPRECATED'
	);


	function init()
	{
		$this->title = __('Add User to List - DEPRECATED ENABLE NEW ACTIONS IN SETTINGS', 'automatewoo');

		// Registers the actions
		parent::init();
	}


	function load_fields()
	{
		$api_key = new AW_Field_Text_Input();
		$api_key->set_name('api_key');
		$api_key->set_title( __( 'API Key', 'automatewoo' ) );
		$api_key->set_required(true);
		$api_key->set_description( __( 'You can get your API key when logged in to MailChimp under Account > Extras > API Keys.', 'automatewoo' ) );

		$list_id = new AW_Field_Text_Input();
		$list_id->set_name('list_id');
		$list_id->set_title( __( 'List ID', 'automatewoo' ) );
		$list_id->set_required(true);
		$list_id->set_description( __( 'You find the List ID under List Settings > List name and defaults.', 'automatewoo' ) );

		$send_welcome = new AW_Field_Checkbox();
		$send_welcome->set_name('send_welcome');
		$send_welcome->set_title( __( 'Send Welcome', 'automatewoo' ) );
		$send_welcome->set_description( __( 'If checked the user will receive a welcome email when added to your the list.', 'automatewoo' ) );

		$double_optin = new AW_Field_Checkbox();
		$double_optin->set_name('double_optin');
		$double_optin->set_title( __( 'Double Optin', 'automatewoo' ) );
		$double_optin->set_description( __( 'Users will receive an email asking them to confirm their subscription.', 'automatewoo' ) );

		$this->add_field($api_key);
		$this->add_field($list_id);
		$this->add_field($double_optin);
		$this->add_field($send_welcome);
	}


	/**
	 * @return void
	 */
	function run()
	{
		if ( ! $user = $this->workflow->get_data_item('user') )
			return;

		if ( ! class_exists( 'Drewm_MailChimp' ) )
		{
			require_once AW()->lib_path( '/mailchimp-api/src/Drewm/MailChimp.php' );
		}

		$mailchimp = new Drewm_MailChimp( $this->get_option('api_key') );

		// API call
		$data = array(
			'id' => $this->get_option('list_id'),
			'email' => array(
				'email' => $user->user_email
			),
			'merge_vars' => array(
				'FNAME' => $user->first_name,
				'LNAME' => $user->last_name
			),
			'double_optin' => $this->get_option('double_optin') ? true : false,
			'update_existing' => true,
			'replace_interests' => false,
			'send_welcome' => $this->get_option('send_welcome') ? true : false,
		);

		$response = $mailchimp->call('lists/subscribe', $data );

		if ( isset( $response['status'] ) and $response['status'] == 'error' )
			return false;
		elseif ( isset( $response['email'] ) )
			return true;
		else
			return false;
	}

}
