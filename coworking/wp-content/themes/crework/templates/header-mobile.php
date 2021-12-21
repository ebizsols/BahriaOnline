<?php
/**
 * The template to show mobile menu
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr(crework_get_theme_option('menu_mobile_fullscreen') > 0 ? 'fullscreen' : 'narrow'); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close icon-cancel"></a><?php

		// Logo
		set_query_var('crework_logo_args', array('type' => 'inverse'));
		get_template_part( 'templates/header-logo' );
		set_query_var('crework_logo_args', array());

		// Mobile menu
		$crework_menu_mobile = crework_get_nav_menu('menu_mobile');
		if (empty($crework_menu_mobile)) {
			$crework_menu_mobile = apply_filters('crework_filter_get_mobile_menu', '');
			if (empty($crework_menu_mobile)) $crework_menu_mobile = crework_get_nav_menu('menu_main');
			if (empty($crework_menu_mobile)) $crework_menu_mobile = crework_get_nav_menu();
		}
		if (!empty($crework_menu_mobile)) {
			if (!empty($crework_menu_mobile))
				$crework_menu_mobile = str_replace(
					array('menu_main', 'id="menu-', 'sc_layouts_menu_nav', 'sc_layouts_hide_on_mobile', 'hide_on_mobile'),
					array('menu_mobile', 'id="menu_mobile-', '', '', ''),
					$crework_menu_mobile
					);
			if (strpos($crework_menu_mobile, '<nav ')===false)
				$crework_menu_mobile = sprintf('<nav class="menu_mobile_nav_area">%s</nav>', $crework_menu_mobile);
			crework_show_layout(apply_filters('crework_filter_menu_mobile_layout', $crework_menu_mobile));
		}
		
		// Social icons
		crework_show_layout(crework_get_socials_links(), '<div class="socials_mobile">', '</div>');
		?>
	</div>
</div>
