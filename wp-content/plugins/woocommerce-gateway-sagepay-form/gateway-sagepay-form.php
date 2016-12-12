<?php
/*
Plugin Name: WooCommerce SagePay Form and SagePay Direct Gateway
Plugin URI: http://woothemes.com/woocommerce
Description: Extends WooCommerce. Provides a SagePay Form / SagePay Direct gateway for WooCommerce. http://www.sagepay.com. For support please contact http://support.woothemes.com.
Version: 3.3.6
Author: Add On Enterprises (Andrew Benbow)
Author URI: http://www.addonenterprises.com
*/

/*  Copyright 2013  Add On Enterprises  (email : support@addonenterprises.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) )
    require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), '6bc0cca47d0274d8ef9b164f6fbec1cc', '18599' );


/**
 * Init SagePay Gateway after WooCommerce has loaded
 */
add_action( 'plugins_loaded', 'init_sagepay_gateway', 0 );

/**
 * Localization
 */
load_plugin_textdomain( 'woocommerce_sagepayform', false, dirname( plugin_basename( __FILE__ ) ) . '/' );

function init_sagepay_gateway() {

    if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
    	return;
    }

    /**
     * Defines
     */
    define( 'SAGESUPPORTURL' , 'http://support.woothemes.com/' );
    define( 'SAGEDOCSURL' , 'https://docs.woothemes.com/document/sagepay-form/');
    define( 'SAGEPLUGINPATH', plugin_dir_path( __FILE__ ) );
    define( 'SAGEPLUGINURL', plugin_dir_url( __FILE__ ) );

    /**
     * Add SagePay Form mCrypt notice
     * Only required in admin
     */
    if( is_admin() ) {
        include('classes/sagepay-form-admin-notice-class.php');
    }

    /**
     * Add SagePay Direct CC Type notice
     * Only required in admin
     */
    if( is_admin() ) {
        include('classes/sagepay-direct-admin-notice-class.php');
    }

    /**
     * Load common functions
     */
    include('classes/sagepay-common-functions-class.php');

    /**
     * add_sagepay_form_gateway function.
     *
     * @access public
     * @param mixed $methods
     * @return void
     */
	include('classes/sagepay-form-class.php');

    function add_sagepay_form_gateway($methods) {
        $methods[] = 'WC_Gateway_Sagepay_Form';
        return $methods;
    }

    add_filter( 'woocommerce_payment_gateways', 'add_sagepay_form_gateway' );

    /**
     * add_sagepay_direct_gateway function.
     *
     * @access public
     * @param mixed $methods
     * @return void
     */
    include('classes/sagepay-direct-class.php');
    include('classes/sagepay-direct-class-addons.php');

    function add_sagepay_direct_gateway($methods) {
        
        if ( class_exists( 'WC_Subscriptions_Order' ) || class_exists( 'WC_Pre_Orders_Order' ) ) {
            $methods[] = 'WC_Gateway_Sagepay_Direct_AddOns';
        } else {
            $methods[] = 'WC_Gateway_Sagepay_Direct';
        }
        return $methods;
        
    }

    add_filter('woocommerce_payment_gateways', 'add_sagepay_direct_gateway' );


    /**
     * SagePay Direct Dismissible Notices
     */
    add_action( 'wp_ajax_dismiss_sagepaydirect_ssl_nag', 'dismiss_sagepaydirect_ssl_nag' );

    function dismiss_sagepaydirect_ssl_nag() {
        update_option( 'sagepaydirect-ssl-nag-dismissed', 1 );
    }

    add_action( 'wp_ajax_dismiss_sagepaydirect_cctype_nag', 'dismiss_sagepaydirect_cctype_nag' );

    function dismiss_sagepaydirect_cctype_nag() {
        update_option( 'sagepaydirect-cctype-nag-dismissed', 1 );
    }

    // Enqueue the dismiss script
    add_action( 'admin_enqueue_scripts', 'sagepaydirect_dismiss_assets' );

    function sagepaydirect_dismiss_assets() {
        wp_enqueue_script( 'sagepaydirect-nag-dismiss', plugins_url( '/', __FILE__ ) . '/assets/js/dismiss.js', array( 'jquery' ), '1.0', true  );
    }

}