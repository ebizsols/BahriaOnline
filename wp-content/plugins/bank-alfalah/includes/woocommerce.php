<?php
/**
 * Woocommerce Plugin
 * Alfa Payment Gateway Woocommerce Payment Gateway
 * Payment Icon
 */
function woocommerce_bank_alfalah_icon(){
    return BAF_WOO_IMG .'bank_alfalah_logo.png';
}
//add_filter( 'woocommerce_bank_alfalah_icon', 'woocommerce_bank_alfalah_icon' );

/**
 * Woocommerce Plugin
 * Alfa Payment Gateway Woocommerce Payment Gateway
 * Admin Test Connection HTML
 */
function bank_alfalah_admin_page_now_test(){
    global $pagenow;
    
    $bank_alfalah_gateway_url = explode( '=', $_SERVER['REQUEST_URI'] );
    $bank_alfalah_gateway_page = $bank_alfalah_gateway_url[sizeof($bank_alfalah_gateway_url)-1];
    $bank_alfalah_option = get_option( 'woocommerce_bank_alfalah_gateway_settings' );
    if( $bank_alfalah_gateway_page == 'bank_alfalah_gateway' ){ ?>
        <div id="bank_alfalah_testing" class="bank_alfalah_testing">
            <button id="bank_alfalah_testing_button" class="button-primary bank_alfalah_testing_button"><?php _e( 'Click Here For Test Connection', BAF_WOO_TEXT_DOMAIN ); ?></button>
            <div id="bank_alfalah_testing_responce_wait"><img src="<?php echo admin_url( 'images/loading.gif' ); ?>" /><?php _e( ' Please Wait...', BAF_WOO_TEXT_DOMAIN ); ?></div>
            <div id="bank_alfalah_testing_responce_success"><?php _e( 'Connection Successful', BAF_WOO_TEXT_DOMAIN ); ?></div>
            <div id="bank_alfalah_testing_responce_error"><?php _e( 'Connection Unsuccessful', BAF_WOO_TEXT_DOMAIN ); ?></div>
        </div>
v    <?php
    }
}
add_action( 'admin_footer', 'bank_alfalah_admin_page_now_test' );
/**
 * Redirect Success / Faild
 *
 * @param int $order_id
 * @return array
 */
function bank_alfalah_redirect_thankyou_page(){

    // Get the desired WC_Payment_Gateway object

    // if ($status_data['TransactionStatus'] == BAF_WOO_TX_SUCCESS) {
    //     $order->update_status( 'processing', __( 'Payment sucessful', BAF_WOO_TEXT_DOMAIN ) );
    // } else {
    //     $order->update_status( 'failed', __( 'Payment failed', BAF_WOO_TEXT_DOMAIN ) );
    // }

    global $wp;
    if( is_wc_endpoint_url( 'order-received' ) && ($order_id = isset($wp->query_vars['order-received']) ? $wp->query_vars['order-received'] : null) ) {
        $order_gateway = get_post_meta( $order_id, '_payment_method', true );
        if ($order_gateway == BAF_WOO_GATEWAY_ID) {
            $order = wc_get_order($order_id);

            if ( !isset($_GET['key']) || !$_GET['key'] ){
                $order_key = $order->get_order_key();
                wp_redirect( home_url( '/checkout/order-received/' . $order_id . '/?key=' . $order_key ) );
                die;
            }

            if( isset( $_GET['key'] ) ) {
                $payment_gateways_instance = WC_Payment_Gateways::instance();
                $payment_gateways = $payment_gateways_instance->payment_gateways();
                if (isset($payment_gateways['bank_alfalah_gateway'])) {
                    $payment_gateway = $payment_gateways[BAF_WOO_GATEWAY_ID];
                    $response = $payment_gateway->get_ipn_response($order_id );
                    if ($response['TransactionStatus'] == BAF_WOO_TX_SUCCESS) {
                        $order->update_status( 'processing', __( 'Payment sucessful', BAF_WOO_TEXT_DOMAIN ) );
                    } else {
                        $order->update_status( 'failed', __( 'Payment failed', BAF_WOO_TEXT_DOMAIN ) );
                    }
                }
            }
        }
    }
}
add_action( 'template_redirect', 'bank_alfalah_redirect_thankyou_page', 5 );

