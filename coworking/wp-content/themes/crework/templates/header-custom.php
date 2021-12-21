<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0.06
 */

$crework_header_css = $crework_header_image = '';
$crework_header_video = crework_get_header_video();
if (true || empty($crework_header_video)) {
	$crework_header_image = get_header_image();
	if (crework_is_on(crework_get_theme_option('header_image_override')) && apply_filters('crework_filter_allow_override_header_image', true)) {
		if (is_category()) {
			if (($crework_cat_img = crework_get_category_image()) != '')
				$crework_header_image = $crework_cat_img;
		} else if (is_singular() || crework_storage_isset('blog_archive')) {
			if (has_post_thumbnail()) {
				$crework_header_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				if (is_array($crework_header_image)) $crework_header_image = $crework_header_image[0];
			} else
				$crework_header_image = '';
		}
	}
}

$crework_header_id = str_replace('header-custom-', '', crework_get_theme_option("header_style"));
$crework_header_meta = get_post_meta($crework_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($crework_header_id); 
						?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($crework_header_id)));
						echo !empty($crework_header_image) || !empty($crework_header_video) 
							? ' with_bg_image' 
							: ' without_bg_image';
						if ($crework_header_video!='') 
							echo ' with_bg_video';
						if ($crework_header_image!='') 
							echo ' '.esc_attr(crework_add_inline_css_class('background-image: url('.esc_url($crework_header_image).');'));
						if (!empty($crework_header_meta['margin']) != '') 
							echo ' '.esc_attr(crework_add_inline_css_class('margin-bottom: '.esc_attr(crework_prepare_css_value($crework_header_meta['margin'])).';'));
						if (is_single() && has_post_thumbnail()) 
							echo ' with_featured_image';
						if (crework_is_on(crework_get_theme_option('header_fullheight'))) 
							echo ' header_fullheight trx-stretch-height';
						?> scheme_<?php echo esc_attr(crework_is_inherit(crework_get_theme_option('header_scheme')) 
														? crework_get_theme_option('color_scheme') 
														: crework_get_theme_option('header_scheme'));
						?>"><?php

	// Background video
	if (!empty($crework_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('crework_action_show_layout', $crework_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>