<?php
class WOO_Product_Stock_Alert_Frontend {
	private $dc_plugin_settings;

	public function __construct() {
		// Get plugin settings
		$this->dc_plugin_settings = get_dc_plugin_settings();
		
		//enqueue scripts
		add_action('wp_enqueue_scripts', array(&$this, 'frontend_scripts'));
		//enqueue styles
		add_action('wp_enqueue_scripts', array(&$this, 'frontend_styles'));
		
		if( isset($this->dc_plugin_settings) && !empty($this->dc_plugin_settings) ) {
			if( isset($this->dc_plugin_settings['is_enable']) && $this->dc_plugin_settings['is_enable'] == 'Enable' ) {
				// Hover style
				add_action( 'wp_head', array($this, 'frontend_style') );
		
				//HTML for getting customer email
				add_action( 'woocommerce_single_product_summary', array($this, 'get_alert_form'), 30 );
			}
		}
	}
	
	function frontend_scripts() {
		global $WOO_Product_Stock_Alert;
		$frontend_script_path = $WOO_Product_Stock_Alert->plugin_url . 'assets/frontend/js/';
		
		if(function_exists('is_product')) {
			if(is_product()) {
				// Enqueue your frontend javascript from here
				wp_enqueue_script( 'frontend_js', $frontend_script_path.'frontend.js', array('jquery'), $WOO_Product_Stock_Alert->version, true);
			}
		}
	}

	function frontend_styles() {
		global $WOO_Product_Stock_Alert;
		$frontend_style_path = $WOO_Product_Stock_Alert->plugin_url . 'assets/frontend/css/';

		if(function_exists('is_product')) {
			if(is_product()) {
				// Enqueue your frontend stylesheet from here
				wp_enqueue_style('frontend_css', $frontend_style_path.'frontend.css', array(), $WOO_Product_Stock_Alert->version);
			}
		}
	}
	
	
	
	function frontend_style() {
		$dc_settings = array();
		$button_background_color_onhover = $button_text_color_onhover = '';
		
		$dc_settings = $this->dc_plugin_settings;
		if( isset($dc_settings) && !empty($dc_settings) ) {
			$button_background_color_onhover = !empty($dc_settings['button_background_color_onhover']) ? $dc_settings['button_background_color_onhover'] : '';
			$button_text_color_onhover = !empty($dc_settings['button_text_color_onhover']) ? $dc_settings['button_text_color_onhover'] : '';
			$button_border_color_onhover = !empty($dc_settings['button_border_color_onhover']) ? $dc_settings['button_border_color_onhover'] : '';
		}
		
		echo '<style>
			input[type="button"].alert_button_hover:hover, button.unsubscribe_button:hover {
				background: '.$button_background_color_onhover.' !important;
				color: '.$button_text_color_onhover.' !important;
				border-color: '.$button_border_color_onhover.' !important;
			}
		</style>';
	}
	
