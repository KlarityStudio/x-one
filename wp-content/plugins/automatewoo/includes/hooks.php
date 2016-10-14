<?php
/**
 * @class 		AW_Hooks
 * @package		AutomateWoo
 * @since		2.6.7
 */

class AW_Hooks
{
	/**
	 * Add 'init' actions here means we can load less files at 'init'
	 */
	function __construct()
	{
		add_action( 'automatewoo/background_process', [ $this , 'background_process' ], 10, 3 );
		add_action( 'automatewoo/addons/activate', [ $this , 'activate_addon' ] );
	}


	/**
	 * @param $hook
	 * @param $batch
	 * @param $args
	 */
	function background_process( $hook, $batch, $args )
	{
		AW_Background_Process_Handler::handle( $hook, $batch, $args );
	}


	/**
	 * @param $addon_id
	 */
	function activate_addon( $addon_id )
	{
		if ( $addon = AW()->addons()->get( $addon_id ) )
		{
			$addon->activate();
		}
	}

}
