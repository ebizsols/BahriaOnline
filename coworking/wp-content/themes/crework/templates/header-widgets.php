<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

// Header sidebar
$crework_header_name = crework_get_theme_option('header_widgets');
$crework_header_present = !crework_is_off($crework_header_name) && is_active_sidebar($crework_header_name);
if ($crework_header_present) { 
	crework_storage_set('current_sidebar', 'header');
	$crework_header_wide = crework_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($crework_header_name) ) {
		dynamic_sidebar($crework_header_name);
	}
	$crework_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($crework_widgets_output)) {
		$crework_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $crework_widgets_output);
		$crework_need_columns = strpos($crework_widgets_output, 'columns_wrap')===false;
		if ($crework_need_columns) {
			$crework_columns = max(0, (int) crework_get_theme_option('header_columns'));
			if ($crework_columns == 0) $crework_columns = min(6, max(1, substr_count($crework_widgets_output, '<aside ')));
			if ($crework_columns > 1)
				$crework_widgets_output = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($crework_columns).' widget ', $crework_widgets_output);
			else
				$crework_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($crework_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$crework_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($crework_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'crework_action_before_sidebar' );
				crework_show_layout($crework_widgets_output);
				do_action( 'crework_action_after_sidebar' );
				if ($crework_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$crework_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>