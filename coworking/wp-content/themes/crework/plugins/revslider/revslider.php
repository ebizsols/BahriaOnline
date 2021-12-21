<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crework_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'crework_revslider_theme_setup9', 9 );
	function crework_revslider_theme_setup9() {
		if (crework_exists_revslider()) {
			add_action( 'wp_enqueue_scripts', 					'crework_revslider_frontend_scripts', 1100 );
			add_filter( 'crework_filter_merge_styles',			'crework_revslider_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'crework_filter_tgmpa_required_plugins','crework_revslider_tgmpa_required_plugins' );
		}
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'crework_exists_revslider' ) ) {
	function crework_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'crework_revslider_tgmpa_required_plugins' ) ) {
	
	function crework_revslider_tgmpa_required_plugins($list=array()) {
		if (in_array('revslider', crework_storage_get('required_plugins'))) {
			$path = crework_get_file_dir('plugins/revslider/revslider.zip');
			$list[] = array(
					'name' 		=> esc_html__('Revolution Slider', 'crework'),
					'slug' 		=> 'revslider',
                    'version'	=> '6.3.1',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
			);
		}
		return $list;
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'crework_revslider_frontend_scripts' ) ) {
	
	function crework_revslider_frontend_scripts() {
		if (crework_is_on(crework_get_theme_option('debug_mode')) && crework_get_file_dir('plugins/revslider/revslider.css')!='')
			wp_enqueue_style( 'crework-revslider',  crework_get_file_url('plugins/revslider/revslider.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'crework_revslider_merge_styles' ) ) {
	
	function crework_revslider_merge_styles($list) {
		$list[] = 'plugins/revslider/revslider.css';
		return $list;
	}
}
?>