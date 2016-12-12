<?php
/*
Plugin Name: Woocommerce Enforce Strong Password
Version: 1.2.2
Plugin URI: 
Description: Wordpress by default doesn't come with password check. This plugin allows woocommerce admin to set the password rules.
Author: Bernard Peh
Author URI: http://www.azhowto.com
*/

if ( ! defined( 'ABSPATH' ) ) exit;

function woocommerce_dependency_check() {
    echo '<div class="error"><p>';
    _e('This plugin is dependent on woocommerce. Please activate woocommerce first. Ignore this message if you are uninstalling this plugin', 'plugin_textdomain');
    echo '</p></div>';
}

if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_admin()) {
	add_action( 'admin_notices', 'woocommerce_dependency_check' );
}

require_once( 'classes/Class-Woocommerce-Enforce-Strong-Password.php' );
$strong_password = new Woocommerce_Enforce_Strong_Password( __FILE__ );

require_once( 'classes/Class-Woocommerce-Enforce-Strong-Password-Settings.php' );
$strong_password_settings = new Woocommerce_Enforce_Strong_Password_Settings( __FILE__ );

// require_once( 'classes/post-types/Class-Woocommerce-Enforce-Strong-Password-Post-Type.php' );
// $plugin_post_type_obj = new Woocommerce_Enforce_Strong_Password_Post_Type( __FILE__ );

register_activation_hook( __FILE__, array($strong_password_settings,'activate') );
register_deactivation_hook( __FILE__, array($strong_password_settings,'deactivate') );



