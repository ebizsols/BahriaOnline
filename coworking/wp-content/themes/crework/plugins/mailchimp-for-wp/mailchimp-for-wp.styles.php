<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('crework_mailchimp_get_css')) {
	add_filter('crework_filter_get_css', 'crework_mailchimp_get_css', 10, 4);
	function crework_mailchimp_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

CSS;
		
			
			$rad = crework_get_border_radius();
			$css['fonts'] .= <<<CSS


CSS;
		}

		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

.mc4wp-form input[type="email"] {
	background-color: {$colors['input_bg_color']};
	border-color: {$colors['input_bd_color']};
	color: {$colors['input_text']};
}
.mc4wp-form input[type="email"]:hover,
.mc4wp-form input[type="email"]:focus {
}
.mc4wp-form .mc4wp-alert {
	background-color: {$colors['text_link']};
	border-color: {$colors['text_hover']};
	color: {$colors['inverse_text']};
}
footer .mc4wp-form .mc4wp-alert a,
.mc4wp-form .mc4wp-alert a{
    color: {$colors['text_hover']};
}
.mc4wp-form .mc4wp-alert a:hover{
    color: {$colors['inverse_text']};
}
.mc4wp-form button,
.mc4wp-form input[type="submit"] {
	background-color: {$colors['text_link2']};
	border-color: {$colors['text_link2']};
	color: {$colors['inverse_text']};
}
.mc4wp-form button:hover,
.mc4wp-form input[type="submit"]:hover,
.mc4wp-form input[type="submit"]:focus {
	background-color: {$colors['text_hover2']};
	border-color: {$colors['text_hover2']};
	color: {$colors['inverse_text']};
}
CSS;
		}

		return $css;
	}
}
?>