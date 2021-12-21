<?php

/**
 * Plugin Name:       Online Payments Bykea.cash
 * Plugin URI:        https://wordpress.org/plugins/bykea-cash-online-payments
 * Description:       This plugin helps WooCommerce (WordPress) customers pay via Debit / Credit Cards or Cash Pickups using Bykea Cash payment service. Please go to https://bykea.cash and create your payment URL.
 * Version:           1.9
 * Requires at least: 5.2
 * Requires PHP:      7.2.3
 * Author:            Bykea Technologies
 * Author URI:        http://www.bykea.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://wordpress.org/plugins/bykea-cash-online-payments
 * Text Domain:       bykea-cash-online-payments
*/

// Include our Gateway Class and register Payment Gateway with WooCommerce
add_action( 'plugins_loaded', 'opbc_init', 0 );
function opbc_init() {
	
	// If the parent WC_Payment_Gateway class doesn't exist
	// it means WooCommerce is not installed on the site
	// so do nothing
	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;
	
	// If we made it this far, then include our Gateway Class
	include_once( 'woocommerce-bykeacash.php' );

	// Now that we have successfully included our class,
	// Lets add it too WooCommerce
	add_filter( 'woocommerce_payment_gateways', 'opbc_gateway' );
	function opbc_gateway( $methods ) {
		$methods[] = 'OnlinePayments_BykeaCash';
		return $methods;
	}
}

// Add custom action links
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'opbc_action_links' );
function opbc_action_links( $links ) {
	$plugin_links = array(
		'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout' ) . '">' . __( 'Settings', 'opbc' ) . '</a>',
	);

	// Merge our new link with the default ones
	return array_merge( $plugin_links, $links );	
}

// Hide trailing zeros on prices.
add_filter( 'woocommerce_price_trim_zeros', 'opbc_hide_trailing_zeros', 10, 1 );
function opbc_hide_trailing_zeros( $trim ) {
    // set to false to show trailing zeros
    return true;
}

/**
 * Callback method for successful payment notification
 * @return true after email is sent successfully
 */
function opbc_notification_callback($request){
	$postData = $request->get_json_params();
	$detailsTextFiltered = explode(" ",sanitize_text_field($postData['details']));
	$orderId = (int) ltrim($detailsTextFiltered[0], "OrderID:");
	opbc_change_order_status($orderId);
	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;
	include_once( 'woocommerce-bykeacash.php' );
	$bcashApi = new OnlinePayments_BykeaCash();
	$to = $bcashApi->email;
	$subject = 'Bykea Cash Transaction Notification';
	$headers = array('Content-Type: text/html; charset=UTF-8');
	$message = '<html><body>';
	$message .= '<p>Hello Admin, you have received payment from '.$bcashApi->site_url.' through Bykea Cash. Details are as follows:</p>';
	$message .= '<p>Sender Mobile Number: <b>'.sanitize_text_field($postData['mobile_number']).'</b></p>';
	$message .= '<p>Amount: <b>Rs. '.sanitize_text_field($postData['amount']).'</b></p>';
	$message .= '<p>Payment Details: <b>'.sanitize_text_field($postData['details']).'</b></p>';
	$message .= '<p>Reference: <b>'.sanitize_text_field($postData['reference']).'</b></p>';
	$message .= '<p>Tracking Code: <b>'.sanitize_text_field($postData['transaction_id']).'</b></p>';
	$message .= '</body></html>';
	return wp_mail($to,$subject,$message,$headers);
}
add_action( 'rest_api_init', function () {
	register_rest_route( 'bcashapi/v1', '/notification_callback', array(
	  'methods' => 'POST',
	  'callback' => 'opbc_notification_callback',
	));
});     

/**
 * Method to update order status
 * @return true after email is sent successfully
 */
function opbc_change_order_status( $order_id ) {  
	if ( ! $order_id ) {return;}            
	$order = wc_get_order( $order_id );
	$order->update_status( 'wc-processing' );
}
add_action('init','opbc_change_order_status');

/**
 * When plugin is activated
 */

function opbc_activation_activity() { 
    $to = 'plugins@bykea.com';
	$subject = 'Bykea Cash Installation Notification';
	$headers = array('Content-Type: text/html; charset=UTF-8');
	$message = '<html><body>';
	$message .= '<p>Hello Bykea, a new website has activated your plugin. Please find the details below:</p>';
	$message .= '<p>Website Title: '.get_bloginfo('name').'</p>';
	$message .= '<p>Website URL: '.get_bloginfo('url').'</p>';
	$message .= '<p>Admin Email: '.get_bloginfo('admin_email').'</p>';
	$message .= '</body></html>';
	return wp_mail($to,$subject,$message,$headers);
}

register_activation_hook( __FILE__, 'opbc_activation_activity' );

/**
 * When plugin is deactivated
 */
function opbc_deactivation_activity() { 
    $to = 'plugins@bykea.com';
	$subject = 'Bykea Cash Uninstallation Notification';
	$headers = array('Content-Type: text/html; charset=UTF-8');
	$message = '<html><body>';
	$message .= '<p>Hello Bykea, your plugin is deactivated from '.get_bloginfo('name').' - '.get_bloginfo('url').'. Please find the admin email below if you want to investigate it.</p>';
	$message .= '<p>Admin Email: '.get_bloginfo('admin_email').'</p>';
	$message .= '</body></html>';
	return wp_mail($to,$subject,$message,$headers);
}
register_deactivation_hook( __FILE__, 'opbc_deactivation_activity' );