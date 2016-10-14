<?php
/**
 * Track guests across sessions via cookies. Store their info in the database.
 *
 * @class 		AW_Session_Tracker
 */

class AW_Session_Tracker
{
	/** @var int (days) */
	private $tracking_cookie_expiry;

	/** cookie name */
	private $tracking_key_cookie_name;

	/** @var string */
	private $tracking_key;

	/** @var int */
	private $user_id = 0;

	/** @var bool */
	private $_user_id_loaded = false;

	/** @var AW_Model_Guest */
	private $guest;

	/** @var bool */
	private $_guest_loaded = false;

	/** @var bool */
	private $tracking_key_to_set = false;


	/**
	 * Construct
	 */
	function __construct()
	{
		$this->tracking_key_cookie_name = apply_filters( 'automatewoo/session_tracker/cookie_name', 'wp_automatewoo_visitor_' . COOKIEHASH );
		$this->tracking_cookie_expiry = apply_filters('automatewoo_visitor_tracking_cookie_expiry', 730 ); // 2 years

		add_action( 'wp', array( $this, 'maybe_set_session_cookies' ), 99 );
		add_action( 'shutdown', array( $this, 'maybe_set_session_cookies' ), 0 );

		// automatically init session at login
		add_action( 'wp_login', array( $this, 'init_session' ) );

		add_action( 'comment_post', array( $this, 'capture_from_comment' ), 10, 2 );
		add_action( 'automatewoo_capture_guest_email', array( $this, 'store_guest' ) ); // for third-party
	}


	/**
	 *
	 */
	function init_session()
	{
		if ( did_action( 'automatewoo_session_initiated' ) )
			return;

		$cookie_key = isset( $_COOKIE[$this->tracking_key_cookie_name] ) ? aw_clean( $_COOKIE[$this->tracking_key_cookie_name] ) : false;

		if ( is_user_logged_in() )
		{
			$database_key = get_user_meta( get_current_user_id(), 'automatewoo_visitor_key', true );

			// is tracking cookie set?
			if ( $cookie_key )
			{
				if ( $database_key )
				{
					if ( $database_key != $cookie_key )
					{
						// if a database key exists but is different from the cookie key, update the cookie key
						$this->tracking_key_to_set = $database_key;
					}
					else
					{
						// cookie and db match
						$this->tracking_key = $database_key;
					}
				}
				else
				{
					// cookie key exists but is not in db yet

					// before storing remove this key from any other users
					// ensures anyone with multiple user accounts always has the session key attached to their most recent login
					delete_metadata( 'user', get_current_user_id(), 'automatewoo_visitor_key', $cookie_key, true );

					update_user_meta( get_current_user_id(), 'automatewoo_visitor_key', $cookie_key );
					$this->tracking_key = $cookie_key;
				}
			}
			elseif ( $database_key )
			{
				// no cookie key set but there is a database key so lets use that
				$this->tracking_key_to_set = $database_key;
			}
			else
			{
				// no cookie key or stored key, lets generate a new one
				$this->tracking_key_to_set = $this->generate_key();
				update_user_meta( get_current_user_id(), 'automatewoo_visitor_key', $this->tracking_key_to_set );
			}
		}
		else
		{
			if ( $cookie_key )
			{
				// guest has cookie key so use it
				$this->tracking_key = $cookie_key;
			}
			else
			{
				// guest has no cookie so generate one
				$this->tracking_key_to_set = $this->generate_key();
			}
		}


		// is this a new session?
		if ( empty( $_COOKIE[ 'wp_automatewoo_session_started' ] ) )
		{
			do_action( 'automatewoo_new_session_initiated' );
		}

		do_action( 'automatewoo_session_initiated' );
	}


	/**
	 *
	 */
	function maybe_set_session_cookies()
	{
		if ( $this->is_possible_to_set_cookies() && $this->tracking_key_to_set )
		{
			$this->tracking_key = $this->tracking_key_to_set;
			$this->tracking_key_to_set = false;

			wc_setcookie( $this->tracking_key_cookie_name, $this->tracking_key, time() + 60 * 60 * 24 * $this->tracking_cookie_expiry );
			wc_setcookie( 'wp_automatewoo_session_started', 1 );
		}
	}


