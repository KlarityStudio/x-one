<?php
/**
 * Maintenance mode template that's shown to logged out users.
 *
 * @package   ng-maintenance-mode
 * @copyright Copyright (c) 2015, Ashley Evans
 * @license   GPL2+
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">

		<link href='//fonts.googleapis.com/css?family=Lato:400,400italic,700|Playfair+Display' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo plugins_url( 'assets/css/maintenance.css', dirname( __FILE__ ) ); ?>">

		<title>Down for Maintenance | <?php echo esc_html( get_bloginfo( 'name' ) ); ?></title>
	</head>
	<body>
        <article>
            <div class="overlay">
                <div class="information-wrapper">
                    <div class="information-lockup">
                        <div class="global-logo"></div>
                        <h1>Coming Soon</h1>
                        <div class="logo"></div>
                        <div>
                            <p>Sign up to our newsletter and get up to 25% off</p>
                            <div class="signUp-form">
                            <!-- Begin MailChimp Signup Form -->
                                <div id="mc_embed_signup">
                                    <form action="http://x-one.us14.list-manage.com/subscribe/post?u=8e5bafcf5c088c5d1ad89ca50&amp;id=47a0686927" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                        <div id="mc_embed_signup_scroll">
                                                <div class="mc-field-group">
                                                    <input type="text" value="" name="FNAME" class="" id="mce-FNAME" placeholder="name">
                                                </div>
                                                <div class="mc-field-group">
                                                    <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="email">
                                                </div>
                                                <div id="mce-responses" class="clear">
                                                    <div class="response" id="mce-error-response" style="display:none"></div>
                                                    <div class="response" id="mce-success-response" style="display:none"></div>
                                                </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                                <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_d5a84e89a2d8d2e0ce418aea9_1c7dcb2263" tabindex="-1" value=""></div>
                                            <div class="clear"><input type="submit" value="Join" name="subscribe" id="mc-embedded-subscribe" class="button" ></div>
                                        </div>
                                    </form>
                                </div>
                            <!--End mc_embed_signup-->
                            </div>
                        </div>
                        <div class="device-lockup">
                            <div class="icon apple"></div>
                            <div class="icon android"></div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <footer>
            <script type="text/javascript">

            </script>
            <script type='text/javascript' src='http://s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
            <script type="text/javascript" src="_build/js/init.js"></script>
        </footer>
    </body>
</html>
