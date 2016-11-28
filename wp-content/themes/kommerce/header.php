<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <script async src="//cdn.trackduck.com/toolbar/prod/td.js" data-trackduck-id="583841d85a3d986a25aed941"></script>
  </head>
  <body <?php body_class(); ?>>
    <header>
      <?php get_template_part('includes/modules/module', 'navBar'); ?>

      <?php get_template_part('includes/modules/module', 'slider'); ?>

     </header>
     <main role="main" id="" >
