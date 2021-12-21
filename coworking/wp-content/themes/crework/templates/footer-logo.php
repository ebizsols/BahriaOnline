<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0.10
 */

// Logo
if (crework_is_on(crework_get_theme_option('logo_in_footer'))) {
	$crework_logo_image = '';
	if (crework_get_retina_multiplier(2) > 1)
		$crework_logo_image = crework_get_theme_option( 'logo_footer_retina' );
	if (empty($crework_logo_image)) 
		$crework_logo_image = crework_get_theme_option( 'logo_footer' );
	$crework_logo_text   = get_bloginfo( 'name' );
	if (!empty($crework_logo_image) || !empty($crework_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($crework_logo_image)) {
					$crework_attr = crework_getimagesize($crework_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($crework_logo_image).'" class="logo_footer_image" alt="'.esc_attr__('img', 'crework').'""'.(!empty($crework_attr[3]) ? sprintf(' %s', $crework_attr[3]) : '').'></a>' ;
				} else if (!empty($crework_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($crework_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>