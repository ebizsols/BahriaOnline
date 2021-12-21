<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

$crework_args = get_query_var('crework_logo_args');

// Site logo
$crework_logo_image  = crework_get_logo_image(isset($crework_args['type']) ? $crework_args['type'] : '');
$crework_logo_text   = crework_is_on(crework_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$crework_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($crework_logo_image) || !empty($crework_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($crework_logo_image)) {
			$crework_attr = crework_getimagesize($crework_logo_image);
			echo '<img src="'.esc_url($crework_logo_image).'" alt="'.esc_attr__('img', 'crework').'""'.(!empty($crework_attr[3]) ? sprintf(' %s', $crework_attr[3]) : '').'>' ;
		} else {
			crework_show_layout(crework_prepare_macros($crework_logo_text), '<span class="logo_text">', '</span>');
			crework_show_layout(crework_prepare_macros($crework_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>