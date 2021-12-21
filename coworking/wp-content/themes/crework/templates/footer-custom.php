<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0.10
 */

$crework_footer_scheme =  crework_is_inherit(crework_get_theme_option('footer_scheme')) ? crework_get_theme_option('color_scheme') : crework_get_theme_option('footer_scheme');
$crework_footer_id = str_replace('footer-custom-', '', crework_get_theme_option("footer_style"));
$crework_footer_meta = get_post_meta($crework_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($crework_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($crework_footer_id))); 
						if (!empty($crework_footer_meta['margin']) != '') 
							echo ' '.esc_attr(crework_add_inline_css_class('margin-top: '.esc_attr(crework_prepare_css_value($crework_footer_meta['margin'])).';'));
						?> scheme_<?php echo esc_attr($crework_footer_scheme); 
						?>">
	<?php
    // Custom footer's layout
    do_action('crework_action_show_layout', $crework_footer_id);
	?>
</footer><!-- /.footer_wrap -->
