<?php
/**
 * Plugin support: WP GDPR Compliance
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.49
 */

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_wp_gdpr_compliance' ) ) {
    function trx_addons_exists_wp_gdpr_compliance() {
        return class_exists( 'WPGDPRC\WPGDPRC' );
    }
}

// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_wp_gdpr_compliance_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_wp_gdpr_compliance_importer_required_plugins', 10, 2 );
    function trx_addons_wp_gdpr_compliance_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'wp-gdpr-compliance')!==false && !trx_addons_exists_wp_gdpr_compliance() )
            $not_installed .= '<br>' . esc_html__('WP GDPR Compliance', 'trx_addons');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_wp_gdpr_compliance_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_wp_gdpr_compliance_importer_set_options' );
    function trx_addons_wp_gdpr_compliance_importer_set_options($options=array()) {
        if ( trx_addons_exists_wp_gdpr_compliance() && in_array('wp-gdpr-compliance', $options['required_plugins']) ) {
            if (is_array($options)) {
                $options['additional_options'][] = 'wpgdprc_%';
            }
        }
        return $options;
    }
}
