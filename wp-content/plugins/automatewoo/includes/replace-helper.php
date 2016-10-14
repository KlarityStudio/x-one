<?php

/**
 * @class		AW_Replace_Helper
 * @package		AutomateWoo
 * @since		2.1.9
 */
class AW_Replace_Helper
{
	/**
	 * @var array
	 */
	public $patterns = array(
		'text_urls' => array(
			'match' => 0,
			'expression' => "/(?<!a href=\")(?<!src=\")((http|ftp)+(s)?:\/\/[^<>\s]+)/i"
		),
		'href_urls' => array(
			'match' => 1,
			'expression' => '/href=["\']?([^"\'>]+)["\']?/'
		),
		'variables' => array(
			'match' => 1,
			'expression' => '~\{\{(.*?)\}\}~'
		)
	);

	/**
	 * @var string
	 */
	public $selected_pattern;

	public $string;

	public $callback;


	/**
	 * AW_Replace_Helper constructor.
	 *
	 * @param $string
	 * @param $callback
	 * @param string $pattern_name
	 */
	function __construct( $string, $callback, $pattern_name = '' )
	{
		$this->string = $string;
		$this->callback = $callback;

		if ( $pattern_name && isset( $this->patterns[$pattern_name] ) )
		{
			$this->selected_pattern = $this->patterns[$pattern_name];
		}
	}


	/**
	 * @return mixed
	 */
	function process()
	{
		if ( ! $this->selected_pattern ) return false;

		return preg_replace_callback( $this->selected_pattern['expression'], array( $this, 'callback' ) , $this->string );
	}


	/**
	 * Pre process match before using the actual callback
	 * @param $match
	 * @return string
	 */
	function callback( $match )
	{
		if ( is_array( $match ) )
		{
			$match = $match[ $this->selected_pattern['match'] ];
		}
		return call_user_func( $this->callback, $match );
	}


}