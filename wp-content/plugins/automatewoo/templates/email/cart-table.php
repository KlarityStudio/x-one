<?php
/**
 * Cart table. Can only be used with the cart.items variable
 *
 * @var array $cart_items
 * @var array $data_type
 * @var AW_Model_Abandoned_Cart $cart
 *
 * Override this template by copying it to yourtheme/automatewoo/email/cart-table.php
 *
 */

?>

<?php if ( is_array( $cart_items ) ): ?>

	<table cellspacing="0" cellpadding="6" border="1" class="aw-order-table">
		<thead>
		<tr>
			<th class="td" scope="col" colspan="2" style="text-align:left;"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="td" scope="col" style="text-align:left;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="td" scope="col" style="text-align:left;"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
		</thead>
		<tbody>

		<?php

		$total_tax = 0;
		$total = 0;
		$tax_display_cart = get_option( 'woocommerce_tax_display_cart' );

		?>


		<?php foreach ( $cart_items as $cart_item_key => $cart_item ): ?>

			<?php

			$product = wc_get_product( $cart_item['product_id'] );


			if ( $tax_display_cart === 'excl' )
			{
				$display_line_total = $cart_item['line_subtotal'];
			}
			else
			{
				$display_line_total = $cart_item['line_subtotal'] + $cart_item['line_subtotal_tax'];
			}


			$total_tax += $cart_item['line_subtotal_tax'];
			$total += $display_line_total;

			?>

			<tr>
				<td width="115">
					<a href="<?php echo $product->get_permalink() ?>"><?php echo $product->get_image( 'thumbnail' ); ?></a>
				</td>
				<td><a href="<?php echo $product->get_permalink() ?>"><?php echo $product->get_title(); ?></a></td>
				<td><?php echo $cart_item['quantity'] ?></td>
				<td><?php echo wc_price( $display_line_total ); ?></td>
			</tr>

		<?php endforeach; ?>

		</tbody>

		<tfoot>

			<?php if ( $cart->has_coupons() ): ?>
				<tr>
					<th scope="row" colspan="3">
						<?php _e('Subtotal', 'automatewoo'); ?>
						<?php if ( $tax_display_cart !== 'excl' ): ?>
							<small><?php _e( '(incl. tax)','automatewoo' ) ?></small>
						<?php endif; ?>
					</th>
					<td><?php echo wc_price( $total ); ?></td>
				</tr>
			<?php endif; ?>

			<?php foreach ( $cart->get_coupons() as $coupon_code => $coupon_data ):

				$coupon_discount = $tax_display_cart === 'excl' ? $coupon_data['discount_excl_tax'] : $coupon_data['discount_incl_tax'];
				$total -= $coupon_discount;
				$total_tax -= $coupon_data['discount_tax'];
				?>

				<tr>
					<th scope="row" colspan="3"><?php printf(__('Coupon: %s', 'automatewoo'), $coupon_code ); ?></th>
					<td><?php echo wc_price( - $coupon_discount ); ?></td>
				</tr>
			<?php endforeach; ?>

			<?php if ( $tax_display_cart === 'excl' ): ?>
				<tr>
					<th scope="row" colspan="3"><?php _e('Tax', 'automatewoo'); ?></th>
					<td><?php echo wc_price($total_tax); ?></td>
				</tr>
			<?php endif; ?>

			<tr>
				<th scope="row" colspan="3">
					<?php _e('Total', 'automatewoo'); ?>
					<?php if ( $tax_display_cart !== 'excl' ): ?>
						<small><?php printf( __( '(includes %s tax)','automatewoo' ), wc_price( $total_tax ) ) ?></small>
					<?php endif; ?>
				</th>
				<td><?php echo wc_price($total); ?></td>
			</tr>
		</tfoot>
	</table>



<?php endif; ?>