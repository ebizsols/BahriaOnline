<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0.10
 */

// Copyright area
$crework_footer_scheme =  crework_is_inherit(crework_get_theme_option('footer_scheme')) ? crework_get_theme_option('color_scheme') : crework_get_theme_option('footer_scheme');
$crework_copyright_scheme = crework_is_inherit(crework_get_theme_option('copyright_scheme')) ? $crework_footer_scheme : crework_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($crework_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and [[...]] on the <i>...</i> and <b>...</b>
				$crework_copyright = crework_prepare_macros(crework_get_theme_option('copyright'));
				if (!empty($crework_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $crework_copyright, $crework_matches)) {
						$crework_copyright = str_replace($crework_matches[1], date(str_replace(array('{', '}'), '', $crework_matches[1])), $crework_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($crework_copyright));
				}
			?></div>
		</div>
	</div>
</div>
