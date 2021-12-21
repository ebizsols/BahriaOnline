<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0.10
 */

// Footer menu
$crework_menu_footer = crework_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($crework_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php crework_show_layout($crework_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>