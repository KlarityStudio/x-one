<?php
/**
 * @class       AW_Abandoned_Cart_Manager
 * @package     AutomateWoo
 */

class AW_Abandoned_Cart_Manager
{
	/** @var bool - used when restoring carts so that we don't fire unnecessary db queries */
	public $_prevent_store_cart = false;


	/**
	 * Constructor
	 */
	function __construct()
	{
		add_action( 'automatewoo_two_days_worker', array( $this, 'clean_stored_carts' ) );

		if ( AW()->options()->abandoned_cart_enabled )
		{
			add_action( 'wp_loaded', array( $this, 'catch_restore_cart_link' ) );

			// set action priority to be after calculate totals
			add_action( 'woocommerce_add_to_cart', array( $this, 'maybe_store_cart' ), 30 );
			add_action( 'woocommerce_cart_item_removed', array( $this, 'maybe_store_cart' ) );
			add_action( 'woocommerce_cart_item_restored', array( $this, 'maybe_store_cart' ) );
			add_action( 'woocommerce_after_cart_item_quantity_update', array( $this, 'maybe_store_cart' ) );
			add_action( 'woocommerce_applied_coupon', array( $this, 'maybe_store_cart' ), 30 );
			add_action( 'woocommerce_removed_coupon', array( $this, 'maybe_store_cart' ), 30 );

			add_action( 'wp_login', array( $this, 'wp_login' ), 10, 2 );

			add_action( 'woocommerce_cart_emptied', array( $this, 'cart_emptied' ) );
			add_action( 'woocommerce_checkout_order_processed', array( $this, 'empty_after_order_created' ) );

			add_action( 'wp_footer', array( $this, 'js' ) );
		}
	}


	/**
	 * Logic to determine whether we should save the cart on certain hooks
	 */
	function maybe_store_cart()
	{
		if ( $this->_prevent_store_cart )
			return;

		if ( $user_id = AW()->session_tracker->get_detected_user_id() )
		{
			$this->store_user_cart( $user_id );
		}
		elseif ( $guest = AW()->session_tracker->get_current_guest() )
		{
			// Store a guest cart if the guest has been stored in the database
			$this->store_guest_cart( $guest );

			$guest->update_last_active();
		}
	}


	/**
	 * Clear the stored guest before their cookie key is updated.
	 * Store the cart upon login
	 */
	function wp_login( $user_login, $user )
	{
		$guest = new AW_Model_Guest();
		$guest->get_by( 'tracking_key', AW()->session_tracker->get_tracking_key() );

		// if a guest cart exists delete it and store it as a user cart
		if ( $guest->exists )
		{
			$guest->delete_cart();
			$guest->delete();

			$this->store_user_cart( $user->ID );
		}
	}




	/**
	 * Attempts to update or insert carts for guests
	 *
	 * @param AW_Model_Guest $guest
	 *
	 * @return bool
	 */
	function store_guest_cart( $guest )
	{
		if ( ! $guest )
			return false;

		$cart = $guest->get_cart();

		if ( $cart )
		{
			if ( 0 === sizeof( WC()->cart->get_cart() ) )
				$cart->delete();
			else
				$cart->sync();
		}
		else
		{
			// cart is empty
			if ( 0 === sizeof( WC()->cart->get_cart() ) )
				return false;

			// create new cart
			$ac = new AW_Model_Abandoned_Cart();
			$ac->guest_id = $guest->id;
			$ac->set_token();
			$ac->sync();
		}

		return true;
	}


	/**
	 * Attempts to store cart for a registered user whether they are logged in or not
	 *
	 * Won't store empty carts.
	 *
	 * @param bool $user_id
	 *
	 * @return bool|int
	 */
	function store_user_cart( $user_id = false )
	{
		if ( ! $user_id )
		{
			// get user
			if ( ! $user_id = AW()->session_tracker->get_detected_user_id() )
				return false;
		}


		// does this user already have a stored cart?
		$existing_ac = new AW_Model_Abandoned_Cart();
		$existing_ac->get_by( 'user_id', $user_id );

		// if cart already exists
		if ( $existing_ac->exists )
		{
			// delete cart if empty otherwise update it
			if ( 0 === sizeof( WC()->cart->get_cart() ) )
				$existing_ac->delete();
			else
				$existing_ac->sync();

			return true;
		}
		else
		{
			// if the cart doesn't already exist
			// and there are no items in cart no there is no need to insert
			if ( 0 === sizeof( WC()->cart->get_cart() ) )
				return false;

			// create a new stored cart for the user
			$ac = new AW_Model_Abandoned_Cart();
			$ac->user_id = $user_id;
			$ac->set_token();
			$ac->sync();

			return true;
		}

	}


