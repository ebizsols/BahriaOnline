<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crework_mailchimp_theme_setup9')) {
	add_action( 'after_setup_theme', 'crework_mailchimp_theme_setup9', 9 );
	function crework_mailchimp_theme_setup9() {
		if (crework_exists_mailchimp()) {
			add_action( 'wp_enqueue_scripts',							'crework_mailchimp_frontend_scripts', 1100 );
			add_filter( 'crework_filter_merge_styles',					'crework_mailchimp_merge_styles');
		}
		if (is_admin()) {
			add_filter( 'crework_filter_tgmpa_required_plugins',		'crework_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'crework_exists_mailchimp' ) ) {
	function crework_exists_mailchimp() {
		return function_exists('__mc4wp_load_plugin') || defined('MC4WP_VERSION');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'crework_mailchimp_tgmpa_required_plugins' ) ) {
	
	function crework_mailchimp_tgmpa_required_plugins($list=array()) {
		if (in_array('mailchimp-for-wp', crework_storage_get('required_plugins')))
			$list[] = array(
				'name' 		=> esc_html__('MailChimp for WP', 'crework'),
				'slug' 		=> 'mailchimp-for-wp',
				'required' 	=> false
			);
		return $list;
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue custom styles
if ( !function_exists( 'crework_mailchimp_frontend_scripts' ) ) {
	
	function crework_mailchimp_frontend_scripts() {
		if (crework_exists_mailchimp()) {
			if (crework_is_on(crework_get_theme_option('debug_mode')) && crework_get_file_dir('plugins/mailchimp-for-wp/mailchimp-for-wp.css')!='')
				wp_enqueue_style( 'crework-mailchimp-for-wp',  crework_get_file_url('plugins/mailchimp-for-wp/mailchimp-for-wp.css'), array(), null );
		}
	}
}
	
// Merge custom styles
if ( !function_exists( 'crework_mailchimp_merge_styles' ) ) {
	
	function crework_mailchimp_merge_styles($list) {
		$list[] = 'plugins/mailchimp-for-wp/mailchimp-for-wp.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (crework_exists_mailchimp()) { require_once CREWORK_THEME_DIR . 'plugins/mailchimp-for-wp/mailchimp-for-wp.styles.php'; }
?>