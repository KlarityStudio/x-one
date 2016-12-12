<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if ( !is_user_logged_in() )
        wp_die( __('You must be logged in to run this script.', 'plugin_textdomain'));

if ( !current_user_can('install_plugins'))
        wp_die(__('You do not have permission to run this script.', 'plugin_textdomain'));

// Enter our plugin uninstall script below
require_once( 'classes/Class-Woocommerce-Enforce-Strong-Password-Settings.php' );
$page_slug = Woocommerce_Enforce_Strong_Password_Settings::$page_slug;
$check = get_option($page_slug.'_options_remove_data_upon_uninstall');
if ($check) {
	// remember to delete all the fields that you pre-defined.

	delete_option( $page_slug.'_options_min_char' );

	delete_option( $page_slug.'_options_max_char' );

	delete_option( $page_slug.'_min_1_number' );

	delete_option( $page_slug.'_options_min_1_lower_alphabet' );

	delete_option( $page_slug.'_options_min_1_upper_alphabet' );

	delete_option( $page_slug.'_options_min_1_special_char' );

	delete_option( $page_slug.'_options_remove_data_upon_uninstall' );
}
