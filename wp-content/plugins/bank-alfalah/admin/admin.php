<?php
/**
 * Woocommerce Plugin
 * Alfa Payment Gateway Woocommerce Payment Gateway
 * Admin Panel for settings.
 */

defined( 'ABSPATH' ) or exit;

/**
 * Add the gateway to WC Available Gateways
 * 
 * @since 1.0
 * @param array $gateways all available WC gateways
 * @return array $gateways all WC gateways + bank alfalah gateway
 */
function bank_alfalah_add_to_gateways( $gateways ) {
	$gateways[] = 'WC_BankAlfalah_Geteway';
	return $gateways;
}
add_filter( 'woocommerce_payment_gateways', 'bank_alfalah_add_to_gateways' );


/**
 * Alfa Payment Gateway Payment Gateway
 *
 * Provides Alfa Payment Gateway Payment Gateway.
 *
 * @class 		WC_BankAlfalah_Geteway
 * @extends		WC_Payment_Gateway
 * @version		1.0
 * @package		WooCommerce/Classes/Payment
 * @author 		Alfa Payment Gateway
 */
function bank_alfalah_gateway_init() {
    
    class WC_BankAlfalah_Geteway extends WC_Payment_Gateway {
    	/**
    	 * Constructor for the gateway.
    	 */
    	public function __construct() {
      
    		$this->id                 = BAF_WOO_GATEWAY_ID;
    		$this->icon               = apply_filters('woocommerce_bank_alfalah_icon', '');
    		$this->has_fields         = true;
    		$this->method_title       = __( 'Alfalah Payment Gateway', BAF_WOO_TEXT_DOMAIN );
    		$this->method_description = __( 'Allows payments by Alfa Payment Gateway.', BAF_WOO_TEXT_DOMAIN );
    	  
    		$this->init_form_fields();
    		$this->init_settings();

    		$this->title              = $this->get_option( 'title' );
            $this->enabled            = $this->get_option( 'enabled' );
            $this->sandbox_enabled    = $this->get_option( 'sandbox_enabled' );
            $this->merchant_id        = $this->get_option( 'merchant_id' );
            $this->store_id           = $this->get_option( 'store_id' );
            $this->merchant_hash      = $this->get_option( 'merchant_hash' );
            $this->merchant_username  = $this->get_option( 'merchant_username' );
            $this->merchant_password  = $this->get_option( 'merchant_password' );
            $this->key_one            = $this->get_option( 'key_one' );
            $this->key_two            = $this->get_option( 'key_two' );
            
            $this->credit_card       = $this->get_option( 'credit_card' );
            $this->wallet            = $this->get_option( 'wallet' );
            $this->alfalah_account   = $this->get_option( 'alfalah_account' );
    		
            $this->description        = $this->get_option( 'description' );
            $this->instructions       = $this->get_option( 'instructions', $this->description );

            $this->bafl_url_handshake = "https://payments.bankalfalah.com/HS/HS/HS";
            $this->bafl_url_payment   = "https://payments.bankalfalah.com/SSO/SSO/SSO";
            $this->bafl_url_ipn       = "https://payments.bankalfalah.com/HS/api/IPN/OrderStatus/{$this->merchant_id}/{$this->store_id}/";

            if ($this->sandbox_enabled == "yes") {
                $this->bafl_url_handshake = "https://sandbox.bankalfalah.com/HS/HS/HS";
                $this->bafl_url_payment   = "https://sandbox.bankalfalah.com/SSO/SSO/SSO";
                $this->bafl_url_ipn       = "https://sandbox.bankalfalah.com/HS/api/IPN/OrderStatus/{$this->merchant_id}/{$this->store_id}/";
            }

    		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
            add_action( 'woocommerce_receipt_' . $this->id, array(&$this, 'bank_alfalah_receipt_page' ) );
            add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ), 5, 1 );
            add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
            add_action( 'woocommerce_api_' . $this->id, array($this, 'check_ipn_response') );
    	}
    
    	/**
    	 * Initialize Gateway Settings Form Fields
    	 */
    	public function init_form_fields() {
      
    		$this->form_fields = apply_filters( 'bank_alfalah_form_fields', array(
          
                
    			'listener_url' => array(
    				'title'   => __( 'IPN Listener URL', BAF_WOO_TEXT_DOMAIN ),
    				'type'    => 'title',
    				'description'   => __( home_url('wc-api/'. $this->id) . "<br /><br />(Listener URL for BAFL Merchants Portal)", BAF_WOO_TEXT_DOMAIN ),
    				'default' => 'yes'
                ),
                                
    			'enabled' => array(
    				'title'   => __( 'Enable/Disable', BAF_WOO_TEXT_DOMAIN ),
    				'type'    => 'checkbox',
    				'label'   => __( 'Enable/Disable', BAF_WOO_TEXT_DOMAIN ),
    				'default' => 'yes'
    			),
                
                'sandbox_enabled' => array(
    				'title'   => __( 'Gateway status', BAF_WOO_TEXT_DOMAIN ),
    				'type'    => 'select',
    				'default' => 'yes',
                    'options'     => array(
                        'yes' => __('Sandbox mode', BAF_WOO_TEXT_DOMAIN ),
                        'no' => __('Live mode', BAF_WOO_TEXT_DOMAIN )
                    )
    			),
    			
                'title' => array(
    				'title'       => __( 'Alfa Payment Gateway', BAF_WOO_TEXT_DOMAIN ),
    				'type'        => 'text',
    				'description' => __( 'You can change payment name on your website.', BAF_WOO_TEXT_DOMAIN ),
    				'default'     => __( 'Alfa Payment Gateway', BAF_WOO_TEXT_DOMAIN ),
    				'desc_tip'    => true,
    			),
                
    			'merchant_id' => array(
    				'title'       => __( 'Merchant ID', BAF_WOO_TEXT_DOMAIN ),
    				'type'        => 'text',
    				'description' => __( 'You should add here bank alfalah merchant id.', BAF_WOO_TEXT_DOMAIN ),
    				'default'     => __( '', BAF_WOO_TEXT_DOMAIN ),
    				'desc_tip'    => true,
    			),
                
                'store_id' => array(
    				'title'       => __( 'Store ID', BAF_WOO_TEXT_DOMAIN ),
    				'type'        => 'text',
    				'description' => __( 'You should add here bank alfalah store id.', BAF_WOO_TEXT_DOMAIN ),
    				'default'     => __( '', BAF_WOO_TEXT_DOMAIN ),
    				'desc_tip'    => true,
    			),
                
                'merchant_hash' => array(
    				'title'       => __( 'Merchant Hash', BAF_WOO_TEXT_DOMAIN ),
    				'type'        => 'text',
    				'description' => __( 'You should add here bank alfalah merchant hash.', BAF_WOO_TEXT_DOMAIN ),
    				'default'     => __( '', BAF_WOO_TEXT_DOMAIN ),
    				'desc_tip'    => true,
    			),
                
                'merchant_username' => array(
    				'title'       => __( 'Merchant Username', BAF_WOO_TEXT_DOMAIN ),
    				'type'        => 'text',
    				'description' => __( 'You should add here bank alfalah merchant username.', BAF_WOO_TEXT_DOMAIN ),
    				'default'     => __( '', BAF_WOO_TEXT_DOMAIN ),
    				'desc_tip'    => true,
    			),
                
                'merchant_password' => array(
    				'title'       => __( 'Merchant Password', BAF_WOO_TEXT_DOMAIN ),
    				'type'        => 'text',
    				'description' => __( 'You should add here bank alfalah merchant password.', BAF_WOO_TEXT_DOMAIN ),
    				'default'     => __( '', BAF_WOO_TEXT_DOMAIN ),
    				'desc_tip'    => true,
    			),
                
                'key_one' => array(
    				'title'       => __( 'Key 1', BAF_WOO_TEXT_DOMAIN ),
    				'type'        => 'text',
    				'description' => __( 'You should add here bank alfalah key one.', BAF_WOO_TEXT_DOMAIN ),
    				'default'     => __( '', BAF_WOO_TEXT_DOMAIN ),
    				'desc_tip'    => true,
    			),
                
                'key_two' => array(
    				'title'       => __( 'Key 2', BAF_WOO_TEXT_DOMAIN ),
    				'type'        => 'text',
    				'description' => __( 'You should add here bank alfalah key two.', BAF_WOO_TEXT_DOMAIN ),
    				'default'     => __( '', BAF_WOO_TEXT_DOMAIN ),
    				'desc_tip'    => true,
    			),
    			
                'credit_card' => array(
    				'title'   => __( 'Credit/Debit Card', BAF_WOO_TEXT_DOMAIN ),
    				'type'    => 'checkbox',
    				'label'   => __( 'Enable/Disable', BAF_WOO_TEXT_DOMAIN ),
    				'default' => 'yes'
    			),
                
                'wallet' => array(
    				'title'   => __( 'Alfa Wallet', BAF_WOO_TEXT_DOMAIN ),
    				'type'    => 'checkbox',
    				'label'   => __( 'Enable/Disable', BAF_WOO_TEXT_DOMAIN ),
    				'default' => 'yes'
    			),
                
                'alfalah_account' => array(
    				'title'   => __( 'Bank Alfalah Account', BAF_WOO_TEXT_DOMAIN ),
    				'type'    => 'checkbox',
    				'label'   => __( 'Enable/Disable', BAF_WOO_TEXT_DOMAIN ),
    				'default' => 'yes'
    			),
                
    			'description' => array(
    				'title'       => __( 'Description', BAF_WOO_TEXT_DOMAIN ),
    				'type'        => 'textarea',
    				'description' => __( 'Payment method description that the customer will see on your checkout.', BAF_WOO_TEXT_DOMAIN ),
    				'default'     => __( '', BAF_WOO_TEXT_DOMAIN ),
    				'desc_tip'    => true,
    			),
    			
    			'instructions' => array(
    				'title'       => __( 'Instructions', BAF_WOO_TEXT_DOMAIN ),
    				'type'        => 'textarea',
    				'description' => __( 'Instructions that will be added to the thank you page and emails.', BAF_WOO_TEXT_DOMAIN ),
    				'default'     => '',
    				'desc_tip'    => true,
    			),
    		) );
    	}
        
        /**
    	 * Output of the form.
    	 */
        public function payment_fields() {
            if ( $this->description ) {
                if ( $this->sandbox_enabled == 'yes' ) {
                    $this->description .= ' <br /><span class="sandbox-error">Sandbox mode is enable, for more info please see <a href="#" target="_blank" rel="noopener noreferrer">documentation</a>.</span>';
                    $this->description  = trim( $this->description );
                }
                echo wpautop( wp_kses_post( $this->description ) );
            }
            do_action( 'woocommerce_bank_alfalah_form_start', $this->id );
            ?>
            <div class="wc-<?php echo esc_attr( $this->id ); ?>">
                <div class="bank-alfalah-payment-type">
                    <span class="handshake-success">&#10004;</span>
                    <span class="handshake-error">&#10006;</span>
                    <?php if ( $this->credit_card == 'yes' ) { ?>
                    <div class="bank-alfalah-redio">
                        <label for="alfalah-card"><input type="radio" name="bank-alfalah-payment-type" value="3" id="alfalah-card"/> <img src="<?php echo BAF_WOO_IMG; ?>bank_alfalah_logo.png" /> <?php _e( 'Credit/Debit Card', BAF_WOO_TEXT_DOMAIN ); ?></label>
                    </div>
                    <?php } ?>
                    
                    <?php if ( $this->wallet == 'yes' ) { ?>
                    <div class="bank-alfalah-redio">
                        <label for="alfalah-wallet"><input type="radio" name="bank-alfalah-payment-type" value="1" id="alfalah-wallet"/> <img src="<?php echo BAF_WOO_IMG; ?>bank_alfalah_logo.png" /> <?php _e( 'Alfa Wallet', BAF_WOO_TEXT_DOMAIN ); ?></label>
                    </div>
                    <?php } ?>
                    
                    <?php if ( $this->alfalah_account == 'yes' ) { ?>
                    <div class="bank-alfalah-redio">
                        <label for="alfalah-account"><input type="radio" name="bank-alfalah-payment-type" value="2" id="alfalah-account" /> <img src="<?php echo BAF_WOO_IMG; ?>bank_alfalah_logo.png" /> <?php _e( 'Bank Alfalah Account', BAF_WOO_TEXT_DOMAIN ); ?></label>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <script>
                jQuery("#alfalah-card").prop("checked", false).checkboxradio("refresh");
                jQuery("#alfalah-wallet").prop("checked", false).checkboxradio("refresh");
                jQuery("#alfalah-account").prop("checked", false).checkboxradio("refresh");
            </script>
            <?php
            do_action( 'woocommerce_bank_alfalah_form_end', $this->id );
        }

        public function get_ipn_response($order_id = null) {
            if ($order_id === null) {
                return;
            }
            $url= $this->bafl_url_ipn . $order_id;

            $context_options = array(
                "ssl" => array(
                    "verify_peer"      => false,
                    "verify_peer_name" => false,
                ),
            );  
            
            $response = file_get_contents($url, false, stream_context_create($context_options));
            return json_decode(json_decode($response, true),true);
        }
        
        public function get_ipn_response2($url = null) {
            if ($url === null) {
                return;
            }

            $context_options = array(
                "ssl" => array(
                    "verify_peer"      => false,
                    "verify_peer_name" => false,
                ),
            );  
            
            $response = file_get_contents($url, 'r', false, stream_context_create($context_options));
            return json_decode(json_decode($response, true),true);
        }
        
    	/**
    	 * Output for the order received page.
    	 */
    	public function thankyou_page($order_id) {
            global $woocommerce;
            global $order;
            $order  = new WC_Order($order_id);
            
            if ( $this->instructions ) {
    			echo wpautop( wptexturize( $this->instructions ) );
    		}
    	}
    
    	/**
    	 * Add content to the WC emails.
    	 *
    	 * @access public
    	 * @param WC_Order $order
    	 * @param bool $sent_to_admin
    	 * @param bool $plain_text
    	 */
    	public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
    		if ( $this->instructions && ! $sent_to_admin && $this->id === $order->payment_method && $order->has_status( 'completed' ) ) {
    			echo wpautop( wptexturize( $this->instructions ) ) . PHP_EOL;
    		}
    	}
    
    	/**
    	 * Process the payment and return the result
    	 *
    	 * @param int $order_id
    	 * @return array
    	 */
    	public function process_payment( $order_id ) {
            $order = new WC_Order($order_id);
            $order->update_meta_data( 'bank-alfalah-payment-type', isset($_POST['bank-alfalah-payment-type']) ? $_POST['bank-alfalah-payment-type'] : 1 );
            $order->save();
            return array(
                'result' 	=> 'success',
                'redirect'	=> $order->get_checkout_payment_url( true )
            );
    	}
        
        /**
    	 * Redirect
    	 *
    	 * @param int $order_id
    	 * @return array
    	 */
        public function bank_alfalah_receipt_page($order){
            echo '<p>'.__('Thank you for your order, please click the button below to pay with Alfa Payment Gateway.', BAF_WOO_TEXT_DOMAIN ).'</p>';
            echo $this->bank_alfalah_generate_authorize_form($order);
        }
        
        /**
    	 * Generate Authorize Form
    	 *
    	 * @param int $order_id
    	 * @return array
    	 */
        public function bank_alfalah_generate_authorize_form($order_id){
            global $woocommerce;
            $order  = new WC_Order($order_id);
            $amount = $order->get_total();
            $bank_alfalah_option = get_option( 'woocommerce_bank_alfalah_gateway_settings' );
            $currency = get_woocommerce_currency();
     
            $HS_ChannelId = "1001";
            $HS_ReturnURL = $order->get_checkout_order_received_url();
            $HS_IsRedirectionRequest = 0;
            $TransactionTypeId = $order->get_meta('bank-alfalah-payment-type');

            $KeyOne = $bank_alfalah_option['key_one'];
            $KeyTwo = $bank_alfalah_option['key_two'];
            
            $AuthToken              = "";
            $HS_MerchantId          = $bank_alfalah_option['merchant_id'];
            $HS_StoreId             = $bank_alfalah_option['store_id'];
            $HS_MerchantHash        = $bank_alfalah_option['merchant_hash'];
            $HS_MerchantUsername    = $bank_alfalah_option['merchant_username'];
            $HS_MerchantPassword    = $bank_alfalah_option['merchant_password'];
            
            $post = [];
            $post['HS_IsRedirectionRequest']        = 0;
            $post['HS_ChannelId']                   = $HS_ChannelId;
            $post['HS_MerchantId']                  = $HS_MerchantId;
            $post['HS_StoreId']                     = $HS_StoreId;
            $post['HS_ReturnURL']                   = $HS_ReturnURL;
            $post['HS_MerchantHash']                = $HS_MerchantHash;
            $post['HS_MerchantUsername']            = $HS_MerchantUsername;
            $post['HS_MerchantPassword']            = $HS_MerchantPassword;
            $post['HS_TransactionReferenceNumber']  = $order_id;
            
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
            
            $response = wp_remote_post( $this->bafl_url_handshake , $args );
            $json = json_decode($response['body']);
            
            $Success    = $json->success;
            $AuthToken  = $json->AuthToken;
            $ReturnURL  = $json->ReturnURL;    
            
            $post = [];
            $post['AuthToken']                  = $AuthToken;
            $post['RequestHash']                = $cipher_text64;
            $post['ChannelId']                  = $HS_ChannelId;
            $post['Currency']                   = $currency;
            $post['ReturnURL']                  = $ReturnURL;
            $post['MerchantId']                 = $HS_MerchantId;
            $post['StoreId']                    = $HS_StoreId;
            $post['MerchantHash']               = $HS_MerchantHash;
            $post['MerchantUsername']           = $HS_MerchantUsername;
            $post['MerchantPassword']           = $HS_MerchantPassword;
            $post['TransactionTypeId']          = $TransactionTypeId;
            $post['TransactionReferenceNumber'] = $order_id;
            $post['TransactionAmount']          = $amount;
            
            $data = [];
            foreach($post as $k => $v) {
                $data[] = implode("=", [$k, $v]);
            }
            
            $mapString = implode('&', $data);   
            
            $cipher="aes-128-cbc";
            $cipher_text = openssl_encrypt(utf8_encode($mapString), $cipher, utf8_encode($KeyOne),   OPENSSL_RAW_DATA , utf8_encode($KeyTwo));
            $cipher_text64 =  base64_encode($cipher_text);
            
            $post['RequestHash'] = $cipher_text64 ;
            
            $html_args = array(
                'AuthToken'                     => $AuthToken,
                'RequestHash'                   => $cipher_text64,
                'ChannelId'                     => $HS_ChannelId,
                'Currency'                      => $currency,
                'ReturnURL'                     => $ReturnURL,
                'MerchantId'                    => $HS_MerchantId,
                'StoreId'                       => $HS_StoreId,
                'MerchantHash'                  => $HS_MerchantHash,
                'MerchantUsername'              => $HS_MerchantUsername,
                'MerchantPassword'              => $HS_MerchantPassword,
                'TransactionTypeId'             => $TransactionTypeId,
                'TransactionReferenceNumber'    => $order_id,
                'TransactionAmount'             => $amount
            );
            
            $html_fields = array();
            
            foreach($html_args as $key => $value){
                $html_fields[] = "<input id='$key' type='hidden' name='$key' value='$value'/>";
            }
            
            $html_form    = '<form action="' . $this->bafl_url_payment . '" method="post" id="PageRedirectionForm" novalidate="novalidate">' 
            . implode('', $html_fields) 
            . '<input type="submit" class="button" id="run" value="'.__('Pay via Alfa Payment Gateway', BAF_WOO_TEXT_DOMAIN ).'" />'
            . '<script type="text/javascript">
            jQuery(function(){
            jQuery("body").block({
            message: "<img src=\"' . BAF_WOO_IMG . 'baf.png\" alt=\"Redirecting…\" style=\"float:left; margin-right: 10px;top:10px;\" />'.__('Kindly wait, you are being redirected to Alfa Payment Gateway to complete your payment', BAF_WOO_TEXT_DOMAIN ).'",
                overlayCSS:{
                    background:       "#FFFFFF",
                    opacity:          1,
                    "z-index": "99999999999999999999999999999999"
                },
                centerX: true, // <-- only effects element blocking (page block controlled via css above) 
                centerY: true, 
                css: {
                    padding:          20,
                    textAlign:        "center",
                    top:              "-40%",
                    bottom: "60%",
                    color:            "#555",
                    backgroundColor:  "#fff",
                    cursor:           "wait",
                    lineHeight:       "32px",
                    "z-index": "999999999999999999999999999999999"
                }
                });
            jQuery("#run").click();
            });
            </script>
            </form>';
            
            return $html_form;
        }

        public function check_ipn_response() {

            if(!isset($_GET['url'])) {
                exit;
            }

            $url = $_GET['url'];

            if ($response = $this->get_ipn_response2($url)) {
                if ($order_id = $response['TransactionReferenceNumber']) {
                    if ($order = wc_get_order($order_id)) {
                        if ($response['TransactionStatus'] == BAF_WOO_TX_SUCCESS) {
                            $order->update_status( 'processing', __( 'Payment sucessful', BAF_WOO_TEXT_DOMAIN ) );
                        } else {
                            $order->update_status( 'failed', __( 'Payment failed', BAF_WOO_TEXT_DOMAIN ) );
                        }
                    }
                }
            }
            exit;
        }

    }
}
add_action( 'plugins_loaded', 'bank_alfalah_gateway_init', 11 );
?>