	function get_alert_form() {
		global $WOO_Product_Stock_Alert, $product;

		if( empty($product) ) return;

		$stock_interest = $alert_text_html = $button_html = '';
		$dc_settings = array();
		$alert_text = $button_text = $button_background_color = $button_border_color = $button_text_color = $unsubscribe_button_text = '';
		$alert_success = $alert_email_exist = $valid_email = $alert_unsubscribe_message = '';
		
		$dc_settings = $this->dc_plugin_settings;
		
		if( isset($dc_settings) && !empty($dc_settings) ) {
			$alert_text = isset($dc_settings['alert_text']) ? $dc_settings['alert_text'] : 'Get an alert when the product is in stock:';
			$alert_text_color = isset($dc_settings['alert_text_color']) ? $dc_settings['alert_text_color'] : '';
			$button_text = isset($dc_settings['button_text']) ? $dc_settings['button_text'] : 'Get an alert';
			$unsubscribe_button_text = isset($dc_settings['unsubscribe_button_text']) ? $dc_settings['unsubscribe_button_text'] : 'Unsubscribe';
			$button_background_color = isset($dc_settings['button_background_color']) ? $dc_settings['button_background_color'] : '';
			$button_border_color = isset($dc_settings['button_border_color']) ? $dc_settings['button_border_color'] : '';
			$button_text_color = isset($dc_settings['button_text_color']) ? $dc_settings['button_text_color'] : '';
			$button_background_color_onhover = isset($dc_settings['button_background_color_onhover']) ? $dc_settings['button_background_color_onhover'] : '';
			$button_text_color_onhover = isset($dc_settings['button_text_color_onhover']) ? $dc_settings['button_text_color_onhover'] : '';
			$button_border_color_onhover = isset($dc_settings['button_border_color_onhover']) ? $dc_settings['button_border_color_onhover'] : '';
			$alert_success = isset($dc_settings['alert_success']) ? $dc_settings['alert_success'] : '';
			$alert_email_exist = isset($dc_settings['alert_email_exist']) ? $dc_settings['alert_email_exist'] : '';
			$valid_email = isset($dc_settings['valid_email']) ? $dc_settings['valid_email'] : '';
			$alert_unsubscribe_message = isset($dc_settings['alert_unsubscribe_message']) ? $dc_settings['alert_unsubscribe_message'] : '';
		}
		if( empty($alert_text) ) {
			$alert_text = __( 'Get an alert when the product is in stock:', $WOO_Product_Stock_Alert->text_domain );
		}
		if( empty($button_text) ) {
			$button_text = __( 'Get an alert', $WOO_Product_Stock_Alert->text_domain );
		}
		if( empty($alert_success) ) {
			$alert_success = __( 'Thank you for your interest in <b>%product_title%</b>, you will receive an email alert when it becomes available.', $WOO_Product_Stock_Alert->text_domain );
		}
		if( empty($alert_email_exist) ) {
			$alert_email_exist = __( '<b>%customer_email%</b> is already registered with <b>%product_title%</b>.', $WOO_Product_Stock_Alert->text_domain );
		}
		if( empty($valid_email) ) {
			$valid_email = __( 'Please enter a valid email id and try again.', $WOO_Product_Stock_Alert->text_domain );
		}
		if( empty($alert_unsubscribe_message) ) {
			$alert_unsubscribe_message = __( '<b>%customer_email%</b> is successfully unregistered.', $WOO_Product_Stock_Alert->text_domain );
		}
		
		
		if( !empty($alert_text) ) {
			$alert_text_html = '<h6 style="color:'.$alert_text_color.'" class="subscribe_for_interest_text">'.$alert_text.'</h6>';
		} else {
			$alert_text_html = '<h6 class="subscribe_for_interest_text">'.$alert_text.'</h6>';
		}
		
		if( !empty($button_background_color) && !empty($button_border_color) && !empty($button_text_color) && !empty($button_background_color_onhover) && !empty($button_text_color_onhover) && !empty($button_border_color_onhover) ) {
			$button_html = '<input type="button" style="background: '.$button_background_color.'; color: '.$button_text_color.'; border-color: '.$button_border_color.'" class="stock_alert_button alert_button_hover" name="alert_button" value="'.$button_text.'" />';
			$unsubscribe_button_html = '<button class="unsubscribe_button" style="background: '.$button_background_color.'; color: '.$button_text_color.'; border-color: '.$button_border_color.'">'.$unsubscribe_button_text.'</button>';
		} else {
			$button_html = '<input type="button" class="stock_alert_button" name="alert_button" value="'.$button_text.'" />';
			$unsubscribe_button_html = '<button class="unsubscribe_button">'.$unsubscribe_button_text.'</button>';
		}
		
		wp_localize_script( 'frontend_js', 'form_submission_text', array('alert_success' => $alert_success,
																																		 'alert_email_exist' => $alert_email_exist,
																																		 'valid_email' => $valid_email,
																																		 'unsubscribe_button' => $unsubscribe_button_html,
																																		 'alert_unsubscribe_message' => $alert_unsubscribe_message
																																		));
		
		if( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			$user_email = $current_user->data->user_email;
			$stock_interest = ' <div class="alert_container">
														'.$alert_text_html.'
														<input type="text" class="stock_alert_email" name="alert_email" value="'.$user_email.'" />
														'.$button_html.'
														<input type="hidden" class="current_product_id" value="'.$product->id.'" />
														<input type="hidden" class="current_product_name" value="'.$product->post->post_title.'" />
													</div> ';
		} else {
			$stock_interest = ' <div class="alert_container">
														'.$alert_text_html.'
														<input type="text" class="stock_alert_email" name="alert_email" />
														'.$button_html.'
														<input type="hidden" class="current_product_id" value="'.$product->id.'" />
														<input type="hidden" class="current_product_name" value="'.$product->post->post_title.'" />
													</div> ';
		}
		
		if( $product->is_type('simple') ) {
			if ( $this->display_stock_alert_form($product) ) {
				do_action('woocommerce_product_stock_alert_form_before');
				echo $stock_interest;
				do_action('woocommerce_product_stock_alert_form_after');
			}
		} else if( $product->is_type('variable') ) {
			$child_ids = array();
			if( $product->children ) {
				$child_ids = $product->children;
				if( isset($child_ids) && !empty($child_ids) ) {
					if( isset($child_ids['visible']) ) {
						foreach( $child_ids['visible'] as $child_id ) {
							$child_obj = new WC_Product_Variation($child_id);
							
							if( $this->display_stock_alert_form($child_obj) ) {
								$flag = 1;
							}
						}
					} else if( isset($child_ids['all']) ) {
						foreach( $child_ids['all'] as $child_id ) {
							$child_obj = new WC_Product_Variation($child_id);
							
							if( $this->display_stock_alert_form($child_obj) ) {
								$flag = 1;
							}
						}
					} else {
						foreach( $child_ids as $child_id ) {
							$child_obj = new WC_Product_Variation($child_id);
							
							if( $this->display_stock_alert_form($child_obj) ) {
								$flag = 1;
							}
						}
					}
				}
			}
			
			if( $flag == 1 ) {
				do_action('woocommerce_product_stock_alert_form_before');
				echo $stock_interest;
				do_action('woocommerce_product_stock_alert_form_after');
			}
		} else if( $product->is_type('subscription') ) {
			if ( $this->display_stock_alert_form($product) ) {
				do_action('woocommerce_product_stock_alert_form_before');
				echo $stock_interest;
				do_action('woocommerce_product_stock_alert_form_after');
			}
		} else {
			if ( $this->display_stock_alert_form($product) ) {
				do_action('woocommerce_product_stock_alert_form_before');
				echo $stock_interest;
				do_action('woocommerce_product_stock_alert_form_after');
			}
		}
	}

