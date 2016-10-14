<?php
/**
 * Only allows a single category choice as the text variable system only supports single data items
 *
 * @class        AW_Trigger_User_Purchases_From_Category
 * @package     AutomateWoo/Triggers
 */

class AW_Trigger_User_Purchases_From_Category extends AW_Trigger
{
	public $title;

	public $name = 'user_purchases_from_category';

	public $group = 'Order';


	/**
	 * Data items that will be passed to the action
	 * @var array
	 */
	public $supplied_data_items = [ 'user', 'order', 'category', 'shop' ];


	/**
	 * Construct
	 */
	function init()
	{
		$this->title = __('Order Includes Product from a Specific Category', 'automatewoo');

		// Registers the trigger
		parent::init();
	}


	/**
	 * Add options to the trigger
	 */
	function load_fields()
	{
		$category = new AW_Field_Category();
		$category->set_description( __( 'Only trigger when the a product is purchased from a certain category.', 'automatewoo'  ) );
		$category->set_required(true);

		$order_status = new AW_Field_Order_Status( false );
		$order_status->set_required(true);
		$order_status->set_default('wc-completed');

		$this->add_field( $category );
		$this->add_field( $order_status );
	}



	/**
	 * When could this trigger run?
	 */
	function register_hooks()
	{
		add_action( 'woocommerce_order_status_changed', array( $this, 'catch_hooks' ), 100, 1 );
	}


	/**
	 * Route hooks through here
	 */
	function catch_hooks( $order_id )
	{
		$order = wc_get_order( $order_id );
		$user = AW()->order_helper->prepare_user_data_item( $order );


		$this->maybe_run(array(
			'order' => $order,
			'user' => $user
		));
	}


	/**
	 * @param $workflow AW_Model_Workflow
	 *
	 * @return bool
	 */
	function validate_workflow( $workflow )
	{
		$trigger = $workflow->get_trigger();
		$user = $workflow->get_data_item('user');
		$order = $workflow->get_data_item('order');

		if ( ! $user || ! $order )
			return false;

		if ( ! $this->validate_order_status_field( $trigger, $order ) )
			return false;


		// Validate category
		if ( $valid_category = absint( $workflow->get_trigger_option('category') ) )
		{
			foreach ( $order->get_items() as $item )
			{
				if ( $item['product_id'] > 0 )
				{
					$product_cats = get_the_terms( $item['product_id'], 'product_cat' );

					if ( ! $product_cats )
						continue;

					foreach( $product_cats as $cat )
					{
						if ( $cat->term_id == $valid_category )
						{
							// user has bought something from the valid categories
							$workflow->set_data_item('category', $cat );
							return true;
						}
					}
				}
			}
		}

		return false;
	}


}
