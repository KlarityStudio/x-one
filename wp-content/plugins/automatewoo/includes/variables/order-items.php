<?php
/**
 * @class 		AW_Variable_Order_Items
 * @package		AutomateWoo/Variables
 */

class AW_Variable_Order_Items extends AW_Variable_Abstract_Product_Display
{
	/** @var string  */
	protected $name = 'order.items';

	/**
	 * Init
	 */
	function init()
	{
		parent::init();
		$this->description = __( "Displays a product listing of items in an order.", 'automatewoo');
	}


	/**
	 * @param $order WC_Order
	 * @param $parameters array
	 * @return string
	 */
	function get_value( $order, $parameters )
	{
		$template = isset( $parameters['template'] ) ? $parameters['template'] : false;
		$items = $order->get_items();
		$products = [];

		foreach ( $items as $item )
		{
			$products[] = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
		}

		return $this->get_product_display_html( $template, [
			'products' => $products,
			'data_type' => $this->get_data_type()
		]);
	}

}

return new AW_Variable_Order_Items();
