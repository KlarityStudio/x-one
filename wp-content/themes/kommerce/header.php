<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
        <!--  Google Analytics start -->
        <script>

          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-88572818-1', 'auto');

          ga('send', 'pageview');

        </script>
        <!--  Google Analytics end -->
        <!-- Hotjar Tracking Code for http://x-one.co.za/ -->
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:372246,hjsv:5};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
        <script type="application/ld+json">
            { "@context": "http://schema.org",
                "@type": "Organization",
                "name": "X-ONE",
                "legalName" : "X-ONE",
                "url": "<?php echo get_site_url()?>",
                "logo": "<?php echo get_site_url() . '/wp-content/uploads/2016/10/cropped-logo.png'?>",
                "address": {
                "@type": "PostalAddress",
                "addressLocality": "Cape Town",
                "addressRegion": "WC",
                "postalCode": "8001",
                "addressCountry": "ZAR"
            },
                "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "customer service",
                "telephone": "",
                "email": "contact@xone.co.za"
            },
            "sameAs": [
                "http://www.facebook.com/xone",
                "http://www.twitter.com/xone"
            ]}
        </script>
  </head>
  <body <?php body_class(); ?>>
      <div class="wrapper">
        <header>
          <?php get_template_part('includes/modules/module', 'navBar'); ?>
            <?php if(is_front_page() ): ?>
                <?php get_template_part('includes/modules/module', 'slider'); ?>
            <?php elseif(is_page() && ! is_single('product') ): ?>
                <!-- <div class="header-image">

                </div> -->

            <?php endif; ?>
         </header>
         <main role="main" id="" >
