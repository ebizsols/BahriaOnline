<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0.10
 */


// Socials
if ( crework_is_on(crework_get_theme_option('socials_in_footer')) && ($crework_output = crework_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php crework_show_layout($crework_output); ?>
		</div>
	</div>
	<?php
}
?>