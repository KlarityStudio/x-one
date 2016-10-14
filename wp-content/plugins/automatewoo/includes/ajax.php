<?php
/**
 * @class       AW_Ajax
 * @package     AutomateWoo
 */
class AW_Ajax
{

	/**
	 * Hook in methods
	 */
	static function init()
	{
		// aw_EVENT => nopriv
		$ajax_events = array(
			'fill_trigger_fields' => false,
			'fill_action_fields' => false,
			'json_search_workflows' => false,
			'json_search_attribute_terms' => false,
			'json_search_taxonomy_terms' => false,
			'activate' => false,
			'deactivate' => false,
			'email_preview_ui' => false,
			'email_preview_iframe' => false,
			'test_sms' => false,
			'database_update' => false,
			'save_preview_data' => false,
			'send_test_email' => false,
			'dismiss_expiry_notice' => false,
			'dismiss_system_error_notice' => false,
			'get_rule_select_choices' => false,
			'toggle_workflow_status' => false,

			// modals
			'modal_log_info' => false,
			'modal_variable_info' => false,

			'capture_email' => true
		);


		foreach ( $ajax_events as $ajax_event => $nopriv )
		{
			add_action( 'wp_ajax_aw_' . $ajax_event, array( __CLASS__, $ajax_event ) );

			if ( $nopriv )
			{
				add_action( 'wp_ajax_nopriv_aw_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}


	/**
	 *
	 */
	static function fill_trigger_fields()
	{
		if ( ! current_user_can( 'manage_woocommerce' ) )
			die;

		$trigger_name = aw_clean( aw_request('trigger_name') );
		$workflow_id = absint( aw_request('workflow_id') );
		$is_new_workflow = aw_request('is_new_workflow');

		$workflow = false;
		$trigger = AW()->get_registered_trigger( $trigger_name );

		if ( ! $trigger )
			die;

		if ( ! $is_new_workflow )
		{
			$workflow = new AW_Model_Workflow( $workflow_id );
		}

		ob_start();

		AW()->admin->get_view('trigger-fields', array(
			'trigger' => $trigger,
			'workflow' => $workflow,
		));

		$fields = ob_get_clean();

		wp_send_json_success(array(
			'fields' => $fields,
			'trigger' => $trigger,
		));
	}


	/**
	 *
	 */
	static function fill_action_fields()
	{
		if ( ! current_user_can( 'manage_woocommerce' ) )
			die();

		$action_name = aw_clean( aw_request('action_name') );
		$action_number = aw_clean( aw_request('action_number') );

		$action = AW()->get_registered_action( $action_name );

		ob_start();

		AW()->admin->get_view('action-fields', array(
			'action' => $action,
			'action_number' => $action_number,
		));

		$fields = ob_get_clean();

		wp_send_json_success(array(
			'fields' => $fields,
			'title' => $action->get_title( true ),
			'description' => $action->get_description_html()
		));
	}


	/**
	 * Search for products and echo json
	 */
	public static function json_search_workflows()
	{
		if ( ! current_user_can( 'manage_woocommerce' ) )
			die;

		ob_start();

		$term = (string) aw_clean( stripslashes( $_GET['term'] ) );

		if ( empty( $term ) )
			die;

		$args = [
			'post_type' => 'aw_workflow',
			'post_status' => 'any',
			'posts_per_page' => -1,
			's' => $term,
			'fields' => 'ids'
		];

		$posts = get_posts( $args );

		$found = [];

		if ( $posts )
		{
			foreach ( $posts as $workflow_id )
			{
				$workflow = new AW_Model_Workflow($workflow_id);
				$found[ $workflow_id ] = rawurldecode( $workflow->title );
			}
		}

		wp_send_json( $found );
	}


	/**
	 * Search for products and echo json
	 */
	public static function json_search_attribute_terms()
	{
		if ( ! current_user_can( 'manage_woocommerce' ) )
			die();

		ob_start();

		$search = (string) aw_clean( stripslashes( $_GET['term'] ) );
		$sibling = (string) aw_clean( stripslashes( $_GET['sibling'] ) );

		if ( empty( $search ) || empty($sibling) )
		{
			die();
		}

		$terms = get_terms( 'pa_' . $sibling, array(
			'hide_empty' => false,
			'search' => $search
		));


		$found = array();

		if ( ! $terms || is_wp_error($terms)  )
			die();

		foreach ( $terms as $term )
		{
			$found[ $term->term_id . '|' . $term->taxonomy  ] = rawurldecode( $term->name );
		}

		wp_send_json( $found );
	}



	/**
	 * Search for products and echo json
	 */
	public static function json_search_taxonomy_terms()
	{
		if ( ! current_user_can( 'manage_woocommerce' ) )
			die();

		ob_start();

		$search = (string) aw_clean( stripslashes( $_GET['term'] ) );
		$sibling = (string) aw_clean( stripslashes( $_GET['sibling'] ) );

		if ( empty( $search ) || empty($sibling) )
		{
			die();
		}

		$terms = get_terms( $sibling, array(
			'hide_empty' => false,
			'search' => $search
		));


		$found = array();

		if ( ! $terms || is_wp_error($terms)  )
			die();

		foreach ( $terms as $term )
		{
			$found[ $term->term_id . '|' . $term->taxonomy  ] = rawurldecode( $term->name );
		}

		wp_send_json( $found );
	}



	/**
	 * @param $workflow_id
	 * @param $action_number
	 * @param string $mode test|preview
	 *
	 * @return AW_Action|false
	 */
	static function _get_preview_action( $workflow_id, $action_number, $mode = 'preview' )
	{
		$preview_data = get_transient( 'aw_wf_preview_' . $workflow_id );

		if ( ! $workflow_id || ! $action_number || ! is_array( $preview_data )  )
			return false;

		// sanitize input
		foreach ( $preview_data as $i => $item )
		{
			switch ( $i )
			{
				case 'email_content':
					$preview_data[$i] = wp_kses_post(stripslashes($item));
					break;

				default:
					$preview_data[$i] = aw_clean(stripslashes($item));
					break;
			}
		}

		// check action exists
		if ( ! AW()->get_registered_action( $preview_data['action_name'] ) )
			return false;

		// create a fake action
		$action = clone AW()->get_registered_action( $preview_data['action_name'] );

		// add the workflow in preview mode
		$workflow = new AW_Model_Workflow( $workflow_id );

		if ( $mode === 'test' )
		{
			$workflow->enable_test_mode();
		}
		else
		{
			$workflow->enable_preview_mode();
		}

		$action->workflow = $workflow;

		// replace saved options with live preview data
		$action->set_options($preview_data);

		return $action;
	}


	/**
	 *
	 */
	static function email_preview_ui()
	{
		if ( ! current_user_can( 'manage_woocommerce' ) )
			die();

		$type = aw_clean( aw_request('type') );
		$args = aw_clean( aw_request('args') );

		$iframe_url = add_query_arg(array(
			'action' => 'aw_email_preview_iframe',
			'type' => $type,
			'args' => $args
		), admin_url( 'admin-ajax.php' ) );


		switch ( $type )
		{
			case 'workflow_action':
				if ( ! $action = self::_get_preview_action( $args['workflow_id'], $args['action_number'] ) )
					die();

				$email_subject = $action->get_option('subject', true );
				$template = $action->get_option( 'template' );
				break;

			default:
				$email_subject = '';
				$template = '';
		}

		$email_subject = apply_filters( 'automatewoo/email_preview/subject', $email_subject, $type, $args );
		$template = apply_filters( 'automatewoo/email_preview/template', $template, $type, $args );

		AW()->admin->get_view('email-preview-ui', array(
			'iframe_url' => $iframe_url,
			'type' => $type,
			'args' => $args,
			'email_subject' => $email_subject,
			'template' => $template
		));

		die();
	}




	/**
	 *
	 */
	public static function email_preview_iframe()
	{
		if ( ! current_user_can( 'manage_woocommerce' ) )
			die();

		$type = aw_clean( aw_request('type') );
		$args = aw_clean( aw_request('args') );

		switch ( $type )
		{
			case 'workflow_action':
				if ( ! $action = self::_get_preview_action( $args['workflow_id'], $args['action_number'] ) )
					die();

				if ( ! $action || ! $action->can_be_previewed )
				{
					wp_die( __( 'Sorry, this action can not be previewed.', 'automatewoo' ) );
				}

				echo $action->preview();

				break;

			default:
				do_action( 'automatewoo/email_preview/html', $type, $args );
		}

		exit();
	}


	/**
	 * Sends a test to supplied emails
	 */
	static function send_test_email()
	{
		$type = aw_clean( aw_request('type') );
		$args = aw_clean( aw_request('args') );
		$to = aw_clean( aw_request('to_emails') );

		// save the to field
		update_user_meta( get_current_user_id(), 'automatewoo_email_preview_test_emails', $to );

		$to = AW()->email->parse_multi_email_field( $to );

		switch ( $type )
		{
			case 'workflow_action':
				if ( ! $action = self::_get_preview_action( $args['workflow_id'], $args['action_number'], 'test' ) )
					die();

				if ( ! $action || ! $action->can_be_previewed )
				{
					wp_die( __( 'Sorry, this action can not be previewed.', 'automatewoo' ) );
				}

				$action->preview( $to );

				break;

			default:
				do_action( 'automatewoo/email_preview/send_test', $type, $to, $args );
		}


		wp_send_json_success(array(
			'message' => sprintf(
				__( 'Success! %s email%s sent.', 'automatewoo' ),
				count($to),
				count($to) == 1 ? '' : 's'
			)
		));
	}



	public static function test_sms()
	{
		if ( ! current_user_can( 'manage_woocommerce' ) )
			die();

		$from = aw_clean( aw_request('from') );
		$auth_id = aw_clean( aw_request('auth_id') );
		$auth_token = aw_clean( aw_request('auth_token') );
		$test_message = aw_clean( aw_request('test_message') );
		$test_recipient = aw_clean( aw_request('test_recipient') );

		AW()->integrations()->load_twilio();

		$client = new Services_Twilio($auth_id, $auth_token);

		try
		{
			$message = $client->account->messages->sendMessage( $from, $test_recipient, $test_message );
			wp_send_json_success( array(
				'message' => __('Message sent.','automatewoo')
			));
		}
		catch(Exception $e)
		{
			wp_send_json_error( array(
				'message' => $e->getMessage()
			));

		}
	}


	/**
	 *
	 */
	public static function capture_email()
	{
		// don't capture the email if the user has been detected
		if ( AW()->session_tracker->get_detected_user_id() ) die();

		$email = sanitize_email( aw_request('email') );
		$language = aw_clean( aw_request('language') );

		// capture the guest email
		AW()->session_tracker->store_guest( $email, $language );

		exit();
	}


	/**
	 *
	 */
	public static function database_update()
	{
		$verify = wp_verify_nonce($_REQUEST['nonce'], 'automatewoo_database_upgrade');
		$plugin_slug = aw_clean( aw_request('plugin_slug') );

		if ( ! $verify ) wp_send_json_error( __('Permission error.', 'automatewoo' ) );


		if ( $plugin_slug == AW()->plugin_slug )
		{
			// updating the primary plugin
			AW_Install::update();
		}
		else
		{
			// updating an addon
			$addon = AW()->addons()->get( $plugin_slug );

			if ( ! $addon )
			{
				wp_send_json_error(__( 'Add-on could not be updated', 'automatewoo' ) );
			}

			$addon->do_database_update();
		}

		wp_send_json_success();
	}


	/**
	 * To preview a workflow, save the data to a transient first
	 */
	static function save_preview_data()
	{
		$workflow_id = absint( aw_request('workflow_id') );
		$preview_data = aw_request('preview_data');

		if ( ! is_array( $preview_data ) || ! $workflow_id )
			wp_send_json_error();

		set_transient( 'aw_wf_preview_' . $workflow_id, $preview_data, HOUR_IN_SECONDS );

		wp_send_json_success();
	}


	/**
	 *
	 */
	static function dismiss_expiry_notice()
	{
		set_transient( 'aw_dismiss_licence_expiry_notice', '1', 10 * MONTH_IN_SECONDS );
	}


	/**
	 *
	 */
	static function dismiss_system_error_notice()
	{
		delete_transient('automatewoo_background_system_check_errors');
	}



	static function get_rule_select_choices()
	{
		if ( ! current_user_can( 'manage_woocommerce' ) )
			die;

		if ( ! $rule_name = aw_clean( aw_request('rule_name') ) )
			die;

		$rule_object = AW()->rules()->get_rule( $rule_name );

		if ( $rule_object->type == 'select' )
		{
			wp_send_json_success([
				'select_choices' => $rule_object->get_select_choices()
			]);
		}

		die;
	}


	/**
	 * Display content for log details modal
	 */
	static function modal_log_info()
	{
		if ( $log = AW()->get_log( absint( aw_request('log_id') ) ) )
		{
			AW()->admin->get_view( 'modal-log-info', [ 'log' => $log ] );
			die;
		}

		die( __( 'No log found.', 'automatewoo' ) );
	}


	static function modal_variable_info()
	{
		$variable = aw_clean( aw_request( 'variable' ) );

		AW()->admin->get_view( 'modal-variable-info', [
			'variable' => $variable
		]);

		die;
	}


	/**
	 *
	 */
	static function toggle_workflow_status()
	{
		if ( ! current_user_can( 'manage_woocommerce' ) )
			die;

		$workflow_id = absint( aw_request( 'workflow_id' ) );
		$new_state = aw_clean( aw_request( 'new_state' ) );

		if ( ! $workflow_id || ! $new_state )
			die;

		wp_update_post([
			'ID' => $workflow_id,
			'post_status' => $new_state === 'on' ? 'publish' : 'aw-disabled'
		]);

		wp_send_json_success();
	}

}