	/**
	 * This event will fire when an order is placed and the cart is emptied NOT when a user empties their cart.
	 */
	function cart_emptied()
	{
		$guest = AW()->session_tracker->get_current_guest();
		$user_id = AW()->session_tracker->get_detected_user_id();

		if ( $user_id )
		{
			$cart = new AW_Model_Abandoned_Cart();
			$cart->get_by( 'user_id', $user_id );
			$cart->delete();
		}

		if ( $guest )
		{
			// Ensure carts are cleared for users and guests registered at checkout
			$guest->delete_cart();
		}
	}


	/**
	 * Ensure the stored abandoned cart is removed when an order is created
	 *
	 * Clears even if payment has not gone through
	 *
	 * @param $order_id
	 */
	function empty_after_order_created( $order_id )
	{
		$order = wc_get_order( $order_id );

		$user_id = $order->get_user_id();

		if ( $user_id > 0 )
		{
			$cart = new AW_Model_Abandoned_Cart();
			$cart->get_by( 'user_id', $user_id );
			$cart->delete();
		}

		// order placed by a guest or by a guest that signed up at checkout

		$guest = new AW_Model_Guest();
		$guest->get_by( 'email', $order->billing_email );
		$guest->delete_cart();

		// Delete cart by guest cookie key
		if ( $guest = AW()->session_tracker->get_current_guest() )
		{
			$guest->delete_cart();
		}
	}



	/**
	 * Add ajax email capture to checkout
	 */
	function js()
	{
		switch( AW()->options()->guest_email_capture_scope )
		{
			case 'none': return; break;
			case 'checkout':
				if ( ! is_checkout() ) return;
				break;
		}

		$selectors = apply_filters( 'automatewoo/guest_capture_fields', [
			'#billing_email',
			'.automatewoo-capture-guest-email'
		]);

		?>
			<script type="text/javascript">
				(function($){

					var email = '';

					$(document).on('blur', '<?php echo implode( ', ', $selectors ) ?>', function(){

						// hasn't changed
						if ( email == $(this).val() ) {
							return;
						}

						email = $(this).val();

						$.ajax({
							method: "POST",
							url: '<?php echo esc_js( admin_url( 'admin-ajax.php', 'relative' ) ) ?>',
							cache: false,
							data: {
								action: 'aw_capture_email',
								email: email
								<?php if ( AW()->integrations()->is_wpml() ): ?>
									,language: '<?php echo esc_js( wpml_get_current_language() ) ?>'
								<?php endif; ?>
							}
						});

					});

				})(jQuery);
			</script>
		<?php
	}



	/**
	 * Restores a cart when URL is clicked
	 */
	function catch_restore_cart_link()
	{
		$cart_token = aw_clean( aw_request('aw-restore-cart') );

		if ( ! $cart_token )
			return;

		$cart = new AW_Model_Abandoned_Cart();
		$cart->get_by( 'token', $cart_token );

		if ( ! $cart->exists || ! is_array( $cart->items ) )
			return;


		// block cart storage hooks
		$this->_prevent_store_cart = true;
		$notices_backup = wc_get_notices();


		// merge restored items with existing
		$existing_items = WC()->cart->get_cart_for_session();

		foreach ( $cart->get_items() as $item_key => $item )
		{
			// item already exists in cart
			if ( isset( $existing_items[$item_key] ) )
				continue;

			WC()->cart->add_to_cart( $item['product_id'], $item['quantity'], $item['variation_id'], $item['variation']  );
		}

		// restore coupons
		foreach ( $cart->get_coupons() as $coupon_code => $coupon_data )
		{
			if ( ! WC()->cart->has_discount( $coupon_code ) )
			{
				WC()->cart->add_discount( $coupon_code );
			}
		}


		// clear show notices for added coupons or products
		wc_set_notices( $notices_backup );

		// unblock cart storing and store the restored cart
		$this->_prevent_store_cart = false;
		$this->maybe_store_cart();


		wp_redirect(add_query_arg([
			'aw-cart-restored' => 1
		], wc_get_page_permalink('cart') ) );

		exit;
	}



	/**
	 * Delete stored carts older than 45 days
	 */
	function clean_stored_carts()
	{
		global $wpdb;

		$delay_date = new DateTime(); // UTC
		$delay_date->setTimestamp( current_time('timestamp', true ) );
		$delay_date->modify("-45 days");

		$wpdb->query( $wpdb->prepare("
			DELETE FROM ". $wpdb->prefix . AW()->table_name_abandoned_cart . "
			WHERE last_modified < %s",
			$delay_date->format('Y-m-d H:i:s')
		));
	}

}
