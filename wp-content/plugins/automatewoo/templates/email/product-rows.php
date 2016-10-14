<?php
/**
 * Products items list
 *
 * Override this template by copying it to yourtheme/automatewoo/email/product-list.php
 *
 * @version 1.0.4
 */


?>

<?php if ( is_array( $products ) ): ?>

	<table cellspacing="0" cellpadding="0" style="width: 100%;" class="aw-product-rows"><tbody>

		<?php foreach ( $products as $product ): ?>
			<tr>

				<td class="image" width="25%">
					<a href="<?php echo $product->get_permalink() ?>"><?php echo $product->get_image( 'shop_catalog' ); ?></a>
				</td>

				<td>
					<h3><a href="<?php echo $product->get_permalink() ?>"><?php echo $product->get_title(); ?></a></h3>
					<p><?php echo $product->post->post_excerpt ?></p>
				</td>

				<td align="right" width="35%">
					<p class="price"><?php echo $product->get_price_html(); ?></p>
				</td>

			</tr>
		<?php endforeach; ?>

	</tbody></table>

<?php endif; ?>