	/**
	 * @return bool
	 */
	function is_possible_to_set_cookies()
	{
		return ! headers_sent();
	}


	/**
	 * Returns false if not id is set
	 *
	 * @return string|false
	 */
	function get_tracking_key()
	{
		$this->init_session();

		if ( $this->tracking_key )
			return $this->tracking_key;

		if ( $this->tracking_key_to_set && $this->is_possible_to_set_cookies() )
			return $this->tracking_key_to_set;
	}



	/**
	 * @return string
	 */
	function generate_key()
	{
		return aw_generate_key( 32 );
	}


	/**
	 * Detect the user id based from their visitor id
	 *
	 * Returns false if no use is detected.
	 *
	 * @return int|false
	 */
	function get_detected_user_id()
	{
		if ( is_user_logged_in() )
			return get_current_user_id();

		if ( $this->_user_id_loaded )
			return $this->user_id;

		$this->init_session();

		// only search for existing tracking keys not newly set ones
		if ( $this->tracking_key )
		{
			$user_query = new WP_User_Query(array(
				'meta_query' => array(
					array(
						'key' => 'automatewoo_visitor_key',
						'value' => $this->tracking_key
					)
				),
				'fields' => 'ids'
			));

			$results = $user_query->get_results();

			if ( ! empty( $results ) )
			{
				$this->user_id = $results[0];
			}
		}

		$this->_user_id_loaded = true;
		return $this->user_id;
	}


	/**
	 * @return AW_Model_Guest|bool
	 */
	function get_current_guest()
	{
		if ( ! $this->_guest_loaded && $tracking_key = $this->get_tracking_key() )
		{
			$guest = new AW_Model_Guest();
			$guest->get_by( 'tracking_key', $tracking_key );

			if ( $guest->exists )
			{
				$this->guest = $guest;
			}

			$this->_guest_loaded = true;
		}

		return $this->guest;
	}


	/**
	 * Store the guest against the current session key
	 * Also can be used to update the current guest's email
	 *
	 * @param $email
	 * @param bool $language
	 * @return AW_Model_Guest|false
	 */
	function store_guest( $email, $language = false )
	{
		if ( ! is_email( $email ) || is_user_logged_in() )
			return false;

		// if there is no tracking key or no ability to set one there is no point storing the guest
		if ( ! $tracking_key = $this->get_tracking_key() )
			return false;

		$email = strtolower( sanitize_email( $email ) );

		// Check if the guest already being tracked
		$guest = $this->get_current_guest();

		if ( $guest )
		{
			// update email if changed
			if ( $guest->email !== $email )
				$guest->email = $email;


			$guest->save();

			return $guest;
		}
		else
		{
			// creating a new guest but first check if the guest email is already stored
			$stored_new_guest = false;

			$guest = new AW_Model_Guest();
			$guest->get_by( 'email', $email );

			if ( $guest->exists )
			{
				// guest email is stored already so update the current session tracking key to match
				$this->tracking_key_to_set = $guest->tracking_key;
			}
			else
			{
				$guest->set_email( $email );
				$guest->set_tracking_key( $tracking_key );
				$guest->set_created( current_time( 'mysql', true ) );
				$stored_new_guest = true;
			}

			$guest->set_last_active( current_time( 'mysql', true ) );

			if ( $language )
			{
				$guest->set_language( $language );
			}

			$guest->save();


			// save the cart
			if ( AW()->options()->abandoned_cart_enabled )
			{
				AW()->abandoned_cart->store_guest_cart( $guest );
			}


			if ( $stored_new_guest )
			{
				// fire hook after new guest is saved
				do_action( 'automatewoo/session_tracker/new_stored_guest', $guest );
			}

			return $guest;
		}
	}


	/**
	 * Store guest info if they place a comment
	 * @param $comment_ID
	 */
	function capture_from_comment( $comment_ID )
	{
		$comment = get_comment( $comment_ID );

		if ( $comment && ! $comment->user_id )
		{
			$this->store_guest( $comment->comment_author_email );
		}

	}

}