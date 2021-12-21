<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0.10
 */

// Footer sidebar
$crework_footer_name = crework_get_theme_option('footer_widgets');
$crework_footer_present = !crework_is_off($crework_footer_name) && is_active_sidebar($crework_footer_name);
if ($crework_footer_present) { 
	crework_storage_set('current_sidebar', 'footer');
	$crework_footer_wide = crework_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($crework_footer_name) ) {
		dynamic_sidebar($crework_footer_name);
	}
	$crework_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($crework_out)) {
		$crework_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $crework_out);
		$crework_need_columns = true;	//or check: strpos($crework_out, 'columns_wrap')===false;
		if ($crework_need_columns) {
			$crework_columns = max(0, (int) crework_get_theme_option('footer_columns'));
			if ($crework_columns == 0) $crework_columns = min(4, max(1, substr_count($crework_out, '<aside ')));
			if ($crework_columns > 1)
				$crework_out = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($crework_columns).' widget ', $crework_out);
			else
				$crework_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($crework_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row  sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$crework_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($crework_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'crework_action_before_sidebar' );
				crework_show_layout($crework_out);
				do_action( 'crework_action_after_sidebar' );
				if ($crework_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$crework_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>