## Kommerce

Kommerce is a basic wordpress framework intended for fast deployment of ecommerce sites.

##Notes

I have found that WooCommerce Product Stock plugin causes a http 500 error when adding a new page or post. In order to fix this, on line 230 in class-woo-product-stock-alert-admin.php, I changed $product_obj = wc_get_product($post_id); to $product_obj = new WC_Product( $post_id ); and this seems to have fixed this.