/**
 * Woocommerce Plugin
 * Alfa Payment Gateway Woocommerce Payment Gateway
 * Admin Test Connection Request
 */
function bank_alfalah_AuthToken(){
    
    $bank_alfalah_option = get_option( 'woocommerce_bank_alfalah_gateway_settings' );
    $currency = get_woocommerce_currency();
    
    $HS_ChannelId = "1001";
    $HS_ReturnURL = "https://google.com";
    $HS_IsRedirectionRequest = 0;
    
    $Sandbox = $bank_alfalah_option['sandbox_enabled'];
    $url = $Sandbox == "yes" ? "https://sandbox.bankalfalah.com/HS/HS/HS" : "https://payments.bankalfalah.com/HS/HS/HS";
    $KeyOne = $bank_alfalah_option['key_one'];
    $KeyTwo = $bank_alfalah_option['key_two'];

    $AuthToken              = "";
    $HS_MerchantId          = $bank_alfalah_option['merchant_id'];
    $HS_StoreId             = $bank_alfalah_option['store_id'];
    $HS_MerchantHash        = $bank_alfalah_option['merchant_hash'];
    $HS_MerchantUsername    = $bank_alfalah_option['merchant_username'];
    $HS_MerchantPassword    = $bank_alfalah_option['merchant_password'];
    
    $post = [];
    $post['HS_IsRedirectionRequest']        = $HS_IsRedirectionRequest;
    $post['HS_ChannelId']                   = $HS_ChannelId;
    $post['HS_MerchantId']                  = $HS_MerchantId;
    $post['HS_StoreId']                     = $HS_StoreId;
    $post['HS_ReturnURL']                   = $HS_ReturnURL;
    $post['HS_MerchantHash']                = $HS_MerchantHash;
    $post['HS_MerchantUsername']            = $HS_MerchantUsername;
    $post['HS_MerchantPassword']            = $HS_MerchantPassword;
    $post['HS_TransactionReferenceNumber']  = isset($_GET['order']) ? $_GET['order'] : rand(20000, 200000);
    
    $data = [];
    foreach($post as $k => $v) {
        $data[] = implode("=", [$k, $v]);
    }

    $mapString = implode('&', $data);
    
    $cipher="aes-128-cbc";
    $cipher_text = openssl_encrypt(utf8_encode($mapString), $cipher, utf8_encode($KeyOne),   OPENSSL_RAW_DATA , utf8_encode($KeyTwo));
    $cipher_text64 =  base64_encode($cipher_text);
    
    $post['HS_RequestHash'] = $cipher_text64 ;
    
    $args = array(
        'method' => 'POST',
        'timeout' => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'body' => $post,
        'sslverify' => false,
        'blocking' => true,
        'headers' => array('Content-type: application/x-www-form-urlencoded'),
        'cookies' => array()
    );
    
    $response = wp_remote_post( $url, $args );
    $json = json_decode($response['body']);
    
    $Success    = $json->success;
    $AuthToken  = $json->AuthToken;
    $ReturnURL  = $json->ReturnURL;
    
    $AuthTokenResponce = array(
        'success'   => 200,
        'url'       => $url,
        'status'    => $Success,
        'AuthToken' => $AuthToken,
        'ReturnURL' => $ReturnURL
    );
    
    wp_send_json($AuthTokenResponce);
    exit();
}
add_action( 'wp_ajax_nopriv_bank_alfalah_AuthToken', 'bank_alfalah_AuthToken' );
add_action( 'wp_ajax_bank_alfalah_AuthToken', 'bank_alfalah_AuthToken' );
?>
