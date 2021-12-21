<?php
/**
 * ThemeREX Addons Third-party plugins API
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.29
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Define list with api
if (!function_exists('trx_addons_api_setup')) {
	add_action( 'after_setup_theme', 'trx_addons_api_setup', 2 );
	add_action( 'trx_addons_action_save_options', 'trx_addons_api_setup', 2 );
	function trx_addons_api_setup() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['api_list'] = apply_filters('trx_addons_api_list', array(
			
			'bbpress' => array(
							'title' => __('BB Press & Buddy Press', 'trx_addons')
						),
			'booked' => array(
							'title' => __('Booked Appointments', 'trx_addons')
						),
			'calculated-fields-form' => array(
							'title' => __('Calculated Fields Form', 'trx_addons')
						),
			'contact-form-7' => array(
							'title' => __('Contact Form 7', 'trx_addons')
						),
			'content_timeline' => array(
							'title' => __('Content Timeline', 'trx_addons')
						),
			'easy-digital-downloads' => array(
							'title' => __('Easy Digital Downloads', 'trx_addons')
						),
			'essential-grid' => array(
							'title' => __('Essential Grid', 'trx_addons')
						),
			'instagram-feed' => array(
							'title' => __('Instagram Feed', 'trx_addons')
						),
			'mailchimp-for-wp' => array(
							'title' => __('MailChimp for WordPress', 'trx_addons')
						),
			'revslider' => array(
							'title' => __('Revolution Slider', 'trx_addons')
						),
			'the-events-calendar' => array(
							'title' => __('The Events Calendar', 'trx_addons'),
							'layouts_sc' => array(
								'default'	=> esc_html__('Default', 'trx_addons'),
								'detailed'	=> esc_html__('Detailed', 'trx_addons')
							)
						),
			'trx_donations' => array(
							'title' => __('ThemeREX Donations', 'trx_addons')
						),
			'twitter' => array(
							'title' => __('Twitter', 'trx_addons'),
							// Always enabled!!!
							'std' => 1,
							'hidden' => true
						),
			'ubermenu' => array(
							'title' => __('UberMenu', 'trx_addons')
						),
			'js_composer' => array(
							'title' => __('WPBakery Page Builder', 'trx_addons'),
							// Always enabled!!!
							'std' => 1,
							'hidden' => true
						),

			'vc-extensions-bundle' => array(
							'title' => __('VC Extensions Bundle', 'trx_addons')
						),
			'woocommerce' => array(
							'title' => __('WooCommerce', 'trx_addons')
						),
            'wp-gdpr-compliance' => array(
                'title' => __('WP GDPR Compliance', 'trx_addons')
            ),
			'wpml' => array(
							'title' => __('WPML', 'trx_addons')
						)
			)
		);
	}
}

// Include files with api
if (!function_exists('trx_addons_api_load')) {
	add_action( 'after_setup_theme', 'trx_addons_api_load', 6 );
	add_action( 'trx_addons_action_save_options', 'trx_addons_api_load', 6 );
	function trx_addons_api_load() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		// Get theme-specific widget's args (if need)
		global $TRX_ADDONS_STORAGE;
		if (is_array($TRX_ADDONS_STORAGE['api_list']) && count($TRX_ADDONS_STORAGE['api_list']) > 0) {
			foreach ($TRX_ADDONS_STORAGE['api_list'] as $w=>$params) {
				if (empty($params['preloaded']) && trx_addons_components_is_allowed('api', $w)
					&& ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_API . "{$w}/{$w}.php")) != '') { 
					include_once $fdir;
				}
			}
		}
	}
}


// Add 'Third-party API' block in the ThemeREX Addons Components
if (!function_exists('trx_addons_api_components')) {
	add_filter( 'trx_addons_filter_components_blocks', 'trx_addons_api_components');
	function trx_addons_api_components($blocks=array()) {
		$blocks['api'] = __('Third-party plugins API', 'trx_addons');
		return $blocks;
	}
}


// Check if WPBakery Page Builder installed and activated
// Attention! This function is used in many files and must be declared here!!!
if ( !function_exists( 'trx_addons_exists_visual_composer' ) ) {
	function trx_addons_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}
?>