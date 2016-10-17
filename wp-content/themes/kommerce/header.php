<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <header>
      <div class="header-image" style="background-image:url(<?php echo header_image(); ?>)" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>"/>
      <?php get_template_part('includes/modules/module', 'navBar'); ?>
    </header>
  		<main id="main" class="site-main" role="main">
        <section>
          <?php get_template_part('includes/modules/module', 'slider'); ?>
        </section>
