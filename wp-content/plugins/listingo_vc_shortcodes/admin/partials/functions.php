<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/themographics/portfolio
 * @since      1.0.0
 *
 * @package    Listingo
 * @subpackage Listingo/admin
 */

/**
 * @Admin Menu 
 * @return 
 */
if (!function_exists('listingo_theme_options')) {
	add_action('admin_bar_menu', 'listingo_theme_options', 1000);
	function listingo_theme_options(){
		global $wp_admin_bar;
		if(!is_super_admin() || !is_admin_bar_showing()) return;
		
		$url = admin_url();
		if ( function_exists('fw_get_db_post_option') ) {
			// Add Parent Menu
			$argsParent	= array(
				'id' => 'listingo_setup',
				'title' => esc_html__('Listingo Theme Settings','listingo'),
				'href' => $url.'themes.php?page=fw-settings',
			);

			$wp_admin_bar->add_node( $argsParent );	
		}
	}
}