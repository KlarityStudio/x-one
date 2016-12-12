<?php

    /**
     * WC_Gateway_Sagepay_Form class.
     *
     * @extends WC_Payment_Gateway
     */
    class WC_Gateway_Sagepay_Form extends WC_Payment_Gateway {
		/**
    	 * [$sage_cardtypes description]
    	 * Set up accepted card types for card type drop down
    	 * From Version 3.3.0
    	 * @var array
    	 */
        var $sage_cardtypes = array(
        			'MasterCard'		=> 'MasterCard',
					'MasterCard Debit'	=> 'MasterCard Debit',
					'Visa'				=> 'Visa',
					'Visa Debit'		=> 'Visa Debit',
					'Discover'			=> 'Discover',
					'American Express' 	=> 'American Express',
					'Maestro'			=> 'Maestro',
					'JCB'				=> 'JCB',
					'Laser'				=> 'Laser'
				);
        /**
         * __construct function.
         *
         * @access public
         * @return void
         */
        public function __construct() {

            $this->id                   = 'sagepayform';
            $this->method_title         = __( 'SagePay Form', 'woocommerce_sagepayform' );
            $this->method_description   = $this->sagepay_system_status();
            $this->icon                 = apply_filters( 'wc_sagepayform_icon', '' );
            $this->has_fields           = false;
            $this->liveurl              = 'https://live.sagepay.com/gateway/service/vspform-register.vsp';
            $this->testurl              = 'https://test.sagepay.com/gateway/service/vspform-register.vsp';
            $this->simurl               = 'https://test.sagepay.com/Simulator/VSPFormGateway.asp';

            $this->successurl 			= WC()->api_request_url( get_class( $this ) );

            // Default values
			$this->default_enabled				= 'no';
			$this->default_title 				= __( 'Credit Card via SagePay', 'woocommerce_sagepayform' );
			$this->default_description  		= __( 'Pay via Credit / Debit Card with SagePay secure card processing.', 'woocommerce_sagepayform' );
			$this->default_order_button_text  	= __( 'Pay securely with SagePay', 'woocommerce_sagepayform' );
  			$this->default_status				= 'testing';
  			$this->default_cardtypes			= '';
  			$this->default_protocol				= '3.00';
  			$this->default_vendor				= '';
			$this->default_vendorpwd			= '';
			$this->default_testvendorpwd		= '';
			$this->default_simvendorpwd 		= '';
			$this->default_email				= get_bloginfo('admin_email');
			$this->default_sendemail			= '1';
			$this->default_txtype				= 'PAYMENT';
			$this->default_allow_gift_aid		= 'yes';
			$this->default_apply_avs_cv2		= '0';
			$this->default_apply_3dsecure		= '0';
			$this->default_debug 				= false;
			$this->default_sagelink				= 0;
			$this->default_sagelogo				= 0;
            $this->default_vendortxcodeprefix   = 'wc_';

			$this->default_enablesurcharges 	= 'no';
			$this->default_VISAsurcharges   	= '';
			$this->default_DELTAsurcharges  	= '';
			$this->default_UKEsurcharges   		= '';
			$this->default_MCsurcharges   		= '';
			$this->default_MCDEBITsurcharges   	= '';
			$this->default_MAESTROsurcharges   	= '';
			$this->default_AMEXsurcharges   	= '';
			$this->default_DCsurcharges   		= '';
			$this->default_JCBsurcharges   		= '';
			$this->default_LASERsurcharges   	= '';

            // ReferrerID
            $this->referrerid 			= 'F4D0E135-F056-449E-99E0-EC59917923E1';

            // Load the form fields
            $this->init_form_fields();

            // Load the settings.
            $this->init_settings();

            // Get setting values
            $this->enabled         		= isset( $this->settings['enabled'] ) && $this->settings['enabled'] == 'yes' ? 'yes' : $this->default_enabled;
            $this->title 				= isset( $this->settings['title'] ) ? $this->settings['title'] : $this->default_title;
			$this->description  		= isset( $this->settings['description'] ) ? $this->settings['description'] : $this->default_description;
			$this->order_button_text  	= isset( $this->settings['order_button_text'] ) ? $this->settings['order_button_text'] : $this->default_order_button_text;
  			$this->status				= isset( $this->settings['status'] ) ? $this->settings['status'] : $this->default_status;
            $this->cardtypes			= isset( $this->settings['cardtypes'] ) ? $this->settings['cardtypes'] : $this->default_cardtypes;
            $this->protocol 			= $this->default_protocol;
            $this->vendor           	= isset( $this->settings['vendor'] ) ? $this->settings['vendor'] : $this->default_vendor;
            $this->vendorpwd        	= isset( $this->settings['vendorpwd'] ) ? $this->settings['vendorpwd'] : $this->default_vendorpwd;
            $this->testvendorpwd    	= isset( $this->settings['testvendorpwd'] ) ? $this->settings['testvendorpwd'] : $this->default_testvendorpwd;
            $this->simvendorpwd     	= isset( $this->settings['simvendorpwd'] ) ? $this->settings['simvendorpwd'] : $this->default_simvendorpwd;
            $this->email            	= isset( $this->settings['email'] ) ? $this->settings['email'] : $this->default_email;
            $this->sendemail        	= isset( $this->settings['sendemail'] ) ? $this->settings['sendemail'] : $this->default_sendemail;
            $this->txtype           	= isset( $this->settings['txtype'] ) ? $this->settings['txtype'] : $this->default_txtype;
            $this->allow_gift_aid   	= isset( $this->settings['allow_gift_aid'] ) && $this->settings['allow_gift_aid'] == 'yes' ? 1 : 0;
            $this->apply_avs_cv2    	= isset( $this->settings['apply_avs_cv2'] ) ? $this->settings['apply_avs_cv2'] : $this->default_apply_avs_cv2;
            $this->apply_3dsecure   	= isset( $this->settings['apply_3dsecure'] ) ? $this->settings['apply_3dsecure'] : $this->default_apply_3dsecure;
            $this->debug				= isset( $this->settings['debugmode'] ) && $this->settings['debugmode'] == 'yes' ? true : $this->default_debug;
            $this->sagelink				= isset( $this->settings['sagelink'] ) && $this->settings['sagelink'] == 'yes' ? '1' : $this->default_sagelink;
            $this->sagelogo				= isset( $this->settings['sagelogo'] ) && $this->settings['sagelogo'] == 'yes' ? '1' : $this->default_sagelogo;
            $this->vendortxcodeprefix   = isset( $this->settings['vendortxcodeprefix'] ) ? $this->settings['vendortxcodeprefix'] : $this->default_vendortxcodeprefix;

            $this->enablesurcharges 	= isset( $this->settings['enablesurcharges'] ) && $this->settings['enablesurcharges'] == 'yes' ? 'yes' : $this->default_enablesurcharges;
			$this->VISAsurcharges   	= isset( $this->settings['visasurcharges'] ) ? $this->settings['visasurcharges'] : $this->default_VISAsurcharges;
			$this->DELTAsurcharges  	= isset( $this->settings['visadebitsurcharges'] ) ? $this->settings['visadebitsurcharges'] : $this->default_DELTAsurcharges;
			$this->UKEsurcharges   		= isset( $this->settings['visaelectronsurcharges'] ) ? $this->settings['visaelectronsurcharges'] : $this->default_UKEsurcharges;
			$this->MCsurcharges   		= isset( $this->settings['mcsurcharges'] ) ? $this->settings['mcsurcharges'] : $this->default_MCsurcharges;
			$this->MCDEBITsurcharges   	= isset( $this->settings['mcdebitsurcharges'] ) ? $this->settings['mcdebitsurcharges'] : $this->default_MCDEBITsurcharges;
			$this->MAESTROsurcharges   	= isset( $this->settings['maestrosurcharges'] ) ? $this->settings['maestrosurcharges'] : $this->default_MAESTROsurcharges;
			$this->AMEXsurcharges   	= isset( $this->settings['amexsurcharges'] ) ? $this->settings['amexsurcharges'] : $this->default_AMEXsurcharges;
			$this->DCsurcharges   		= isset( $this->settings['dinerssurcharges'] ) ? $this->settings['dinerssurcharges'] : $this->default_DCsurcharges;
			$this->JCBsurcharges   		= isset( $this->settings['jcbsurcharges'] ) ? $this->settings['jcbsurcharges'] : $this->default_JCBsurcharges;
			$this->LASERsurcharges   	= isset( $this->settings['lasersurcharges'] ) ? $this->settings['lasersurcharges'] : $this->default_LASERsurcharges;

			$this->link 				= 'http://www.sagepay.co.uk/support/online-shoppers/about-sage-pay';
			

			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

			/**
			 *  API
			 *  
			 *  woocommerce_api_{lower case class name}
			 */
            add_action( 'woocommerce_api_wc_gateway_sagepay_form', array( $this, 'check_sagepay_response' ) );

            add_action( 'valid_sagepayform_request', array( $this, 'successful_request' ) );
            add_action( 'woocommerce_receipt_sagepayform', array( $this, 'receipt_page' ) );

            // Supports
            $this->supports = array(
            						'products',
							);

            // Logs
			if ( $this->debug ) {
				$this->log = new WC_Logger();
			}

			// WC version
			$this->wc_version = get_option( 'woocommerce_version' );

            // Add test card info to the description if in test mode
            if ( $this->status != 'live' ) {
                $this->description .= ' ' . sprintf( __( '<br /><br />TEST MODE ENABLED.<br />In test mode, you can use Visa card number 4929000000006 with any CVC and a valid expiration date or check the documentation (<a href="%s">Test card details for your test transactions</a>) for more card numbers.<br /><br />3D Secure password is "password"', 'woocommerce_sagepayform' ), 'http://www.sagepay.co.uk/support/12/36/test-card-details-for-your-test-transactions' );
                $this->description  = trim( $this->description );
            }

        } // END __construct

        /**
         * init_form_fields function.
         *
         * @access public
         * @return void
         */
        function init_form_fields() {

        	include ( SAGEPLUGINPATH . 'includes/sagepay-form-admin.php' );

        } // END init_form_fields

		/**
		 * Returns the plugin's url without a trailing slash
		 */
		public function get_plugin_url() {

			return str_replace( '/classes', '/', untrailingslashit( plugins_url( '/', __FILE__ ) ) );

		}

		/**
		 * [get_icon description] Add selected card icons to payment method label, defaults to Visa/MC/Amex/Discover
		 * @return [type] [description]
		 */
		public function get_icon() {
			return WC_Sagepay_Common_Functions::get_icon( $this->cardtypes, $this->sagelink, $this->sagelogo, $this->id );
		}

        /**
         * Generate the form button
         */
        public function generate_sagepay_form( $order_id ) {
            global $woocommerce;

            $order = new WC_Order( $order_id );

            wc_enqueue_js('
				jQuery("body").block({
					message: "<img src=\"' . esc_url( apply_filters( 'woocommerce_ajax_loader_url', $woocommerce->plugin_url() . '/assets/images/select2-spinner.gif' ) ) . '\" alt=\"Redirecting&hellip;\" style=\"float:left; margin-right: 10px;\" />'.__('Thank you for your order. We are now redirecting you to SagePay to make payment.', 'woocommerce_sagepayform').'",
					overlayCSS:
					{
						background: "#fff",
						opacity: 0.6
					},
					css: {
			       		padding:        20,
			        	textAlign:      "center",
			        	color:          "#555",
			        	border:         "3px solid #aaa",
			        	backgroundColor:"#fff",
			        	cursor:         "wait",
			        	lineHeight:		"32px"
			    	}
				});
				jQuery("#submit_sagepayform_payment_form").click();
			');

            if ( $this->status == 'testing' ) {
                $sagepayform_adr = $this->testurl;
            } elseif ( $this->status == 'sim' ) {
                $sagepayform_adr = $this->simurl;
            } else {
                $sagepayform_adr = $this->liveurl;
            }

            // Post Test Only
            // $sagepayform_adr = 'https://test.sagepay.com/showpost/showpost.asp';

            $sagepayform  = '<input type="hidden" name="VPSProtocol" value="' . $this->protocol . '" />';

            $sagepayform .= '<input type="hidden" name="TxType" value="' . $this->txtype . '" />';
            $sagepayform .= '<input type="hidden" name="Vendor" value="' . $this->vendor . '" />';

			/**
			 * Setup the surcharges if necessary
			 */
			$surchargexml = ''; 
			if ( $this->enablesurcharges == 'yes' ) {
				$cardtypes = array(
									'VISAsurcharges',
									'DELTAsurcharges',
									'UKEsurcharges',
									'MCsurcharges',
									'MCDEBITsurcharges',
									'MAESTROsurcharges',
									'AMEXsurcharges',
									'DCsurcharges',
									'JCBsurcharges',
									'LASERsurcharges'
									);

				$surchargexml = '<surcharges>' . "\r\n";
				
				// Set up arrays for str_replace
				$surchargeType = array('F','P');
				$surchargeTypeReplacement = array('fixed','percentage');
				
				foreach ( $cardtypes as $cardtype ) :
				
					if ( $this->$cardtype != '' ) {
						
						$surchargevalue = explode( '|',$this->$cardtype );
						
						$surchargexml .= '<surcharge>' . "\r\n";
						$surchargexml .= '<paymentType>' . str_replace( 'surcharges','',$cardtype ) . '</paymentType>' . "\r\n";
						$surchargexml .= '<' . str_replace($surchargeType,$surchargeTypeReplacement,$surchargevalue[0]). '>' . 
												$surchargevalue[1] . 
										 '</' .str_replace($surchargeType,$surchargeTypeReplacement,$surchargevalue[0]). '>' . "\r\n";
						$surchargexml .= '</surcharge>' . "\r\n";

					}
				
				endforeach;
				
				$surchargexml .= '</surcharges>' . "\r\n";
				
			}

            if ( $order->billing_country == 'US' ) {
                $billing_state = $order->billing_state;
            } else {
                $billing_state = '';
        	}

            if ( $order->shipping_country == 'US' ) {
                $shipping_state = $order->shipping_state;
            } else {
                $shipping_state = '';
            }

            // Build VendorTXCode
            $vendortxcode = WC_Sagepay_Common_Functions::build_vendortxcode( $order, $this->id, $this->vendortxcodeprefix );

            // Bring it all together into one string
            $sage_pay_args_array = array(
                'VendorTxCode'      => $vendortxcode,
                'Amount'            => $order->get_total(),
                'Currency'          => get_woocommerce_currency(),
                'Description'       => __( 'Order', 'woocommerce_sagepayform' ) . ' ' . str_replace( '#' , '' , $order->get_order_number() ),
                'SuccessURL'        => str_replace( 'https:', 'http:', $this->successurl ),
                'FailureURL'        => apply_filters( 'woocommerce_sagepayform_cancelurl' , html_entity_decode( $order->get_cancel_order_url() ), $order_id, $order->order_key ),
                'CustomerName'      => $order->billing_first_name . ' ' . $order->billing_last_name,
                'CustomerEMail'     => $order->billing_email,
                'VendorEMail'       => $this->email,
                'SendEMail'         => $this->sendemail,

                // Billing Address info
                'BillingFirstnames' => $order->billing_first_name,
                'BillingSurname'    => $order->billing_last_name,
                'BillingAddress1'   => $order->billing_address_1,
                'BillingAddress2'   => $order->billing_address_2,
                'BillingCity'       => $order->billing_city,
                'BillingState'      => $billing_state,
                'BillingPostCode'   => $order->billing_postcode,
                'BillingCountry'    => $order->billing_country,
                'BillingPhone'      => $order->billing_phone,
                'CustomerEMail'     => $order->billing_email,

                // Shipping Address info
                'DeliveryFirstnames'=> apply_filters( 'woocommerce_sagepay_form_deliveryfirstname', $order->shipping_first_name ),
                'DeliverySurname'   => apply_filters( 'woocommerce_sagepay_form_deliverysurname', $order->shipping_last_name ),
                'DeliveryAddress1'  => apply_filters( 'woocommerce_sagepay_form_deliveryaddress1', $order->shipping_address_1 ),
                'DeliveryAddress2'  => apply_filters( 'woocommerce_sagepay_form_deliveryaddress2', $order->shipping_address_2 ),
                'DeliveryCity'      => apply_filters( 'woocommerce_sagepay_form_deliverycity', $order->shipping_city ),
                'DeliveryState'     => apply_filters( 'woocommerce_sagepay_form_deliverystate', $shipping_state ),
                'DeliveryPostCode'  => apply_filters( 'woocommerce_sagepay_form_deliverypostcode', $order->shipping_postcode ),
                'DeliveryCountry'   => apply_filters( 'woocommerce_sagepay_form_deliverycountry', $order->shipping_country ),
                'DeliveryPhone'     => apply_filters( 'woocommerce_sagepay_form_deliveryphone', $order->billing_phone ),

                // BASKET
                'Basket'            => WC_Sagepay_Common_Functions::sagepay_basket( $order_id ),

                // Settings
                'AllowGiftAid'      => $this->allow_gift_aid,
                'ApplyAVSCV2'       => $this->apply_avs_cv2,
                'Apply3DSecure'     => $this->apply_3dsecure,
				
				// SurchargeXML
				'surchargeXML'		=> $surchargexml,
				'ReferrerID'		=> $this->referrerid
            );
            
            // Filter the args if necessary, use with caution
            $sage_pay_args_array = apply_filters( 'woocommerce_sagepay_form_data', $sage_pay_args_array, $order );

			/**
			 * Debugging
			 */
  			if ( $this->debug == true ) {
  				WC_Sagepay_Common_Functions::sagepay_debug( $sage_pay_args_array, $this->id, __('Sent to SagePay : ', 'woocommerce_sagepayform'), TRUE );
			}

            $sage_pay_args = array();

            foreach( $sage_pay_args_array as $param => $value ) {
				
				// Remove all the non-english things
     			$value = strtr( $value, WC_Sagepay_Common_Functions::unwanted_array() );

     			if( function_exists( 'iconv' ) ) {
                    $value = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $value);
                } elseif (function_exists( 'mb_convert_encoding' ) ) {
                    $value = mb_convert_encoding( $value, 'ISO-8859-1', 'UTF-8' );
                }

				$sage_pay_args[] = $param . "=" . $value;

			}	

            $sage_pay_args = implode( '&', $sage_pay_args );

            if ( $this->status == 'testing' && $this->testvendorpwd ) {
                $vendorpwd = $this->testvendorpwd;
            } elseif ( $this->status == 'sim' && $this->simvendorpwd ) {
           		$vendorpwd = $this->simvendorpwd; 
           	} else {
           		$vendorpwd = $this->vendorpwd;
           	}

           	$sagepaycrypt_b64  = $this->encrypt( $sage_pay_args, $vendorpwd );

            $sagepaycrypt      = '<input type="hidden" name="Crypt" value="' . $sagepaycrypt_b64 . '" />';

            // This is the form. 
            return  '<form action="' . $sagepayform_adr . '" method="post" id="sagepayform_payment_form">
                    ' . $sagepayform . '
                    ' . $sagepaycrypt . '
                    <input type="submit" class="button-alt" id="submit_sagepayform_payment_form" value="' . __( 'Pay via SagePay', 'woocommerce_sagepayform' ) . '" /> <a class="button cancel" href="' . $order->get_cancel_order_url() . '">' . __( 'Cancel order &amp; restore cart', 'woocommerce_sagepayform' ) . '</a>
                	</form>';

        }

        /**
         * process_payment function.
         *
         * @access public
         * @param mixed $order_id
         * @return void
         */
        function process_payment( $order_id ) {
            $order = new WC_Order( $order_id );

            return array(
                'result'    => 'success',
            	'redirect'	=> $order->get_checkout_payment_url( true )
            );
            
        }

        /**
         * receipt_page function.
         *
         * @access public
         * @param mixed $order
         * @return void
         */
        function receipt_page( $order ) {
            echo '<p>' . __( 'Thank you for your order, please click the button below to pay with SagePay.', 'woocommerce_sagepayform' ) . '</p>';
            echo $this->generate_sagepay_form( $order );
        }

        /**
         * check_sagepay_response function.
         *
         * @access public
         * @return void
         */
        function check_sagepay_response() {

        	@ob_clean();

            if ( isset( $_GET["crypt"] ) ) {

            	if ( $this->status == 'testing' && $this->testvendorpwd ) {
                	$vendorpwd = $this->testvendorpwd;
            	} elseif ( $this->status == 'sim' && $this->simvendorpwd ) {
            	    $vendorpwd = $this->simvendorpwd;
            	} else {
                	$vendorpwd = $this->vendorpwd;
            	}

                $crypt = $_GET["crypt"];

           		if ( ( $this->enablesurcharges == 'yes' && function_exists('mcrypt_encrypt') ) || ( $this->protocol == '3.00' && function_exists('mcrypt_encrypt') ) ) {
            		$sagepay_return_data   = $this->decrypt( $crypt, $vendorpwd );
				} else {
					$sagepay_return_data   = $this->simpleXor( $this->base64Decode( $_GET["crypt"] ), $vendorpwd );
				}

				$sagepay_return_values = $this->getTokens( $sagepay_return_data );

				/**
				 * Debugging
				 */
				if ( $this->debug == true ) {
  					WC_Sagepay_Common_Functions::sagepay_debug( $sagepay_return_values, $this->id, __('SagePay Return : ', 'woocommerce_sagepayform'), FALSE );
				}

                if ( isset( $sagepay_return_values['VPSTxId'] ) ) {
                    do_action( "valid_sagepayform_request", $sagepay_return_values );
                }

            } else {

            	wp_die( "Sage Request Failure<br />" . 'Check the WooCommerce SagePay Settings for error messages', "Sage Failure", array( 'response' => 200 ) );
            }
        }


        /**
         * successful_request function.
         *
         * @access public
         * @param mixed $sagepay_return_values
         * @return void
         */
        function successful_request( $sagepay_return_values ) {

            // Custom holds post ID
            if ( ! empty( $sagepay_return_values['Status'] ) && ! empty( $sagepay_return_values['VendorTxCode'] ) ) {

                $VendorTxCode    = explode( '-', $sagepay_return_values['VendorTxCode'] );

                // SAGE Line 50 Fix
                $order_key       = 'order_' . $VendorTxCode[0];
                $order_id        = $VendorTxCode[1];

                $accepted_status = array( 'OK', 'NOTAUTHED', 'MALFORMED', 'INVALID', 'ABORT', 'REJECTED', 'AUTHENTICATED', 'REGISTERED', 'ERROR' );

                if ( ! in_array( $sagepay_return_values['Status'], $accepted_status ) ) {
                    echo "<p>" . $sagepay_return_values['Status'] . " NOT FOUND!</p>";
                    exit;
                }

                $order = new WC_Order( (int) $order_id );

                $order_key_array = array( 'wc_', 'order_', 'wc_order_', 'order_wc_', $this->vendortxcodeprefix );

                if ( str_replace($order_key_array,'',$order->order_key) !== str_replace($order_key_array,'',$order_key) ) {
                    echo "<p>" . $order->order_key . " AND " . $order_key . " DO NOT MATCH!</p>";
                    exit;
                }

                if ( $order->status !== 'completed' ) {
                	// We are here so lets check status and do actions
 
                    switch ( strtolower( $sagepay_return_values['Status'] ) ) {
                        case 'ok' :
                        	// Payment completed
                            update_post_meta( $order->id, '_VPSTxId' , str_replace( array('{','}'),'',$sagepay_return_values['VPSTxId'] ) );
                            update_post_meta( $order->id, '_TxAuthNo' , $sagepay_return_values['TxAuthNo'] );

                            update_post_meta( $order->id, '_AVSCV2' , $sagepay_return_values['AVSCV2'] );
                            update_post_meta( $order->id, '_CV2Result' , $sagepay_return_values['CV2Result'] );
                            update_post_meta( $order->id, '_3DSecureStatus' , $sagepay_return_values['3DSecureStatus'] );



							// Add fee to order if there is a SagePay surcharge
							if ( isset($sagepay_return_values['Surcharge']) ) :

   								$item_id = woocommerce_add_order_item( $order_id, array(
 									'order_item_name' 		=> 'SagePay Surcharge',
 									'order_item_type' 		=> 'fee'
 								) );

 								// Add line item meta
 								if ( $item_id ) :
								 	woocommerce_add_order_item_meta( $item_id, '_tax_class', '' );
								 	woocommerce_add_order_item_meta( $item_id, '_line_total', $sagepay_return_values['Surcharge'] );
								 	woocommerce_add_order_item_meta( $item_id, '_line_tax', '' );
 								endif;

 								$old_order_total = get_post_meta( $order_id, '_order_total', TRUE );
 								update_post_meta( $order_id, '_order_total', $old_order_total + $sagepay_return_values['Surcharge'] );

 								$ordernotes .= '<br /><br />Order total updated';
 								$ordernotes .= '<br />Surcharge : ' 	. $sagepay_return_values['Surcharge'];

 							endif;

                            /**
                             * Successful payment
                             */
                            $ordernotes = '';

                            foreach ( $sagepay_return_values as $key => $value ) {
                                $ordernotes .= $key . ' : ' . $value . "\r\n";
                            }

                            $order->add_order_note( __('Payment completed', 'woocommerce_sagepayform') . '<br />' . $ordernotes );
                            $order->payment_complete( $sagepay_return_values['VPSTxId'] );

                        break;
                        case 'notauthed' :
                        	// Message
                            $order->update_status( 'on-hold', sprintf( __( 'Payment %s via SagePay.', 'woocommerce_sagepayform' ), woocommerce_clean( $sagepay_return_values['Status'] ) ) );
                        break;
						case 'authenticated' :
                            // Message
							$ordernotes  = 'SagePay payment authenticated - No funds have been collected at this time, please log in to yout SagePay control panel to collect the funds';
							$ordernotes .= '<br />Status : ' . $sagepay_return_values['Status'];
							$ordernotes .= '<br />StatusDetail : ' . $sagepay_return_values['StatusDetail'];
							$ordernotes .= '<br />VendorTxCode : ' . $sagepay_return_values['VendorTxCode'];
							$ordernotes .= '<br />VPSTxId : ' . $sagepay_return_values['VPSTxId'];
							$ordernotes .= '<br />TxAuthNo : ' . $sagepay_return_values['TxAuthNo'];
							$ordernotes .= '<br />Amount : ' . $sagepay_return_values['Amount'];
							$ordernotes .= '<br />AVSCV2 : ' . $sagepay_return_values['AVSCV2'];
							$ordernotes .= '<br />AddressResult : ' . $sagepay_return_values['AddressResult'];
							$ordernotes .= '<br />PostCodeResult : ' . $sagepay_return_values['PostCodeResult'];
							$ordernotes .= '<br />CV2Result : ' . $sagepay_return_values['CV2Result'];
							$ordernotes .= '<br />GiftAid : ' . $sagepay_return_values['GiftAid'];
							$ordernotes .= '<br />3DSecureStatus : ' . $sagepay_return_values['3DSecureStatus'];
							$ordernotes .= '<br />AddressStatus : ' . $sagepay_return_values['CAVV'];
							$ordernotes .= '<br />CardType : ' . $sagepay_return_values['CardType'];
							$ordernotes .= '<br />Last4Digits : ' . $sagepay_return_values['Last4Digits'];
							$ordernotes .= '<br />Surcharge : ' . $sagepay_return_values['Surcharge'];
							$ordernotes .= '<br />DeclineCode : ' . $sagepay_return_values['DeclineCode'];
							$ordernotes .= '<br />BankAuthCode : ' . $sagepay_return_values['BankAuthCode'];

							// Add fee to order if there is a SagePay surcharge
							if ( $sagepay_return_values['Surcharge'] ) :
                            	
   								$item_id = woocommerce_add_order_item( $order_id, array(
 									'order_item_name' 		=> 'SagePay Surcharge',
 									'order_item_type' 		=> 'fee'
 								) );

 								// Add line item meta
 								if ( $item_id ) :
								 	woocommerce_add_order_item_meta( $item_id, '_tax_class', '' );
								 	woocommerce_add_order_item_meta( $item_id, '_line_total', $sagepay_return_values['Surcharge'] );
								 	woocommerce_add_order_item_meta( $item_id, '_line_tax', '' );
 								endif;

 								$old_order_total = get_post_meta( $order_id, '_order_total', TRUE );
 								update_post_meta( $order_id, '_order_total', $old_order_total + $sagepay_return_values['Surcharge'] );

 								$ordernotes .= '<br /><br />Order total updated';

 							endif;
							
                            $order->add_order_note( $ordernotes );
                            $order->update_status( 'pending', sprintf( __( 'Payment %s via SagePay.', 'woocommerce_sagepayform' ), woocommerce_clean( $sagepay_return_values['Status'] ) ) );
							$order->add_order_note( __(  ) );

                        break;
                        case 'registered' :
                        	// Message
                            $order->update_status( 'on-hold', sprintf( __( 'Payment %s via SagePay.', 'woocommerce_sagepayform' ), woocommerce_clean( $sagepay_return_values['Status'] ) ) );
							$order->add_order_note( __( 'SagePay payment registered - 3D Secure check failed', 'woocommerce_sagepayform' ) );
                        break;
                        case 'malformed' :
                        case 'invalid' :
                        case 'abort' :
                        case 'rejected' :
                        case 'error' :
                        	// Failed order
                            $order->update_status('failed', sprintf( __( 'Payment %s via SagePay.', 'woocommerce_sagepayform' ), woocommerce_clean( $sagepay_return_values['Status'] ) ) );
                        break;
                    }
                }

                wp_redirect( $this->get_return_url( $order ) );
                exit;
            }

        }

        /**
         * [sagepay_system_status description]
         * @return [type] [description]
         */
        function sagepay_system_status() {

        	$description = __( 'SagePay Form works by sending the user to <a href="http://www.sagepay.com">SagePay</a> to enter their payment information.', 'woocommerce_sagepayform' );

			return $description;

		}

        /**
         * base64Decode function.
         *
         * @access public
         * @param mixed $scrambled
         * @return void
         */
        function base64Decode( $scrambled )   {
            // Initialise output variable
            $output = "";

            // Fix plus to space conversion issue
            $scrambled = str_replace( " ", "+", $scrambled );

            // Do decoding
            $output = base64_decode( $scrambled );

            // Return the result
            return $output;
        }


        /**
         * simpleXor function.
         *
         * @access public
         * @param mixed $text
         * @param mixed $key
         * @return void
         */
        function simpleXor( $text, $key ) {
            // Initialise key array
            $key_ascii_array = array();

            // Initialise output variable
            $output = "";

            // Convert $key into array of ASCII values
            for ( $i = 0; $i < strlen( $key ); $i++ ) {
                $key_ascii_array[ $i ] = ord( substr( $key, $i, 1 ) );
            }

            // Step through string a character at a time
            for ( $i = 0; $i < strlen( $text ); $i++ ) {
                // Get ASCII code from string, get ASCII code from key (loop through with MOD), XOR the
                // two, get the character from the result
                $output .= chr( ord( substr( $text, $i, 1 ) ) ^ ( $key_ascii_array[ $i % strlen( $key ) ] ) );
            }

            // Return the result
            return $output;
        }

        /**
         * Protocol 3 Encryption function
         * @param  [type] $securekey [description]
         * @param  [type] $input     [description]
         * @return [type]            [description]
         *
         * This function requires php mcrypt
         */
		function encrypt( $input,$securekey ) { 
    		
    		$pkinput = $this->addPKCS5Padding( $input );
    		$crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $securekey, $pkinput, MCRYPT_MODE_CBC, $securekey);
    		return "@" . bin2hex( $crypt );

		}	

    	/**
    	 * Protocol 3 Decryption function
    	 * @param  [type] $securekey [description]
    	 * @param  [type] $input     [description]
    	 * @return [type]            [description]
    	 *
    	 * This function requires php mcrypt
    	 */
    	function decrypt( $input,$securekey ) {

    		// remove the first char which is @ to flag this is AES encrypted
        	$input = substr($input,1);
       
        	// HEX decoding
        	$input = pack('H*', $input);

        	return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $securekey, $input, MCRYPT_MODE_CBC, $securekey); 
        }

		function addPKCS5Padding( $input ) {
		   $blocksize = 16;
		   $padding = "";

		   // Pad input to an even block size boundary
		   $padlength = $blocksize - (strlen($input) % $blocksize);
		   for($i = 1; $i <= $padlength; $i++) {
		      $padding .= chr($padlength);
		   }
   
		   return $input . $padding;
		}

        /**
         * getTokens function.
         *
         * @access public
         * @param mixed $query_string
         * @return void
         */
        function getTokens( $query_string ) {

        	$output = '';

        	if ( isset($query_string) && $query_string != '' ) {
            	// List the possible tokens
            	$tokens = array(
            	    "Status",
            	    "StatusDetail",
            	    "VendorTxCode",
            	    "VPSTxId",
            	    "TxAuthNo",
            	    "Amount",
            	    "AVSCV2",
            	    "AddressResult",
            	    "PostCodeResult",
            	    "CV2Result",
            	    "GiftAid",
            	    "3DSecureStatus",
            	    "CAVV",
            	    "CardType",
            	    "Last4Digits",
             	    "Surcharge",
            	    "DeclineCode",
					"BankAuthCode"
            	);

            	// Initialise arrays
            	$output = array();
            	$tokens_found = array();

            	// Get the next token in the sequence
            	for ( $i = count( $tokens ) - 1; $i >= 0; $i-- ) {
            	    // Find the position in the string
             	   $start = strpos( $query_string, $tokens[$i] );

            	    // If token is present record its position and name
            	    if ( $start !== false ) {

						if( !isset($tokens_found[$i]) ) {
            				$tokens_found[$i] = new StdClass();
        				}

            	        $tokens_found[$i]->start = $start;
            	        $tokens_found[$i]->token = $tokens[$i];
            	    }

            	}

            	// Sort in order of position
            	sort( $tokens_found );

            	// Go through the result array, getting the token values
            	for ( $i = 0; $i < count( $tokens_found ); $i++ ) {
            		// Get the start point of the value
            	    $valueStart = $tokens_found[$i]->start + strlen( $tokens_found[ $i ]->token ) + 1;

             	   // Get the length of the value
             	   if ( $i == ( count( $tokens_found ) - 1 ) ) {
                    $output[$tokens_found[ $i ]->token] = substr( $query_string, $valueStart );
            	    } else {
            	        $valueLength = $tokens_found[ $i + 1 ]->start - $tokens_found[ $i ]->start - strlen( $tokens_found[ $i ]->token) - 2;
            	        $output[ $tokens_found[ $i ]->token] = substr( $query_string, $valueStart, $valueLength );
            	    }

            	}

            }

            // Return the output array
            return $output;

        }

	} // END CLASS
