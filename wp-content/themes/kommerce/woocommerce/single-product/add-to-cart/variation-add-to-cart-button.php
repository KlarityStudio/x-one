<?php
/**
 * Single variation cart button
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button miles">
	<?php if ( ! $product->is_sold_individually() ) : ?>
		<?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
	<?php endif; ?>
	<div class="woocommerce-variation single_variation">
		<script type="text/template" id="tmpl-variation-template">
			<div class="woocommerce-variation-description">
				{{{ data.variation.variation_description }}}
			</div>

			<div class="woocommerce-variation-price">
				{{{ data.variation.price_html }}}
			</div>

			<div class="woocommerce-variation-availability">
				{{{ data.variation.availability_html }}}
			</div>
		</script>
		<script type="text/template" id="tmpl-unavailable-variation-template">
			<p><?php _e( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ); ?></p>
		</script>
	</div>
	<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
