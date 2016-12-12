<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Woocommerce_Enforce_Strong_Password_Settings {
	private $dir;
	private $file;
	private $assets_dir;
	private $assets_url;
	// make it unique! use underscore.
	public static $page_slug = "woocommerce_strong_password";
	public static $page_title = "Woocommerce Enforce Strong Password";

	public function __construct( $file ) {
		$this->dir = dirname( $file );
		$this->file = $file;
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $file ) ) );
		// add options in admin area
		if (is_admin()) {
			add_filter('woocommerce_general_settings', array($this, 'display_menu'));
		}

		// user registration errors
		add_filter('woocommerce_process_registration_errors', array($this, 'wc_check_register_passwd'), 10, 4);
		// check admin and my-account profile update
		add_filter('user_profile_update_errors', array($this, 'wc_check_profile_passwd_update'), 10, 3);
		// handle passwd reset
		add_action('validate_password_reset', array($this, 'wc_check_passwd_reset'), 10, 3);
	}
	
	function display_menu($args) {
		$args[] = array(  
			'title' => __( 'Password Options', 'plugin_textdomain' ), 
			'type' => 'title', 
			'desc' => __( "Use the options below to control user's password format.", 'plugin_textdomain' ), 
		);
		$args[] = array(  
			'title' => __( 'Minimum length', 'plugin_textdomain' ), 
			'type' => 'text', 
			'default' => '8',
			'desc_tip' =>__("The min. number of characters allowable for user's password.", 'plugin_textdomain'),
			'css' => 'width:30px;',
			'id' => "woocommerce_strong_password_options_min_char" 
		);
		$args[] = array(  
			'title' => __( 'Maximum length', 'plugin_textdomain' ), 
			'type' => 'text', 
			'default' => '30',
			'desc_tip' => __("The max. number of characters allowable for user's password.", 'plugin_textdomain'),
			'css' => 'width:30px;',
			'id' => "woocommerce_strong_password_options_max_char" 
		);
		$args[] = array(  
			'title' => __( 'Characters Check', 'plugin_textdomain' ), 
			'desc' => __( "Password must consist of at least 1 number.", 'plugin_textdomain' ),
			'type' => 'checkbox', 
			'default' => 'yes',
			'desc_tip' => __("Eg, 12345", 'plugin_textdomain'),
			'checkboxgroup' => 'start',
			'id' => "woocommerce_strong_password_options_min_1_number" 
		);
		$args[] = array(
			'desc' => __( "Password must consist of at least 1 Lowercase Alphabet.", 'plugin_textdomain' ),
			'type'    => 'checkbox',
	    	'default' => 'yes',
			'desc_tip' => __("Eg, qwerty", 'plugin_textdomain'),
	    	'checkboxgroup'   => '',
	    	'id' => "woocommerce_strong_password_options_min_1_lower_alphabet" 
		);
		$args[] = array(
			'desc' => __( "Password must consist of at least 1 Uppercase Alphabet.", 'plugin_textdomain' ),
			'type'    => 'checkbox',
	    	'default' => 'no',
			'desc_tip' => __("Eg, QWERTY", 'plugin_textdomain'),
	    	'checkboxgroup'   => '',
	    	'id' => "woocommerce_strong_password_options_min_1_upper_alphabet" 
		);
		$args[] = array(
			'desc' => __( "Password must consist of at least 1 Special Character.", 'plugin_textdomain' ),
			'type'    => 'checkbox',
	    	'default' => 'yes',
			'desc_tip' => __("Eg, @#$%^&", 'plugin_textdomain'),
	    	'checkboxgroup'   => 'end',
	    	'id' => "woocommerce_strong_password_options_min_1_special_char" 
		);
		$args[] = array(
			'desc' => __( "Erase settings upon uninstalling this plugin", 'plugin_textdomain' ),
			'type'    => 'checkbox',
	    	'default' => 'yes',
			'desc_tip' => __("This can help to keep your database clean but you lose settings when you uninstall this plugin.", 'plugin_textdomain'),
	    	'id' => "woocommerce_strong_password_options_remove_data_upon_uninstall" 
		);
		$args[] = array( 'type' => 'sectionend', 'id' => 'woocommerce_strong_password_options');

		return $args;
	}

	function wc_check_profile_passwd_update($errors, $update, $user) {
		global $woocommerce;
		// if it is new registration, use submitted password, else its profile update
		$passwd = (!empty($_POST['register']) && $woocommerce->verify_nonce( 'register')) ? $_POST['password'] : $user->user_pass;
		// in case people update profile without updating passwd
		if (!$passwd) {
			return;
		}
		$e = $this->is_password_strong($passwd);
		if ($e != 'success') {
			$errors->add('error', $e);
		}
		return $errors;
	}

	function wc_check_register_passwd($errors, $username, $passwd, $email) {
		$e = $this->is_password_strong($passwd);
		if ($e != 'success') {
			$errors->add('error', $e);
		}
		return $errors;
	}

	function wc_check_passwd_reset( $errors, $user_data ) {
		$e = $this->is_password_strong($_POST['password_1']);
		if ($e != 'success') {
			$errors->add('error', $e);
		}
		// return $errors;
	}

	/**
	 * Check for password strength
	 *
	 * @param	$p	string	The password
	 * @return		string success or error message
	 */
	function is_password_strong($p) {
		global $wpdb;

		$sql = "select option_name, option_value from {$wpdb->prefix}options where option_name like '".self::$page_slug."_%'";
  		$res = $wpdb->get_results($sql);
  		foreach ($res as $v) {
  			${$v->option_name} = $v->option_value;
  		}
		$e = '';
		if(isset($woocommerce_strong_password_options_min_char) && strlen($p) < $woocommerce_strong_password_options_min_char) {
			$e = __("Sorry, your password must have a minimum of $woocommerce_strong_password_options_min_char characters", 'plugin_textdomain');
		}
		elseif(isset($woocommerce_strong_password_options_max_char) && strlen($p) > $woocommerce_strong_password_options_max_char) {
			$e =__("Sorry, your password cannot exceed $woocommerce_strong_password_options_max_char characters.", 'plugin_textdomain');
		}	
		elseif(isset($woocommerce_strong_password_options_min_1_number) && $woocommerce_strong_password_options_min_1_number == 'yes' && !preg_match("#[0-9]+#", $p)) {
			$e = __('Sorry, your password must contain at least one NUMBER.', 'plugin_textdomain');
		}
		elseif(isset($woocommerce_strong_password_options_min_1_lower_alphabet) && $woocommerce_strong_password_options_min_1_lower_alphabet == 'yes' && !preg_match("#[a-z]+#", $p)) {
			$e = __('Sorry, your password must contain at least one LOWERCASE letter.', 'plugin_textdomain');
		}
		elseif(isset($woocommerce_strong_password_options_min_1_upper_alphabet) && $woocommerce_strong_password_options_min_1_upper_alphabet == 'yes' && !preg_match("#[A-Z]+#", $p)) {
			$e = __('Sorry, your password must contain at least one UPPERCASE letter.', 'plugin_textdomain');
		}
		elseif(isset($woocommerce_strong_password_options_min_1_special_char) && $woocommerce_strong_password_options_min_1_special_char == 'yes' && !preg_match("#[\W]+#", $p)) {
			$e = __('Sorry, your password must contain at least one special character. For example, !@#$...', 'plugin_textdomain');
		}
		else {
			$e = 'success';
		}
		return $e;
	}
	
	function network_propagate($pfunction, $networkwide) {
		global $wpdb;
    	if (function_exists('is_multisite') && is_multisite()) {
        	// check network activation 
        	if ($networkwide) {
            	$old_blog = $wpdb->blogid;
            	$blogids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
            	foreach ($blogids as $blog_id) {
                    switch_to_blog($blog_id);
                    call_user_func($pfunction, $networkwide);
            	}
            	switch_to_blog($old_blog);
            	return;
        	}       
    	} 
    	call_user_func($pfunction, $networkwide);
	}

	function activate($networkwide) {
	    $this->network_propagate(array($this, '_activate'), $networkwide);
	}

	function deactivate($networkwide) {
	    $this->network_propagate(array($this, '_deactivate'), $networkwide);
	}

	// plugin activation code here.
	function _activate() {
		// Add options, initiate cron jobs here
	}

	// plugin activation code here.
	function _deactivate() {
	}
}
