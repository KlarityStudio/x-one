<?php woocommerce_breadcrumb(); ?>
<section class="generic-template">
    <?php the_title('<h1>', '</h1>'); ?>
    <div class="description">
        <?php the_content(); ?>
    </div>
    <div class="form-wrapper">
        <?php echo do_shortcode('[contact-form-7 id="8" title="Contact form 1"]'); ?>
    </div>
</section>
