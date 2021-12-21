<?php
/* gdpr-compliance support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crework_gdpr_theme_setup9')) {
	add_action( 'after_setup_theme', 'crework_gdpr_theme_setup9', 9 );
	function crework_gdpr_theme_setup9() {
		if (is_admin()) {
			add_filter( 'crework_filter_tgmpa_required_plugins',		'crework_gdpr_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'crework_exists_gdpr' ) ) {
	function crework_exists_gdpr() {
		return function_exists('__gdpr_load_plugin') || defined('GDPR_VERSION');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'crework_gdpr_tgmpa_required_plugins' ) ) {
	
	function crework_gdpr_tgmpa_required_plugins($list=array()) {
        if (in_array('wp-gdpr-compliance', crework_storage_get('required_plugins'))) {
			$list[] = array(
				'name'     => esc_html__( 'WP GDPR Compliance', 'crework' ),
				'slug'     => 'wp-gdpr-compliance',
				'required' => false
			);
		}
		return $list;
	}
}

