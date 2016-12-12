<?php

    /**
     * WC_Gateway_Sagepay_Direct_AddOns class.
     *
     * @extends WC_Gateway_Sagepay_Direct
     * Adds refunds, subscriptions support, pre-orders support.
     */
    class WC_Gateway_Sagepay_Direct_AddOns extends WC_Gateway_Sagepay_Direct {

        /**
         * __construct function.
         *
         * @access public
         * @return void
         */
        public function __construct() {
            parent::__construct();

            // Subscriptions
            if ( class_exists( 'WC_Subscriptions_Order' ) ) {
                
                // if ( function_exists( 'wcs_order_contains_subscription' ) ) {
                if ( version_compare( WC_Subscriptions::$version,'2.0', '<' ) ) {
                    // Pre Subscriptions 2.0
                    add_action( 'scheduled_subscription_payment_' . $this->id, array( $this, 'process_scheduled_subscription_payment' ), 10, 3 );
                    add_filter( 'woocommerce_subscriptions_renewal_order_meta_query', array( $this, 'remove_renewal_order_meta' ), 10, 4 );
                } else {
                    // Subscriptions 2.0
                    add_action( 'woocommerce_scheduled_subscription_payment_' . $this->id, array( $this, 'woocommerce_process_scheduled_subscription_payment' ), 10, 2 );
                    add_filter( 'wcs_renewal_order_meta_query', array( $this, 'remove_renewal_order_meta' ), 10, 3 );
                }

                // display the credit card used for a subscription in the "My Subscriptions" table
                if ( class_exists( 'WC_Payment_Token_CC' ) ) {
                    add_filter( 'woocommerce_my_subscriptions_payment_method', array( $this, 'maybe_render_subscription_payment_method' ), 10, 2 );

                    add_action( 'woocommerce_subscriptions_changed_failing_payment_method_sagepaydirect', array( $this, 'update_failing_payment_method' ), 10, 3 );
                }

            }

            // Pre-Orders
            if ( class_exists( 'WC_Pre_Orders_Order' ) ) {
                add_action( 'wc_pre_orders_process_pre_order_completion_payment_' . $this->id, array( $this, 'process_pre_order_release_payment' ) );
            }

        }

        /**
         * process scheduled subscription payment pre 2.0
         */
        function process_scheduled_subscription_payment( $amount_to_charge, $order, $product_id = NULL ) {

            if( !is_object( $order ) ) {
                $order = new WC_Order( $order );
            }

            $order_id = $order->id;

            $VendorTxCode   = 'Renewal-' . $order_id . '-' . time();

            // SAGE Line 50 Fix
            $VendorTxCode   = str_replace( 'order_', '', $VendorTxCode );

            // New API Request for repeat
            $api_request     = 'VPSProtocol=' . urlencode( $this->vpsprotocol );
            $api_request    .= '&TxType=REPEAT';
            $api_request    .= '&Vendor=' . urlencode( $this->vendor );
            $api_request    .= '&VendorTxCode=' . $VendorTxCode;
            $api_request    .= '&Amount=' . urlencode( $amount_to_charge );
            $api_request    .= '&Currency=' . get_post_meta( $order_id, '_order_currency', true );
            $api_request    .= '&Description=Repeat payment for order ' . $order_id;
            $api_request    .= '&RelatedVPSTxId=' . get_post_meta( $order_id, '_RelatedVPSTxId', true );
            $api_request    .= '&RelatedVendorTxCode=' . get_post_meta( $order_id, '_RelatedVendorTxCode', true );
            $api_request    .= '&RelatedSecurityKey=' . get_post_meta( $order_id, '_RelatedSecurityKey', true );
            $api_request    .= '&RelatedTxAuthNo=' . get_post_meta( $order_id, '_RelatedTxAuthNo', true );

            $result = $this->sagepay_post( $api_request, $this->repeatURL );

            if ( 'OK' != $result['Status'] ) {

                $content = 'There was a problem renewing this payment for order ' . $order_id . '. The Transaction ID is ' . $api_request['RelatedVPSTxId'] . '. The API Request is <pre>' . 
                    print_r( $api_request, TRUE ) . '</pre>. SagePay returned the error <pre>' . 
                    print_r( $result['StatusDetail'], TRUE ) . '</pre> The full returned array is <pre>' . 
                    print_r( $result, TRUE ) . '</pre>. ';
                    
                wp_mail( $this->notification ,'SagePay Renewal Error ' . $result['Status'] . ' ' . time(), $content );

                WC_Subscriptions_Manager::process_subscription_payment_failure_on_order( $order, $product_id );

            } else {

                WC_Subscriptions_Manager::process_subscription_payments_on_order( $order );

                /**
                 * Update the renewal order with the transaction info from Sage 
                 * and update the original order with the renewal order 
                 */
                $renewal_orders = WC_Subscriptions_Renewal_Order::get_renewal_orders( $order_id );
                $renewal_order  = end( array_values($renewal_orders) );
                $this->add_notes_scheduled_subscription_order( $result, $renewal_order, $order_id, $VendorTxCode );
            }

        } // process scheduled subscription payment

        /**
         * process scheduled subscription payment for Subscriptions 2.0
         */
        function woocommerce_process_scheduled_subscription_payment( $amount_to_charge, $order ) {

            if( !is_object( $order ) ) {
                $order = new WC_Order( $order );
            }

            $order_id = $order->id;

            /**
             * Get parent order ID
             */
            $subscriptions = wcs_get_subscriptions_for_renewal_order( $order_id );
            foreach( $subscriptions as $subscription ) {

                $parent_order_id = $subscription->order->id;
                $subscription_id = $subscription->id;

            }

            // Check for token
            $sagepaytoken = get_post_meta( $parent_order_id, '_SagePayDirectToken', true );

            if( $sagepaytoken && $sagepaytoken != '' ) {
                // Tokens
                $VendorTxCode   = 'Renewal-' . $parent_order_id . '-' . time();

                // SAGE Line 50 Fix
                $VendorTxCode   = str_replace( 'order_', '', $VendorTxCode );

                $data = array(
                        "Token"             =>  $sagepaytoken,
                        "StoreToken"        =>  "1",
                        "ApplyAVSCV2"       =>  "2",
                        "Apply3DSecure"     =>  "2",
                        "VPSProtocol"       =>  $this->vpsprotocol,
                        "TxType"            =>  "PAYMENT",
                        "Vendor"            =>  $this->vendor,
                        "VendorTxCode"      =>  $VendorTxCode,
                        "Amount"            =>  urlencode( $amount_to_charge ),
                        "Currency"          =>  WC_Sagepay_Common_Functions::get_order_currency( $order ),
                        "Description"       =>   __( 'Order', 'woocommerce_sagepayform' ) . ' ' . str_replace( '#' , '' , $order->get_order_number() ),
                        "BillingSurname"    =>  $order->billing_last_name,
                        "BillingFirstnames" =>  $order->billing_first_name,
                        "BillingAddress1"   =>  $order->billing_address_1,
                        "BillingAddress2"   =>  $order->billing_address_2,
                        "BillingCity"       =>  $order->billing_city,
                        "BillingPostCode"   =>  $this->billing_postcode( $order->billing_postcode ),
                        "BillingCountry"    =>  $order->billing_country,
                        "BillingState"      =>  $this->get_state( $order->billing_country, 'billing', $order ),
                        "BillingPhone"      =>  $order->billing_phone,
                        "DeliverySurname"   =>  apply_filters( 'woocommerce_sagepay_direct_deliverysurname', $order->shipping_last_name ),
                        "DeliveryFirstnames"=>  apply_filters( 'woocommerce_sagepay_direct_deliveryfirstname', $order->shipping_first_name ),
                        "DeliveryAddress1"  =>  apply_filters( 'woocommerce_sagepay_direct_deliveryaddress1', $order->shipping_address_1 ),
                        "DeliveryAddress2"  =>  apply_filters( 'woocommerce_sagepay_direct_deliveryaddress2', $order->shipping_address_2 ),
                        "DeliveryCity"      =>  apply_filters( 'woocommerce_sagepay_direct_deliverycity', $order->shipping_city ),
                        "DeliveryPostCode"  =>  apply_filters( 'woocommerce_sagepay_direct_deliverypostcode', $order->shipping_postcode ),
                        "DeliveryCountry"   =>  apply_filters( 'woocommerce_sagepay_direct_deliverycountry', $order->shipping_country ),
                        "DeliveryState"     =>  apply_filters( 'woocommerce_sagepay_direct_deliverystate', $this->get_state( $order->shipping_country, 'shipping', $order ) ),
                        "DeliveryPhone"     =>  apply_filters( 'woocommerce_sagepay_direct_deliveryphone', $order->billing_phone ),
                        "CustomerEMail"     =>  $order->billing_email,
                        "AllowGiftAid"      =>  $this->allowgiftaid,
                        "ClientIPAddress"   =>  $this->get_ipaddress(),
                        "AccountType"       =>  $this->accounttype,
                        "BillingAgreement"  =>  $this->billingagreement,
                        "ReferrerID"        =>  $this->referrerid,
                        "Website"           =>  site_url()
                    );             

                // Check basket length, Sage limits basket to 7500 characters.
                $basket = WC_Sagepay_Common_Functions::sagepay_basket( $order_id );
                if( mb_strlen( $basket ) <= 7500 ) {
                    $data["Basket"] = $basket;
                }

                /**
                 * Debugging
                 */
                if ( $this->debug == true ) {
                    WC_Sagepay_Common_Functions::sagepay_debug( $data, $this->id, __('Sent to SagePay : ', 'woocommerce_sagepayform'), TRUE );
                }

                /**
                 * Convert the $data array for Sage
                 */
                $data = http_build_query( $data, '', '&' );

                /**
                 * Send $data to Sage
                 * @var [type]
                 */
                $result = $this->sagepay_post( $data, $this->purchaseURL );

                // Process the result
                if ( 'OK' != $result['Status'] ) {

                    $content = 'There was a problem renewing this payment for order ' . $order_id . '. The Transaction ID is ' . $api_request['RelatedVPSTxId'] . '. The API Request is <pre>' . 
                        print_r( $api_request, TRUE ) . '</pre>. SagePay returned the error <pre>' . 
                        print_r( $result['StatusDetail'], TRUE ) . '</pre> The full returned array is <pre>' . 
                        print_r( $result, TRUE ) . '</pre>. ';
                        
                    wp_mail( $this->notification ,'SagePay Renewal Error ' . $result['Status'] . ' ' . time(), $content );

                    $ordernote = '';
                    foreach ( $result as $key => $value ) {
                        $ordernote .= $key . ' : ' . $value . "\r\n";
                    }

                    $order->add_order_note( __('Payment failed', 'woocommerce_sagepayform') . '<br />' . $ordernote );

                   WC_Subscriptions_Manager::process_subscription_payment_failure_on_order( $order, $product_id );

                } else {

                    WC_Subscriptions_Manager::process_subscription_payments_on_order( $order );

                    $successful_ordernote = '';
                    foreach ( $result as $key => $value ) {
                        $successful_ordernote .= $key . ' : ' . $value . "\r\n";
                    }

                    $order->add_order_note( __('Payment completed', 'woocommerce_sagepayform') . '<br />' . $successful_ordernote );

                    update_post_meta( $order_id, '_VPSTxId' , str_replace( array('{','}'),'',$result['VPSTxId'] ) );
                    update_post_meta( $order_id, '_SecurityKey' , $result['SecurityKey'] );
                    update_post_meta( $order_id, '_TxAuthNo' , $result['TxAuthNo'] );

                    update_post_meta( $order_id, '_RelatedVPSTxId' , str_replace( array('{','}'),'',$result['VPSTxId'] ) );
                    update_post_meta( $order_id, '_RelatedSecurityKey' , $result['SecurityKey'] );
                    update_post_meta( $order_id, '_RelatedTxAuthNo' , $result['TxAuthNo'] );
                    update_post_meta( $order_id, '_RelatedVendorTxCode' , $VendorTxCode );
                    update_post_meta( $order_id, '_SagePayDirectToken', $sagepaytoken );

                    $order->payment_complete( str_replace( array('{','}'),'',$result['VPSTxId'] ) );

                }

            } else {
                // Not tokens
                global $wpdb;
                /**
                 * Check for previous renewals for this subscription.
                 */         
                $previous_renewals = $wpdb->get_results(  $wpdb->prepare( "
                                            SELECT * FROM {$wpdb->postmeta} pm
                                            LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                                            WHERE pm.meta_key = '%s'
                                            AND pm.meta_value = '%s'
                                            AND p.post_status IN ( '%s','%s' )
                                            ORDER BY pm.post_id DESC
                                            LIMIT 1
                                        ", '_subscription_renewal', $subscription_id, 'wc-processing', 'wc-completed' ) 
                );

                /**
                 * $previous_renewal_id is used to get the Sage transaction information from the last successful renewal.
                 * 
                 * Sage archives orders after 2 years, if we use the transaction information from the first order then 
                 * orders will fail once the first order is archived.
                 */
                if( isset( $previous_renewals[0]->post_id ) && '' != $previous_renewals[0]->post_id ) {
                    $previous_renewal_id = $previous_renewals[0]->post_id;
                } else {
                    $previous_renewal_id = $parent_order_id;
                }

                $VendorTxCode   = 'Renewal-' . $parent_order_id . '-' . time();

                // SAGE Line 50 Fix
                $VendorTxCode   = str_replace( 'order_', '', $VendorTxCode );

                // New API Request for repeat
                $api_request     = 'VPSProtocol=' . urlencode( $this->vpsprotocol );
                $api_request    .= '&TxType=REPEAT';
                $api_request    .= '&Vendor=' . urlencode( $this->vendor );
                $api_request    .= '&VendorTxCode=' . $VendorTxCode;
                $api_request    .= '&Amount=' . urlencode( $amount_to_charge );
                $api_request    .= '&Currency=' . get_post_meta( $previous_renewal_id, '_order_currency', true );
                $api_request    .= '&Description=Repeat payment for order ' . $parent_order_id;
                $api_request    .= '&RelatedVPSTxId=' . get_post_meta( $previous_renewal_id, '_RelatedVPSTxId', true );
                $api_request    .= '&RelatedVendorTxCode=' . get_post_meta( $previous_renewal_id, '_RelatedVendorTxCode', true );
                $api_request    .= '&RelatedSecurityKey=' . get_post_meta( $previous_renewal_id, '_RelatedSecurityKey', true );
                $api_request    .= '&RelatedTxAuthNo=' . get_post_meta( $previous_renewal_id, '_RelatedTxAuthNo', true );

                // Send the request to sage for processing
                $result = $this->sagepay_post( $api_request, $this->repeatURL );

                // Process the result
                if ( 'OK' != $result['Status'] ) {

                    $content = 'There was a problem renewing this payment for order ' . $order_id . '. The Transaction ID is ' . $api_request['RelatedVPSTxId'] . '. The API Request is <pre>' . 
                        print_r( $api_request, TRUE ) . '</pre>. SagePay returned the error <pre>' . 
                        print_r( $result['StatusDetail'], TRUE ) . '</pre> The full returned array is <pre>' . 
                        print_r( $result, TRUE ) . '</pre>. ';
                        
                    wp_mail( $this->notification ,'SagePay Renewal Error ' . $result['Status'] . ' ' . time(), $content );

                    $ordernote = '';
                    foreach ( $result as $key => $value ) {
                        $ordernote .= $key . ' : ' . $value . "\r\n";
                    }

                    $order->add_order_note( __('Payment failed', 'woocommerce_sagepayform') . '<br />' . $ordernote );

                   WC_Subscriptions_Manager::process_subscription_payment_failure_on_order( $order, $product_id );

                } else {

                    WC_Subscriptions_Manager::process_subscription_payments_on_order( $order );

                    $successful_ordernote = '';
                    foreach ( $result as $key => $value ) {
                        $successful_ordernote .= $key . ' : ' . $value . "\r\n";
                    }

                    $order->add_order_note( __('Payment completed', 'woocommerce_sagepayform') . '<br />' . $successful_ordernote );

                    update_post_meta( $order_id, '_VPSTxId' , str_replace( array('{','}'),'',$result['VPSTxId'] ) );
                    update_post_meta( $order_id, '_SecurityKey' , $result['SecurityKey'] );
                    update_post_meta( $order_id, '_TxAuthNo' , $result['TxAuthNo'] );

                    update_post_meta( $order_id, '_RelatedVPSTxId' , str_replace( array('{','}'),'',$result['VPSTxId'] ) );
                    update_post_meta( $order_id, '_RelatedSecurityKey' , $result['SecurityKey'] );
                    update_post_meta( $order_id, '_RelatedTxAuthNo' , $result['TxAuthNo'] );
                    update_post_meta( $order_id, '_RelatedVendorTxCode' , $VendorTxCode );

                    $order->payment_complete( str_replace( array('{','}'),'',$result['VPSTxId'] ) );

                }

            }

        } // process scheduled subscription payment

        /**
         * Update the renewal order with the transaction info from Sage 
         * and update the original order with the renewal order transaction information.
         */
        private function add_notes_scheduled_subscription_order( $sageresult, $order_id, $original_order_id, $VendorTxCode ) {

            $order = new WC_Order( $order_id );

            /**
             * Successful payment
             */
            $successful_ordernote = '';

            foreach ( $sageresult as $key => $value ) {
                $successful_ordernote .= $key . ' : ' . $value . "\r\n";
            }

            $order->add_order_note( __('Payment completed', 'woocommerce_sagepayform') . '<br />' . $successful_ordernote );

            update_post_meta( $order_id, '_transaction_id', str_replace( array('{','}'),'',$sageresult['VPSTxId'] ) );
            update_post_meta( $order_id, '_VPSTxId' , str_replace( array('{','}'),'',$sageresult['VPSTxId'] ) );
            update_post_meta( $order_id, '_SecurityKey' , $sageresult['SecurityKey'] );
            update_post_meta( $order_id, '_TxAuthNo' , $sageresult['TxAuthNo'] );
            delete_post_meta( $order_id, '_CV2Result' );
            delete_post_meta( $order_id, '_3DSecureStatus' );

            // update the original order with the renewal order transaction information
            update_post_meta( $original_order_id, '_RelatedVPSTxId' , str_replace( array('{','}'),'',$sageresult['VPSTxId'] ) );
            update_post_meta( $original_order_id, '_RelatedVendorTxCode' , $VendorTxCode );
            update_post_meta( $original_order_id, '_RelatedSecurityKey' , $sageresult['SecurityKey'] );
            update_post_meta( $original_order_id, '_RelatedTxAuthNo' , $sageresult['TxAuthNo'] );

        }

        /**
         * Don't transfer Stripe customer/token meta when creating a parent renewal order.
         *
         * @access public
         * @param array $order_meta_query MySQL query for pulling the metadata
         * @param int $original_order_id Post ID of the order being used to purchased the subscription being renewed
         * @param int $renewal_order_id Post ID of the order created for renewing the subscription
         * @param string $new_order_role The role the renewal order is taking, one of 'parent' or 'child'
         * @return void
         */
        public function remove_renewal_order_meta( $order_meta_query, $original_order_id, $renewal_order_id, $new_order_role = NULL ) {
            if ( 'parent' == $new_order_role ) {
                $order_meta_query .= " AND `meta_key` NOT IN ( '_VPSTxId', '_SecurityKey', '_TxAuthNo', '_RelatedVPSTxId', '_RelatedSecurityKey', '_RelatedTxAuthNo', '_CV2Result', '_3DSecureStatus' ) ";
            }
            return $order_meta_query;
        }

        /**
         * Update the customer_id for a subscription after using SagePay to complete a payment to make up for
         * an automatic renewal payment which previously failed.
         *
         * @access public
         * @param WC_Order $original_order The original order in which the subscription was purchased.
         * @param WC_Order $renewal_order The order which recorded the successful payment (to make up for the failed automatic payment).
         * @param string $subscription_key A subscription key of the form created by @see WC_Subscriptions_Manager::get_subscription_key()
         * @return void
         */
        public function update_failing_payment_method( $original_order, $renewal_order, $subscription_key ) {
            update_post_meta( $original_order->id, '_SagePayDirectToken', get_post_meta( $new_renewal_order->id, '_SagePayDirectToken', true ) );

        }

        /**
         * Render the payment method used for a subscription in the "My Subscriptions" table
         *
         * @param string $payment_method_to_display the default payment method text to display
         * @param array $subscription_details the subscription details
         * @param WC_Order $order the order containing the subscription
         * @return string the subscription payment method
         */
        public function maybe_render_subscription_payment_method( $payment_method_to_display, $subscription ) {
            // bail for other payment methods
            if ( $this->id != $subscription->payment_method || ! $subscription->customer_user ) {
                return $payment_method_to_display;
            }

            $sage_token     = get_post_meta( $subscription->order->id, '_SagePayDirectToken', true );
            $sage_token_id  = $this->get_token_id( $sage_token );

            $token = new WC_Payment_Token_CC();
            $token = WC_Payment_Tokens::get( $sage_token_id );

            if( $token ) {
                $payment_method_to_display = sprintf( __( 'Via %s card ending in %s', 'woocommerce_sagepayform' ), $token->get_card_type(), $token->get_last4() );
            }

            return $payment_method_to_display;
        }

        /**
         * [process_pre_order_payments description]
         * @return [type] [description]
         */
        function process_pre_order_release_payment( $order ) {

            // the total amount to charge is the the order's total
            $amount_to_charge = $order->get_total();

            $VendorTxCode    = 'Authorise-' . $order->id . '-' . time();

            // Fix for missing '_VendorTxCode'
            $_VendorTxCode          = get_post_meta( $order->id, '_VendorTxCode', true );
            $_RelatedVendorTxCode   = get_post_meta( $order->id, '_RelatedVendorTxCode', true );

            if ( !isset($_VendorTxCode) || $_VendorTxCode == '' ) {
                $_VendorTxCode = $_RelatedVendorTxCode;
            }
            
            // New API Request for AUTHORISE
            $api_request     = 'VPSProtocol=' . urlencode( $this->vpsprotocol );
            $api_request    .= '&TxType=AUTHORISE';
            $api_request    .= '&Vendor=' . urlencode( $this->vendor );
            $api_request    .= '&VendorTxCode=' . $VendorTxCode;
            $api_request    .= '&Amount=' . urlencode( $amount_to_charge );
            $api_request    .= '&Currency=' . get_post_meta( $order->id, '_order_currency', true );
            $api_request    .= '&Description=Payment for pre-order ' . $order->id;
            $api_request    .= '&RelatedVPSTxId=' . get_post_meta( $order->id, '_VPSTxId', true );
            $api_request    .= '&RelatedVendorTxCode=' . $_VendorTxCode;
            $api_request    .= '&RelatedSecurityKey=' . get_post_meta( $order->id, '_SecurityKey', true );
            $api_request    .= '&RelatedTxAuthNo=' . get_post_meta( $order->id, '_TxAuthNo', true );

            $result = $this->sagepay_post( $api_request, $this->authoriseURL );

            if ( 'OK' != $result['Status'] ) {

                $content = 'There was a problem AUTHORISE this payment for order ' . $order->id . '. The Transaction ID is ' . $api_request['RelatedVPSTxId'] . '. The API Request is <pre>' . 
                    print_r( $api_request, TRUE ) . '</pre>. SagePay returned the error <pre>' . 
                    print_r( $result['StatusDetail'], TRUE ) . '</pre> The full returned array is <pre>' . 
                    print_r( $result, TRUE ) . '</pre>. ';
                    
                wp_mail( $this->notification ,'SagePay AUTHORISE Error ' . $result['Status'] . ' ' . time(), $content );

                /**
                 * failed payment
                 */
                $ordernote = '';

                foreach ( $result as $key => $value ) {
                    $ordernote .= $key . ' : ' . $value . "\r\n";
                }

                $order->add_order_note( __('Payment failed', 'woocommerce_sagepayform') . '<br />' . $ordernote );

            } else {
                    
                /**
                 * Successful payment
                 */
                $successful_ordernote = '';

                foreach ( $result as $key => $value ) {
                    $successful_ordernote .= $key . ' : ' . $value . "\r\n";
                }

                $order->add_order_note( __('Payment completed', 'woocommerce_sagepayform') . '<br />' . $successful_ordernote );

                update_post_meta( $order->id, '_RelatedVPSTxId' , str_replace( array('{','}'),'',$result['VPSTxId'] ) );
                update_post_meta( $order->id, '_RelatedSecurityKey' , $result['SecurityKey'] );
                update_post_meta( $order->id, '_RelatedTxAuthNo' , $result['TxAuthNo'] );
                update_post_meta( $order->id, '_CV2Result' , $result['CV2Result'] );
                update_post_meta( $order->id, '_3DSecureStatus' , $result['3DSecureStatus'] );
                
                // complete the order
                $order->payment_complete( str_replace( array('{','}'),'',$result['VPSTxId'] ) );
        
            }

        }

        /**
         * Get the Token ID from the database using the token from Sage
         * @param  [type] $token [description]
         * @return [type]        [description]
         */
        function get_token_id( $token ) {
            global $wpdb;

            $id = NULL;

            if ( $token ) {
                $tokens = $wpdb->get_row( $wpdb->prepare(
                    "SELECT token_id FROM {$wpdb->prefix}woocommerce_payment_tokens WHERE token = %s",
                    $token
                ) );
            }

            return $tokens->token_id;
        }

    }
