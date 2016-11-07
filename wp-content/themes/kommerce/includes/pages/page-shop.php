
<?php // Display blog posts @ http://blog:8888/blog
$parentid = get_queried_object_id();

$args = array(
  'parent' => $parentid
);

$terms = get_terms( 'product_cat', $args );

if ( $terms ) { ?>

    <ul class="product-cats">

     <?php foreach ( $terms as $term ) {
  			$src = wp_get_attachment_image_src( get_post_thumbnail_id($term->ID), array( 5600, 1000), false);
            $description = wc_format_content( term_description($term) )
          ?>
        <a href=" <?php echo esc_url( get_term_link( $term ) ); ?>" class="<?php $term->slug; ?>">
          <li class="category">
              <div class="category-image">
                  <?php  woocommerce_subcategory_thumbnail( $term ); ?>
              </div>
              <h2><?php echo $term->name; ?></h2>
              <div class="">
                  <?php echo $term->description; ?>
              </div>
          </li>
        </a>
  <?php } ?>

    </ul>

<?php
    get_template_part('includes/modules/module', 'latestProducts');
}
