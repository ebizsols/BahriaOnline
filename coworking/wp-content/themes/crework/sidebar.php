<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

if (crework_sidebar_present()) {
	ob_start();
	$crework_sidebar_name = crework_get_theme_option('sidebar_widgets');
	crework_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($crework_sidebar_name) ) {
		dynamic_sidebar($crework_sidebar_name);
	}
	$crework_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($crework_out)) {
		$crework_sidebar_position = crework_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($crework_sidebar_position); ?> widget_area<?php if (!crework_is_inherit(crework_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(crework_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'crework_action_before_sidebar' );
				crework_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $crework_out));
				do_action( 'crework_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>