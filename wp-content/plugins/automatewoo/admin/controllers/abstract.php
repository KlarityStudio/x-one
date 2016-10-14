<?php
/**
 * @class 		AW_Admin_Controller_Abstract
 * @package		AutomateWoo/Admin/Controllers
 * @since		2.4.5
 */

abstract class AW_Admin_Controller_Abstract
{
	/** @var array */
	static $messages = [];

	/** @var array  */
	static $errors = [];

	/** @var string */
	static $default_route = 'list';


	/**
	 *
	 */
	static function output_messages()
	{
		if ( sizeof( self::$errors ) > 0 )
		{
			foreach ( self::$errors as $error )
			{
				echo '<div class="error"><p><strong>' . esc_html( $error ) . '</strong></p></div>';
			}
		} elseif ( sizeof( self::$messages ) > 0 )
		{
			foreach ( self::$messages as $message )
			{
				echo '<div class="updated"><p><strong>' . esc_html( $message ) . '</strong></p></div>';
			}
		}
	}


	/**
	 *
	 */
	static function get_current_route()
	{
		if ( $action = aw_clean( aw_request( 'action' ) ) )
			return $action;

		return self::$default_route;
	}

}