	function display_stock_alert_form($product) {
		$display_stock_alert_form = false;
		$dc_settings = $this->dc_plugin_settings;
		
		if( isset($product) && !empty($product) ) {
			if($product->is_type('simple')) {
				$stock_quantity = get_post_meta( $product->id, '_stock', true );
				$manage_stock = get_post_meta( $product->id, '_manage_stock', true );
			} else if($product->is_type('variation')) {
				$stock_quantity = get_post_meta( $product->variation_id, '_stock', true );
				$manage_stock = get_post_meta( $product->variation_id, '_manage_stock', true );
			} else if($product->is_type('subscription')) {
				$stock_quantity = get_post_meta( $product->id, '_stock', true );
				$manage_stock = get_post_meta( $product->id, '_manage_stock', true );
			} else {
				$stock_quantity = get_post_meta( $product->id, '_stock', true );
				$manage_stock = get_post_meta( $product->id, '_manage_stock', true );
			}
			if( isset($stock_quantity) && $manage_stock == 'yes' ) {
				if( $stock_quantity <= 0 ) {
					if( $product->backorders_allowed() ) {
						if( isset($dc_settings['is_enable_backorders']) && $dc_settings['is_enable_backorders'] == 'Enable' ) {
							$display_stock_alert_form = true;
						}
					} else {
						$display_stock_alert_form = true;
					}
				}
			}
		}
		
		return $display_stock_alert_form;
	}
	
}
