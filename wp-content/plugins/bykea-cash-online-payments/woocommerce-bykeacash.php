<?php
/**
 * Class OnlinePayments_BykeaCash file.
 *
 * @package WooCommerce\Gateways
 */

use Automattic\Jetpack\Constants;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Cash on Delivery Gateway.
 *
 * Provides a Cash on Delivery Payment Gateway.
 *
 * @class       OnlinePayments_BykeaCash
 * @extends     WC_Payment_Gateway
 * @version     2.1.0
 * @package     WooCommerce\Classes\Payment
 */
class OnlinePayments_BykeaCash extends WC_Payment_Gateway {

	/**
	 * Constructor for the gateway.
	 */
	public function __construct() {
		// Setup general properties.
		$this->setup_properties();

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Get settings.
		$this->title              = $this->get_option( 'title' );
		$this->description        = $this->get_option( 'description' );
		$this->instructions       = $this->get_option( 'instructions' );
		$this->enable_for_methods = $this->get_option( 'enable_for_methods', array() );
		$this->enable_for_virtual = $this->get_option( 'enable_for_virtual', 'yes' ) === 'yes';

		//BykeaCash Mobile Number
		$this->mobile_number = $this->get_option( 'mobile_number' );
        //BykeaCash Details Prefix
		$this->details_prefix = $this->get_option( 'details_prefix' );
		//BykeaCash Notification Email
		$this->email = $this->get_option( 'email' );
		//BykeaCash Business Name
		$this->business_name = $this->get_option( 'business_name' );
		//Site URL
		$this->site_url = site_url();

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'op_bykeacash_thankyou_page' ) );
		add_filter( 'woocommerce_payment_complete_order_status', array( $this, 'op_bykeacash_change_payment_complete_order_status' ), 10, 3 );

		// Customer Emails.
		add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
	}

	/**
	 * Setup general properties for the gateway.
	 */
	protected function setup_properties() {
		$this->id                 = 'bykea_cash';
		$this->icon = plugins_url('/bykea-cash-online-payments/bykea-cash-logo.png');
		$this->method_title       = __( 'Bykea Cash', 'online-payments-bykeacash' );
		$this->method_description = __( 'Bykea Cash Payment Gateway Plug-in for WooCommerce', 'online-payments-bykeacash' );
		$this->has_fields         = false;
	}

	/**
	 * Initialise Gateway Settings Form Fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title'		=> __( 'Enable / Disable', 'online-payments-bykeacash' ),
				'label'		=> __( 'Enable this payment gateway', 'online-payments-bykeacash' ),
				'type'		=> 'checkbox',
				'default'	=> 'no',
			),
			'title' => array(
				'title'		=> __( 'Title', 'online-payments-bykeacash' ),
				'type'		=> 'text',
				'desc_tip'	=> __( 'Payment title the customer will see during the checkout process.', 'online-payments-bykeacash' ),
				'default'	=> __( 'Debit or Credit Card', 'online-payments-bykeacash' ),
			),
			'description' => array(
				'title'		=> __( 'Description', 'online-payments-bykeacash' ),
				'type'		=> 'textarea',
				'desc_tip'	=> __( 'Payment description the customer will see during the checkout process.', 'online-payments-bykeacash' ),
				'default'	=> __( 'Pay via Cash or Visa / Mastercard securely using Bykea Cash.', 'online-payments-bykeacash' ),
				'css'		=> 'max-width:350px;'
			),
			'business_name' => array(
				'title'		=> __( 'Business Name', 'online-payments-bykeacash' ),
				'type'		=> 'text',
				'desc_tip'	=> __( 'Business name associated with your account.', 'online-payments-bykeacash' ),
			),
            'details_prefix' => array(
				'title'		=> __( 'Details Text', 'online-payments-bykeacash' ),
				'type'		=> 'text',
				'desc_tip'	=> __( 'Enter text you want with Order ID.', 'online-payments-bykeacash' ),
			),
			'email' => array(
				'title'		=> __( 'Email Address', 'online-payments-bykeacash' ),
				'type'		=> 'text',
				'desc_tip'	=> __( 'Email address assosiated with your account.', 'online-payments-bykeacash' ),
			),
			'mobile_number' => array(
				'title'		=> __( 'Bykea Cash Mobile Number', 'online-payments-bykeacash' ),
				'type'		=> 'text',
				'desc_tip'	=> __( 'Your Bykea Cash mobile number', 'online-payments-bykeacash' ),
			),
		);		
	}
	
	function payment_fields(){
		echo '<div style="margin-top: 5px;"><img style="float: none;" src="'.esc_html(plugins_url('bykea-cash-online-payments/bykea-full-payment-option.png')).'" alt="Bykea.Cash"></div><div style="padding-top:5px;" class="op-bykeacash-fulloptions">'.esc_html($this->description).'</div>';
	}

	/**
	 * Check If The Gateway Is Available For Use.
	 *
	 * @return bool
	 */
	public function is_available() {
		$order          = null;
		$needs_shipping = false;

		// Test if shipping is needed first.
		if ( WC()->cart && WC()->cart->needs_shipping() ) {
			$needs_shipping = true;
		} elseif ( is_page( wc_get_page_id( 'checkout' ) ) && 0 < get_query_var( 'order-pay' ) ) {
			$order_id = absint( get_query_var( 'order-pay' ) );
			$order    = wc_get_order( $order_id );

			// Test if order needs shipping.
			if ( $order && 0 < count( $order->get_items() ) ) {
				foreach ( $order->get_items() as $item ) {
					$_product = $item->get_product();
					if ( $_product && $_product->needs_shipping() ) {
						$needs_shipping = true;
						break;
					}
				}
			}
		}

		$needs_shipping = apply_filters( 'woocommerce_cart_needs_shipping', $needs_shipping );

		// Virtual order, with virtual disabled.
		if ( ! $this->enable_for_virtual && ! $needs_shipping ) {
			return false;
		}

		// Only apply if all packages are being shipped via chosen method, or order is virtual.
		if ( ! empty( $this->enable_for_methods ) && $needs_shipping ) {
			$order_shipping_items            = is_object( $order ) ? $order->get_shipping_methods() : false;
			$chosen_shipping_methods_session = WC()->session->get( 'chosen_shipping_methods' );

			if ( $order_shipping_items ) {
				$canonical_rate_ids = $this->get_canonical_order_shipping_item_rate_ids( $order_shipping_items );
			} else {
				$canonical_rate_ids = $this->get_canonical_package_rate_ids( $chosen_shipping_methods_session );
			}

			if ( ! count( $this->get_matching_rates( $canonical_rate_ids ) ) ) {
				return false;
			}
		}

		return parent::is_available();
	}

	/**
	 * Checks to see whether or not the admin settings are being accessed by the current request.
	 *
	 * @return bool
	 */
	private function is_accessing_settings() {
		if ( is_admin() ) {
			// phpcs:disable WordPress.Security.NonceVerification
			if ( ! isset( $_REQUEST['page'] ) || 'wc-settings' !== $_REQUEST['page'] ) {
				return false;
			}
			if ( ! isset( $_REQUEST['tab'] ) || 'checkout' !== $_REQUEST['tab'] ) {
				return false;
			}
			if ( ! isset( $_REQUEST['section'] ) || 'bykea_cash' !== $_REQUEST['section'] ) {
				return false;
			}
			// phpcs:enable WordPress.Security.NonceVerification

			return true;
		}

		if ( Constants::is_true( 'REST_REQUEST' ) ) {
			global $wp;
			if ( isset( $wp->query_vars['rest_route'] ) && false !== strpos( $wp->query_vars['rest_route'], '/payment_gateways' ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Loads all of the shipping method options for the enable_for_methods field.
	 *
	 * @return array
	 */
	private function load_shipping_method_options() {
		// Since this is expensive, we only want to do it if we're actually on the settings page.
		if ( ! $this->is_accessing_settings() ) {
			return array();
		}

		$data_store = WC_Data_Store::load( 'shipping-zone' );
		$raw_zones  = $data_store->get_zones();

		foreach ( $raw_zones as $raw_zone ) {
			$zones[] = new WC_Shipping_Zone( $raw_zone );
		}

		$zones[] = new WC_Shipping_Zone( 0 );

		$options = array();
		foreach ( WC()->shipping()->load_shipping_methods() as $method ) {

			$options[ $method->get_method_title() ] = array();

			// Translators: %1$s shipping method name.
			$options[ $method->get_method_title() ][ $method->id ] = sprintf( __( 'Any &quot;%1$s&quot; method', 'online-payments-bykeacash' ), $method->get_method_title() );

			foreach ( $zones as $zone ) {

				$shipping_method_instances = $zone->get_shipping_methods();

				foreach ( $shipping_method_instances as $shipping_method_instance_id => $shipping_method_instance ) {

					if ( $shipping_method_instance->id !== $method->id ) {
						continue;
					}

					$option_id = $shipping_method_instance->get_rate_id();

					// Translators: %1$s shipping method title, %2$s shipping method id.
					$option_instance_title = sprintf( __( '%1$s (#%2$s)', 'online-payments-bykeacash' ), $shipping_method_instance->get_title(), $shipping_method_instance_id );

					// Translators: %1$s zone name, %2$s shipping method instance name.
					$option_title = sprintf( __( '%1$s &ndash; %2$s', 'online-payments-bykeacash' ), $zone->get_id() ? $zone->get_zone_name() : __( 'Other locations', 'online-payments-bykeacash' ), $option_instance_title );

					$options[ $method->get_method_title() ][ $option_id ] = $option_title;
				}
			}
		}

		return $options;
	}

	/**
	 * Converts the chosen rate IDs generated by Shipping Methods to a canonical 'method_id:instance_id' format.
	 *
	 * @since  3.4.0
	 *
	 * @param  array $order_shipping_items  Array of WC_Order_Item_Shipping objects.
	 * @return array $canonical_rate_ids    Rate IDs in a canonical format.
	 */
	private function get_canonical_order_shipping_item_rate_ids( $order_shipping_items ) {

		$canonical_rate_ids = array();

		foreach ( $order_shipping_items as $order_shipping_item ) {
			$canonical_rate_ids[] = $order_shipping_item->get_method_id() . ':' . $order_shipping_item->get_instance_id();
		}

		return $canonical_rate_ids;
	}

	/**
	 * Converts the chosen rate IDs generated by Shipping Methods to a canonical 'method_id:instance_id' format.
	 *
	 * @since  3.4.0
	 *
	 * @param  array $chosen_package_rate_ids Rate IDs as generated by shipping methods. Can be anything if a shipping method doesn't honor WC conventions.
	 * @return array $canonical_rate_ids  Rate IDs in a canonical format.
	 */
	private function get_canonical_package_rate_ids( $chosen_package_rate_ids ) {

		$shipping_packages  = WC()->shipping()->get_packages();
		$canonical_rate_ids = array();

		if ( ! empty( $chosen_package_rate_ids ) && is_array( $chosen_package_rate_ids ) ) {
			foreach ( $chosen_package_rate_ids as $package_key => $chosen_package_rate_id ) {
				if ( ! empty( $shipping_packages[ $package_key ]['rates'][ $chosen_package_rate_id ] ) ) {
					$chosen_rate          = $shipping_packages[ $package_key ]['rates'][ $chosen_package_rate_id ];
					$canonical_rate_ids[] = $chosen_rate->get_method_id() . ':' . $chosen_rate->get_instance_id();
				}
			}
		}

		return $canonical_rate_ids;
	}

	/**
	 * Indicates whether a rate exists in an array of canonically-formatted rate IDs that activates this gateway.
	 *
	 * @since  3.4.0
	 *
	 * @param array $rate_ids Rate ids to check.
	 * @return boolean
	 */
	private function get_matching_rates( $rate_ids ) {
		// First, match entries in 'method_id:instance_id' format. Then, match entries in 'method_id' format by stripping off the instance ID from the candidates.
		return array_unique( array_merge( array_intersect( $this->enable_for_methods, $rate_ids ), array_intersect( $this->enable_for_methods, array_unique( array_map( 'wc_get_string_before_colon', $rate_ids ) ) ) ) );
	}

	/**
	 * Process the payment and return the result.
	 *
	 * @param int $order_id Order ID.
	 * @return array
	 */
	public function process_payment( $order_id ) {
		$order = wc_get_order( $order_id );

		if ( $order->get_total() > 0 ) {
			// Mark as processing or on-hold (payment won't be taken until delivery).
			$order->update_status( apply_filters( 'woocommerce_bykeacash_process_payment_order_status', $order->has_downloadable_item() ? 'on-hold' : 'pending', $order ), __( 'Payment to be processed through Bykea Cash.', 'online-payments-bykeacash' ) );
		} else {
			$order->payment_complete();
		}

		// Remove cart.
		WC()->cart->empty_cart();

		//Total Cost
		$total_cost = ceil($order->total);
		
		//Order ID to pass in the BykeaCash API
		$order_id = $order->id;

		//Mobile Number Assosited with BykeaCash
		$mobile_number = $this->mobile_number;
		
		//Business name Assosited with BykeaCash
		$business_name = $this->business_name;

		//Site URL
		$url = site_url();

        // Details Prefix
        $details_prefix = $this->details_prefix;

		// Return thankyou redirect.
		return array(
			'result'   => 'success',
			'redirect' => 'https://bykea.cash/'.$mobile_number.'/?amount='.$total_cost.'&details=OrderID:'.$order_id.' '. $details_prefix.'&reference=Order:'.$order_id." ".$_SERVER['HTTP_HOST'],
		);
	}

	/**
	 * Output for the order received page.
	 */
	public function op_bykeacash_thankyou_page() {
		if ( $this->instructions ) {
			echo wp_kses_post( wpautop( wptexturize( $this->instructions ) ) );
		}
	}

	/**
	 * Change payment complete order status to completed for BykeaCash orders.
	 *
	 * @since  3.1.0
	 * @param  string         $status Current order status.
	 * @param  int            $order_id Order ID.
	 * @param  WC_Order|false $order Order object.
	 * @return string
	 */
	public function op_bykeacash_change_payment_complete_order_status( $status, $order_id = 0, $order = false ) {
		if ( $order && 'bykea_cash' === $order->get_payment_method() ) {
			$status = 'completed';
		}
		return $status;
	}

	/**
	 * Add content to the WC emails.
	 *
	 * @param WC_Order $order Order object.
	 * @param bool     $sent_to_admin  Sent to admin.
	 * @param bool     $plain_text Email format: plain text or HTML.
	 */
	public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
		if ( $this->instructions && ! $sent_to_admin && $this->id === $order->get_payment_method() ) {
			echo wp_kses_post( wpautop( wptexturize( $this->instructions ) ) . PHP_EOL );
		}
	}
}