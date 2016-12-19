<?php
/**
 * Builder plugin
 *
 * @package 	Infinity_Builder
 * @author		Andy Neale
 * @copyright 	Copyright (c) 2012 - 2014, HeadwayLabs
 * @link			http://www.eezy.io
 * @license		http://www.opensource.org/licenses/gpl-3.0.php GPL License
 * @since 		1.0.0
 *
 * Plugin Name: Infinity Builder
 * Plugin URI: http://www.eezy.io
 * Description: Create Infinite view of your wordpress content with ease.
 * Author: Andy Neale
 * Author URI: http://www.eezy.io
 * Version: 0.0.2
 * License: 	GPL3
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Infinity_Builder' ) ) :
	/**
	 * Main Infinity_Builder Instance
	 *
	 * @package Infinity_Builder
	 * @since 1.0.0
	 */
	class Infinity_Builder {

	   /**
		 * @var string Post ID of the view.
		 */
		var $id;
		/**
		 * @var string Name of view.
		 */
		var $view_name;
		/**
		 * @var array Contains the view content query.
		 */
		var $view_query;
		/**
		 * @var array Temporary query used to reset the query after each query.
		 */
		var $view_temp_query;
		/**
		 * @var string The current layout
		 */
		var $layout;
		/**
		 * @var array Meta Options Array
		 */
		var $options;

		var $count;

		var $builder_options;

		/**
		 * @var Infinity_Builder Stores the instance of this class.
		 */
		private static $instance;

		/**
		 * Infinity_Builder Instance
		 *
		 * Makes sure that there is only ever one instance of the HW Builder
		 *
		 * @since 1.0.0
		 */
		public static function instance() {

			if ( ! isset( self::$instance ) ) {

				self::$instance = new Infinity_Builder;
				self::$instance->setup_globals();
				self::$instance->includes();

			}

			return self::$instance;

	   }

		/**
		* A dummy constructor to prevent loading more than once.
		* @since 	1.0.0
	 	* @see 	Infinity_Builder::instance()
		*/
		private function __construct() {
			// Do nothing here
		}

		/**
		 * A dummy magic method to prevent Infinity_Builder from being cloned
		 */
		public function __clone() { wp_die( __( 'Cheatinâ€™ uh?' ) ); }

		/**
		 * A dummy magic method to prevent Infinity_Builder from being unserialized
		 */
		public function __wakeup() { wp_die( __( 'Cheatinâ€™ uh?' ) ); }

		/**
		 * Setup Globals
		 *
		 * @package Infinity_Builder
		 * @since 1.0.0
		 */
		private function setup_globals() {

			$this->version    	= '0.0.2';

			$this->file       = __FILE__;
			$this->basename   = plugin_basename( $this->file );
			$this->folder	   = dirname( $this->basename );
			$this->plugin_dir = plugin_dir_path( $this->file );
			$this->plugin_url = plugin_dir_url ( $this->file );
			$this->layouts_dir 	= $this->plugin_dir . 'layouts/';
			$this->styles_dir 	= $this->plugin_dir . 'styles/';

			return $this;

		}

		/**
		 * Load Includes
		 *
		 * @package Infinity_Builder
		 * @since 1.0.0
		 */
		private function includes() {

			require_once( $this->plugin_dir . 'includes/functions.php' );
			require_once( $this->plugin_dir . 'includes/assets.php' );
			require_once( $this->plugin_dir . 'includes/post-like.php' );
			require_once( $this->plugin_dir . 'includes/shortcodes.php' );
			require_once( $this->plugin_dir . 'includes/widget.php' );

			require_once( $this->plugin_dir .'includes/view-post-type.php' );

      //TODO: add admin backend post screen layouts when needed
      // if ( is_admin() ) {
      //
			// 	require( $this->plugin_dir . 'includes/admin/admin.php' );
      //
			// }

      /**
   	  * Recommend the Kirki plugin
   	  */
   	  require $this->plugin_dir . '/includes/include-kirki.php';

     	 /**
     	  * Load the Kirki Fallback class
     	  */
     	 require $this->plugin_dir . '/includes/kirki-fallback.php';

     	 /**
     	  * Customizer additions.
     	  */
     	 require $this->plugin_dir . '/includes/customizer.php';


		}

    public function getOption($option, $default="") {
      return get_option( $option, $default );
    }

    function getSerializedOption( $setting, $default, $option_name ) {
        $options = get_option( $option_name, array() );
        $value = $default;
        if ( isset( $options[ $setting ] ) ) {
            $value = $options[ $setting ];
        }
        return $value;
    }

	} //end class


	/**
	 * Return the class instance with a function and call it on the init add_action
	 */
	function views() {
	   return Infinity_Builder::instance();
	}

	add_action ( 'plugins_loaded', 'views', 1 );

endif;
