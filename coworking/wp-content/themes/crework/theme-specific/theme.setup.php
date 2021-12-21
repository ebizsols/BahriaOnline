<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0.22
 */

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('crework_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'crework_customizer_theme_setup1', 1 );
	function crework_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		crework_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for template and child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes
			
			'custmize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame
		
			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts
		
			'max_excerpt_length'	=> 28,			// Max words number for the excerpt in the blog style 'Excerpt'.
													// For style 'Classic' - get half from this value

			'comment_maxlength'		=> 1000,		// Max length of the message from contact form

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'
			
			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png
			
			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png
			
			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:

													// internal - internal popup with plugin's or theme's icons list (fast)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		crework_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Montserrat',
				'family' => 'sans-serif',
				'styles' => '100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i'		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'	 => 'Merriweather',
				'family' => 'serif',
				'styles' => '300,300i,400,400i,700,700i,900,900i'		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'   => 'Varela',
				'family' => 'sans-serif',
				'styles' => '400'		// Parameter 'style' used only for the Google fonts
				)
		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		crework_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		crework_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'crework'),
				'description'		=> esc_html__('Font settings of the main text of the site', 'crework'),
				'font-family'		=> '"Varela",sans-serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.9em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '2em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'crework'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '2.933em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.065em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.4px',
				'margin-top'		=> '1.2em',
				'margin-bottom'		=> '0.5833em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'crework'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '2.4em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.1em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.35px',
				'margin-top'		=> '1.5em',
				'margin-bottom'		=> '0.64em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'crework'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '1.867em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.3em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.3px',
				'margin-top'		=> '1.8em',
				'margin-bottom'		=> '0.8em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'crework'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '1.4em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.65em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.2px',
				'margin-top'		=> '2.5em',
				'margin-bottom'		=> '0.7em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'crework'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '1.2em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.65em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.2px',
				'margin-top'		=> '3em',
				'margin-bottom'		=> '0.8em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'crework'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '1.067em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.85em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.16px',
				'margin-top'		=> '3.3em',
				'margin-bottom'		=> '0.85em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'crework'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'crework'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'crework'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '11px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.3',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1.15px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'crework'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'crework'),
				'font-family'		=> '"Merriweather",serif',
				'font-size' 		=> '13px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.65px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'crework'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'crework'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '12px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.15px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'crework'),
				'description'		=> esc_html__('Font settings of the main menu items', 'crework'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '12px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1.5px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'crework'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'crework'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '300',
				'font-style'		=> 'normal',
				'line-height'		=> '1.7em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		crework_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'crework'),
							'description'	=> esc_html__('Colors of the main content area', 'crework')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'crework'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'crework')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'crework'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'crework')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'crework'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'crework')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'crework'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'crework')
							),
			)
		);
		crework_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'crework'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'crework')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'crework'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'crework')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'crework'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'crework')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'crework'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'crework')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'crework'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'crework')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'crework'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'crework')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'crework'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'crework')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'crework'),
							'description'	=> esc_html__('Color of the links inside this block', 'crework')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'crework'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'crework')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'crework'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'crework')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'crework'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'crework')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'crework'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'crework')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'crework'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'crework')
							),
			'text_link4'=> array(
							'title'			=> esc_html__('Link 4', 'crework'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'crework')
							),
			'text_hover4'=> array(
							'title'			=> esc_html__('Link 4 hover', 'crework'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'crework')
							),
			'text_link5'=> array(
							'title'			=> esc_html__('Link 5', 'crework'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'crework')
							),
			'text_hover5'=> array(
							'title'			=> esc_html__('Link 5 hover', 'crework'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'crework')
							),
			'text_link6'=> array(
							'title'			=> esc_html__('Link 6', 'crework'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'crework')
							),
			'text_hover6'=> array(
							'title'			=> esc_html__('Link 6 hover', 'crework'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'crework')
							)
			)
		);
		crework_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'crework'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#f7f8fa', //
					'bd_color'			=> '#e1e1e3', //
		
					// Text and links colors
					'text'				=> '#7f7f7f', //
					'text_light'		=> '#7f7f7f', //
					'text_dark'			=> '#222327', //
					'text_link'			=> '#fc5d4a', //
					'text_hover'		=> '#222327', //
					'text_link2'		=> '#556cd5', //
					'text_hover2'		=> '#465ab6', //
					'text_link3'		=> '#1c202a', //
					'text_hover3'		=> '#ea5240',
					'text_link4'		=> '#fc5d4a', //
					'text_hover4'		=> '#ea5240', //
					'text_link5'		=> '#222327', //
					'text_hover5'		=> '#363944', //
					'text_link6'		=> '#ffffff', //
					'text_hover6'		=> '#556cd5', //
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#ebeced', //
					'alter_bg_hover'	=> '#ffffff', //
					'alter_bd_color'	=> '#e9edf0', //
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#7f7f7f', //
					'alter_light'		=> '#7f7f7f', //
					'alter_dark'		=> '#222327', //
					'alter_link'		=> '#222327', //
					'alter_hover'		=> '#fc5d4a', //
					'alter_link2'		=> '#fc5d4a', //
					'alter_hover2'		=> '#222327', //
					'alter_link3'		=> '#556cd5', //
					'alter_hover3'		=> '#222327', //
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#ffffff', //
					'extra_bg_hover'	=> '#222327', //
					'extra_bd_color'	=> '#f5f3f0', //
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#7f7f7f', //
					'extra_light'		=> '#727577', //
					'extra_dark'		=> '#222327', //
					'extra_link'		=> '#fc5d4a', //
					'extra_hover'		=> '#8d8f98', //
					'extra_link2'		=> '#222327', //?
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#7f7f7f', //
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> 'transparent', //
					'input_bg_hover'	=> 'transparent', //
					'input_bd_color'	=> '#dfe0e6', //
					'input_bd_hover'	=> '#222327', //
					'input_text'		=> '#7f7f7f', //
					'input_light'		=> '#adadad', //
					'input_dark'		=> '#1d1d1d',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#ffffff', //
					'inverse_light'		=> '#333333',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'crework'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#1c202a', //
					'bd_color'			=> '#363a45', //
		
					// Text and links colors
					'text'				=> '#8d8f98', //
					'text_light'		=> '#adadad', //
					'text_dark'			=> '#ffffff', //
					'text_link'			=> '#fc5d4a', //
					'text_hover'		=> '#ffffff', //
					'text_link2'		=> '#556cd5', //
					'text_hover2'		=> '#465ab6', //
					'text_link3'		=> '#1c202a', //
					'text_hover3'		=> '#eec432',
					'text_link4'		=> '#fc5d4a', //
					'text_hover4'		=> '#ea5240', //
					'text_link5'		=> '#ffffff', //
					'text_hover5'		=> '#4fc4ba', //
					'text_link6'		=> '#1c202a', //
					'text_hover6'		=> '#556cd5', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#2a2e37', //
					'alter_bg_hover'	=> '#2a2e37', //
					'alter_bd_color'	=> '#313131',
					'alter_bd_hover'	=> '#8d8f98', //
					'alter_text'		=> '#8d8f98', //
					'alter_light'		=> '#adadad', //
					'alter_dark'		=> '#ffffff', //
					'alter_link'		=> '#ffffff', //
					'alter_hover'		=> '#fc5d4a', //
					'alter_link2'		=> '#fc5d4a', //
					'alter_hover2'		=> '#ffffff',
					'alter_link3'		=> '#ffffff', //
					'alter_hover3'		=> '#222327', //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#17191f', //
					'extra_bg_hover'	=> '#ffffff', //
					'extra_bd_color'	=> '#313131',
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#8d8f98', //
					'extra_light'		=> '#5f5f5f',
					'extra_dark'		=> '#8d8f98', //
					'extra_link'		=> '#fc5d4a', //
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#faf8f5', //
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ffffff', //
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#f5f5f5', //
					'input_bg_hover'	=> '#f5f5f5', //
					'input_bd_color'	=> '#3e434f', //
					'input_bd_hover'	=> '#9498a9', //
					'input_text'		=> '#8d8f98', //
					'input_light'		=> '#5f5f5f',
					'input_dark'		=> '#ffffff',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#ffffff', //
					'inverse_light'		=> '#adadad', //
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			)
		
		));
		
		// Simple schemes substitution
		crework_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));
	}
}

			
// Additional (calculated) theme-specific colors
// Attention! Don't forget setup custom colors also in the theme.customizer.color-scheme.js
if (!function_exists('crework_customizer_add_theme_colors')) {
	function crework_customizer_add_theme_colors($colors) {
		if (substr($colors['text'], 0, 1) == '#') {
			$colors['bg_color_0']  = crework_hex2rgba( $colors['bg_color'], 0 );
			$colors['bg_color_02']  = crework_hex2rgba( $colors['bg_color'], 0.2 );
			$colors['bg_color_061']  = crework_hex2rgba( $colors['bg_color'], 0.61 );
			$colors['bg_color_07']  = crework_hex2rgba( $colors['bg_color'], 0.7 );
			$colors['bg_color_08']  = crework_hex2rgba( $colors['bg_color'], 0.8 );
			$colors['bg_color_09']  = crework_hex2rgba( $colors['bg_color'], 0.9 );
			$colors['alter_bg_color_07']  = crework_hex2rgba( $colors['alter_bg_color'], 0.7 );
			$colors['alter_bg_color_04']  = crework_hex2rgba( $colors['alter_bg_color'], 0.4 );
			$colors['alter_bg_color_02']  = crework_hex2rgba( $colors['alter_bg_color'], 0.2 );
			$colors['alter_bd_color_02']  = crework_hex2rgba( $colors['alter_bd_color'], 0.2 );
			$colors['extra_bg_color_07']  = crework_hex2rgba( $colors['extra_bg_color'], 0.7 );
			$colors['text_dark_01']  = crework_hex2rgba( $colors['text_dark'], 0.1 );
			$colors['text_dark_015']  = crework_hex2rgba( $colors['text_dark'], 0.15 );
			$colors['text_dark_031']  = crework_hex2rgba( $colors['text_dark'], 0.31 );
			$colors['text_dark_058']  = crework_hex2rgba( $colors['text_dark'], 0.58 );
			$colors['text_dark_05']  = crework_hex2rgba( $colors['text_dark'], 0.5 );
			$colors['text_dark_07']  = crework_hex2rgba( $colors['text_dark'], 0.7 );
			$colors['text_link_009']  = crework_hex2rgba( $colors['text_link'], 0.09 );
			$colors['text_link_02']  = crework_hex2rgba( $colors['text_link'], 0.2 );
			$colors['text_link_06']  = crework_hex2rgba( $colors['text_link'], 0.6 );
			$colors['text_link_07']  = crework_hex2rgba( $colors['text_link'], 0.7 );
			$colors['text_link2_009']  = crework_hex2rgba( $colors['text_link2'], 0.09 );
			$colors['text_link2_02']  = crework_hex2rgba( $colors['text_link2'], 0.2 );
			$colors['text_link3_009']  = crework_hex2rgba( $colors['text_link3'], 0.09 );
			$colors['text_link3_061']  = crework_hex2rgba( $colors['text_link3'], 0.61 );
			$colors['text_link4_009']  = crework_hex2rgba( $colors['text_link4'], 0.09 );
			$colors['text_link5_009']  = crework_hex2rgba( $colors['text_link5'], 0.09 );
			$colors['text_link6_009']  = crework_hex2rgba( $colors['text_link6'], 0.09 );
			$colors['text_light_05']  = crework_hex2rgba( $colors['text_light'], 0.5 );
			$colors['inverse_text_017']  = crework_hex2rgba( $colors['inverse_text'], 0.17 );
			$colors['inverse_text_07']  = crework_hex2rgba( $colors['inverse_text'], 0.7 );
			$colors['extra_link2_085']  = crework_hex2rgba( $colors['extra_link2'], 0.85 );
			$colors['extra_link3_05']  = crework_hex2rgba( $colors['extra_link3'], 0.5 );
			$colors['text_link_blend'] = crework_hsb2hex(crework_hex2hsb( $colors['text_link'], 2, -5, 5 ));
			$colors['alter_link_blend'] = crework_hsb2hex(crework_hex2hsb( $colors['alter_link'], 2, -5, 5 ));
		} else {
			$colors['bg_color_0'] = '{{ data.bg_color_0 }}';
			$colors['bg_color_02'] = '{{ data.bg_color_02 }}';
			$colors['bg_color_061'] = '{{ data.bg_color_061 }}';
			$colors['bg_color_07'] = '{{ data.bg_color_07 }}';
			$colors['bg_color_08'] = '{{ data.bg_color_08 }}';
			$colors['bg_color_09'] = '{{ data.bg_color_09 }}';
			$colors['alter_bg_color_07'] = '{{ data.alter_bg_color_07 }}';
			$colors['alter_bg_color_04'] = '{{ data.alter_bg_color_04 }}';
			$colors['alter_bg_color_02'] = '{{ data.alter_bg_color_02 }}';
			$colors['alter_bd_color_02'] = '{{ data.alter_bd_color_02 }}';
			$colors['extra_bg_color_07'] = '{{ data.extra_bg_color_07 }}';
			$colors['text_dark_01'] = '{{ data.text_dark_01 }}';
			$colors['text_dark_015'] = '{{ data.text_dark_015 }}';
			$colors['text_dark_031'] = '{{ data.text_dark_031 }}';
			$colors['text_dark_058'] = '{{ data.text_dark_058 }}';
			$colors['text_dark_05'] = '{{ data.text_dark_05 }}';
			$colors['text_dark_07'] = '{{ data.text_dark_07 }}';
			$colors['text_link_009'] = '{{ data.text_link_009 }}';
			$colors['text_link_02'] = '{{ data.text_link_02 }}';
			$colors['text_link_06'] = '{{ data.text_link_06 }}';
			$colors['text_link_07'] = '{{ data.text_link_07 }}';
			$colors['text_link2_009'] = '{{ data.text_link2_009 }}';
			$colors['text_link2_02'] = '{{ data.text_link2_02 }}';
			$colors['text_link3_009'] = '{{ data.text_link3_009 }}';
			$colors['text_link3_061'] = '{{ data.text_link3_061 }}';
			$colors['text_link4_009'] = '{{ data.text_link4_009 }}';
			$colors['text_link5_009'] = '{{ data.text_link5_009 }}';
			$colors['text_link6_009'] = '{{ data.text_link6_009 }}';
			$colors['text_light_05'] = '{{ data.text_light_05 }}';
			$colors['extra_link2_085'] = '{{ data.extra_link2_085 }}';
			$colors['extra_link3_05'] = '{{ data.extra_link3_05 }}';
			$colors['inverse_text_017'] = '{{ data.inverse_text_017 }}';
			$colors['inverse_text_07'] = '{{ data.inverse_text_07 }}';
			$colors['text_link_blend'] = '{{ data.text_link_blend }}';
			$colors['alter_link_blend'] = '{{ data.alter_link_blend }}';
		}
		return $colors;
	}
}


			
// Additional theme-specific fonts rules
// Attention! Don't forget setup fonts rules also in the theme.customizer.color-scheme.js
if (!function_exists('crework_customizer_add_theme_fonts')) {
	function crework_customizer_add_theme_fonts($fonts) {
		$rez = array();	
		foreach ($fonts as $tag => $font) {
			if (substr($font['font-family'], 0, 2) != '{{') {
				$rez[$tag.'_font-family'] 		= !empty($font['font-family']) && !crework_is_inherit($font['font-family'])
														? 'font-family:' . trim($font['font-family']) . ';' 
														: '';
				$rez[$tag.'_font-size'] 		= !empty($font['font-size']) && !crework_is_inherit($font['font-size'])
														? 'font-size:' . crework_prepare_css_value($font['font-size']) . ";"
														: '';
				$rez[$tag.'_line-height'] 		= !empty($font['line-height']) && !crework_is_inherit($font['line-height'])
														? 'line-height:' . trim($font['line-height']) . ";"
														: '';
				$rez[$tag.'_font-weight'] 		= !empty($font['font-weight']) && !crework_is_inherit($font['font-weight'])
														? 'font-weight:' . trim($font['font-weight']) . ";"
														: '';
				$rez[$tag.'_font-style'] 		= !empty($font['font-style']) && !crework_is_inherit($font['font-style'])
														? 'font-style:' . trim($font['font-style']) . ";"
														: '';
				$rez[$tag.'_text-decoration'] 	= !empty($font['text-decoration']) && !crework_is_inherit($font['text-decoration'])
														? 'text-decoration:' . trim($font['text-decoration']) . ";"
														: '';
				$rez[$tag.'_text-transform'] 	= !empty($font['text-transform']) && !crework_is_inherit($font['text-transform'])
														? 'text-transform:' . trim($font['text-transform']) . ";"
														: '';
				$rez[$tag.'_letter-spacing'] 	= !empty($font['letter-spacing']) && !crework_is_inherit($font['letter-spacing'])
														? 'letter-spacing:' . trim($font['letter-spacing']) . ";"
														: '';
				$rez[$tag.'_margin-top'] 		= !empty($font['margin-top']) && !crework_is_inherit($font['margin-top'])
														? 'margin-top:' . crework_prepare_css_value($font['margin-top']) . ";"
														: '';
				$rez[$tag.'_margin-bottom'] 	= !empty($font['margin-bottom']) && !crework_is_inherit($font['margin-bottom'])
														? 'margin-bottom:' . crework_prepare_css_value($font['margin-bottom']) . ";"
														: '';
			} else {
				$rez[$tag.'_font-family']		= '{{ data["'.$tag.'_font-family"] }}';
				$rez[$tag.'_font-size']			= '{{ data["'.$tag.'_font-size"] }}';
				$rez[$tag.'_line-height']		= '{{ data["'.$tag.'_line-height"] }}';
				$rez[$tag.'_font-weight']		= '{{ data["'.$tag.'_font-weight"] }}';
				$rez[$tag.'_font-style']		= '{{ data["'.$tag.'_font-style"] }}';
				$rez[$tag.'_text-decoration']	= '{{ data["'.$tag.'_text-decoration"] }}';
				$rez[$tag.'_text-transform']	= '{{ data["'.$tag.'_text-transform"] }}';
				$rez[$tag.'_letter-spacing']	= '{{ data["'.$tag.'_letter-spacing"] }}';
				$rez[$tag.'_margin-top']		= '{{ data["'.$tag.'_margin-top"] }}';
				$rez[$tag.'_margin-bottom']		= '{{ data["'.$tag.'_margin-bottom"] }}';
			}
		}
		return $rez;
	}
}




//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------

if ( !function_exists('crework_customizer_theme_setup') ) {
	add_action( 'after_setup_theme', 'crework_customizer_theme_setup' );
	function crework_customizer_theme_setup() {

		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size(370, 0, false);
		
		// Add thumb sizes
		// ATTENTION! If you change list below - check filter's names in the 'trx_addons_filter_get_thumb_size' hook
		$thumb_sizes = apply_filters('crework_filter_add_thumb_sizes', array(
			'crework-thumb-huge'		=> array(1170, 658, true),
			'crework-thumb-big' 		=> array( 737, 415, true),
			'crework-thumb-med' 		=> array( 370, 208, true),
			'crework-thumb-tiny' 		=> array( 180, 180, true),
			'crework-thumb-masonry-big' => array( 737,   0, false),		// Only downscale, not crop
			'crework-thumb-masonry'		=> array( 370,   0, false),		// Only downscale, not crop
			)
		);
		$mult = crework_get_theme_option('retina_ready', 1);
		if ($mult > 1) $GLOBALS['content_width'] = apply_filters( 'crework_filter_content_width', 1170*$mult);
		foreach ($thumb_sizes as $k=>$v) {
			// Add Original dimensions
			add_image_size( $k, $v[0], $v[1], $v[2]);
			// Add Retina dimensions
			if ($mult > 1) add_image_size( $k.'-@retina', $v[0]*$mult, $v[1]*$mult, $v[2]);
		}

	}
}

if ( !function_exists('crework_customizer_image_sizes') ) {
	add_filter( 'image_size_names_choose', 'crework_customizer_image_sizes' );
	function crework_customizer_image_sizes( $sizes ) {
		$thumb_sizes = apply_filters('crework_filter_add_thumb_sizes', array(
			'crework-thumb-huge'		=> esc_html__( 'Huge image', 'crework' ),
			'crework-thumb-big'			=> esc_html__( 'Large image', 'crework' ),
			'crework-thumb-med'			=> esc_html__( 'Medium image', 'crework' ),
			'crework-thumb-tiny'		=> esc_html__( 'Small square avatar', 'crework' ),
			'crework-thumb-masonry-big'	=> esc_html__( 'Masonry Large (scaled)', 'crework' ),
			'crework-thumb-masonry'		=> esc_html__( 'Masonry (scaled)', 'crework' ),
			)
		);
		$mult = crework_get_theme_option('retina_ready', 1);
		foreach($thumb_sizes as $k=>$v) {
			$sizes[$k] = $v;
			if ($mult > 1) $sizes[$k.'-@retina'] = $v.' '.esc_html__('@2x', 'crework' );
		}
		return $sizes;
	}
}

// Remove some thumb-sizes from the ThemeREX Addons list
if ( !function_exists( 'crework_customizer_trx_addons_add_thumb_sizes' ) ) {
	add_filter( 'trx_addons_filter_add_thumb_sizes', 'crework_customizer_trx_addons_add_thumb_sizes');
	function crework_customizer_trx_addons_add_thumb_sizes($list=array()) {
		if (is_array($list)) {
			foreach ($list as $k=>$v) {
				if (in_array($k, array(
								'trx_addons-thumb-huge',
								'trx_addons-thumb-big',
								'trx_addons-thumb-medium',
								'trx_addons-thumb-tiny',
								'trx_addons-thumb-masonry-big',
								'trx_addons-thumb-masonry',
								)
							)
						) unset($list[$k]);
			}
		}
		return $list;
	}
}

// and replace removed styles with theme-specific thumb size
if ( !function_exists( 'crework_customizer_trx_addons_get_thumb_size' ) ) {
	add_filter( 'trx_addons_filter_get_thumb_size', 'crework_customizer_trx_addons_get_thumb_size');
	function crework_customizer_trx_addons_get_thumb_size($thumb_size='') {
		return str_replace(array(
							'trx_addons-thumb-huge',
							'trx_addons-thumb-huge-@retina',
							'trx_addons-thumb-big',
							'trx_addons-thumb-big-@retina',
							'trx_addons-thumb-medium',
							'trx_addons-thumb-medium-@retina',
							'trx_addons-thumb-tiny',
							'trx_addons-thumb-tiny-@retina',
							'trx_addons-thumb-masonry-big',
							'trx_addons-thumb-masonry-big-@retina',
							'trx_addons-thumb-masonry',
							'trx_addons-thumb-masonry-@retina',
							),
							array(
							'crework-thumb-huge',
							'crework-thumb-huge-@retina',
							'crework-thumb-big',
							'crework-thumb-big-@retina',
							'crework-thumb-med',
							'crework-thumb-med-@retina',
							'crework-thumb-tiny',
							'crework-thumb-tiny-@retina',
							'crework-thumb-masonry-big',
							'crework-thumb-masonry-big-@retina',
							'crework-thumb-masonry',
							'crework-thumb-masonry-@retina',
							),
							$thumb_size);
	}
}




// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('crework_create_theme_options')) {

	function crework_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = wp_kses_data(__('<b>Attention!</b> Some of these options can be overridden in the following sections (Homepage, Blog archive, Shop, Events, etc.) or in the settings of individual pages', 'crework'));

		crework_storage_set('options', array(
		
			// Section 'Title & Tagline' - add theme options in the standard WP section
			'title_tagline' => array(
				"title" => esc_html__('Title, Tagline & Site icon', 'crework'),
				"desc" => wp_kses_data( __('Specify site title and tagline (if need) and upload the site icon', 'crework') ),
				"type" => "section"
				),
		
		
			// Section 'Header' - add theme options in the standard WP section
			'header_image' => array(
				"title" => esc_html__('Header', 'crework'),
				"desc" => wp_kses_data( __('Select or upload logo images, select header type and widgets set for the header', 'crework') )
							. '<br>'
							. wp_kses_data( $msg_override ),
				"type" => "section"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'crework'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'crework')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'header_style' => array(
				"title" => esc_html__('Header style', 'crework'),
				"desc" => wp_kses_data( __('Select style to display the site header', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crework')
				),
				"std" => 'header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'crework'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crework')
				),
				"std" => 'default',
				"options" => array(),
				"type" => "select"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'crework'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crework'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'crework') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'crework'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crework')
				),
				"dependency" => array(
					'header_style' => array('header-default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => crework_get_list_range(0,6),
				"type" => "select"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'crework'),
				"desc" => wp_kses_data( __('Select color scheme to decorate header area', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crework')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "select"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'crework'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'crework') ),
				"type" => "hidden",
				"std" => 0,
				"type" => "checkbox"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwide', 'crework'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crework')
				),
				"dependency" => array(
					'header_style' => array('header-default')
				),
				"std" => 1,
				"type" => "checkbox"
				),

			'menu_info' => array(
				"title" => esc_html__('Menu settings', 'crework'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'crework') ),
				"type" => "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'crework'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crework')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'crework')
				),
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Menu Color Scheme', 'crework'),
				"desc" => wp_kses_data( __('Select color scheme to decorate main menu area', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crework')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "select"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'crework'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'crework') ),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'crework'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'crework') ),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'crework'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'crework') ),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => "checkbox"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo settings', 'crework'),
				"desc" => wp_kses_data( __('Select logo images for the normal and Retina displays', 'crework') ),
				"type" => "info"
				),
			'logo' => array(
				"title" => esc_html__('Logo', 'crework'),
				"desc" => wp_kses_data( __('Select or upload site logo', 'crework') ),
				"class" => "crework_column-1_2 crework_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'crework'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'crework') ),
				"class" => "crework_column-1_2",
				"std" => '',
				"type" => "image"
				),
			'logo_inverse' => array(
				"title" => esc_html__('Logo inverse', 'crework'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it on the dark background', 'crework') ),
				"class" => "crework_column-1_2 crework_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_inverse_retina' => array(
				"title" => esc_html__('Logo inverse for Retina', 'crework'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'crework') ),
				"class" => "crework_column-1_2",
				"std" => '',
				"type" => "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'crework'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'crework') ),
				"class" => "crework_column-1_2 crework_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'crework'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'crework') ),
				"class" => "crework_column-1_2",
				"std" => '',
				"type" => "image"
				),
			'logo_text' => array(
				"title" => esc_html__('Logo from Site name', 'crework'),
				"desc" => wp_kses_data( __('Do you want use Site name and description as Logo if images above are not selected?', 'crework') ),
				"std" => 1,
				"type" => "checkbox"
				),
			
		
		
			// Section 'Content'
			'content' => array(
				"title" => esc_html__('Content', 'crework'),
				"desc" => wp_kses_data( __('Options of the content area.', 'crework') )
							. '<br>'
							. wp_kses_data( $msg_override ),
				"type" => "section",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'crework'),
				"desc" => wp_kses_data( __('Select color scheme to decorate whole site. Attention! Case "Inherit" can be used only for custom pages, not for root site content in the Appearance - Customize', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'crework')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "select"
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'crework'),
				"desc" => wp_kses_data( __('Select width of the body content', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'crework')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => array(
					'boxed'		=> esc_html__('Boxed',		'crework'),
					'wide'		=> esc_html__('Wide',		'crework'),
					'fullwide'	=> esc_html__('Fullwide',	'crework'),
					'fullscreen'=> esc_html__('Fullscreen',	'crework')
				),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'crework'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'crework') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'crework')
				),
				"std" => '',
				"type" => "image"
				),
			'page_bg_color' => array(
				"title" => esc_html__('BG color', 'crework'),
				"desc" => wp_kses_data( __('Color used as background', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'crework')
				),
				"std" => "",
				"type" => "text"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'crework'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'crework')
				),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'crework'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'crework')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),
			'no_image' => array(
				"title" => esc_html__('No image placeholder', 'crework'),
				"desc" => wp_kses_data( __('Select or upload image, used as placeholder for the posts without featured image', 'crework') ),
				"std" => '',
				"type" => "image"
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'crework'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'crework') ),
				"std" => 0,
				"type" => "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'crework'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'crework') ),
                "std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'crework'), 'crework_kses_content' ),
                "type"  => "text"
            ),
			'author_info' => array(
				"title" => esc_html__('Author info', 'crework'),
				"desc" => wp_kses_data( __("Display block with information about post's author", 'crework') ),
				"std" => 1,
				"type" => "checkbox"
				),
			'related_posts' => array(
				"title" => esc_html__('Related posts', 'crework'),
				"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts showed.', 'crework') ),
				"std" => 0,
				"options" => crework_get_list_range(0,2),
				"type" => "select"
				),
			'related_columns' => array(
				"title" => esc_html__('Related columns', 'crework'),
				"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page?', 'crework') ),
				"std" => 2,
				"options" => crework_get_list_range(2,2),
				"type" => "select"
				),
			'related_style' => array(
				"title" => esc_html__('Related posts style', 'crework'),
				"desc" => wp_kses_data( __('Select style of the related posts output', 'crework') ),
				"std" => 2,
				"options" => crework_get_list_styles(2,2),
				"type" => "select"
				),
			
		
		
			// Section 'Content'
			'sidebar' => array(
				"title" => esc_html__('Sidebars', 'crework'),
				"desc" => wp_kses_data( __('Options of the sidebar and other widgets areas', 'crework') )
							. '<br>'
							. wp_kses_data( $msg_override ),
				"type" => "section",
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'crework'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crework')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'crework'),
				"desc" => wp_kses_data( __('Select color scheme to decorate sidebar', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crework')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "select"
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'crework'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crework')
				),
				"refresh" => false,
				"std" => 'right',
				"options" => array(),
				"type" => "select"
				),
			'hide_sidebar_on_single' => array(
				"title" => esc_html__('Hide sidebar on the single post', 'crework'),
				"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'crework') ),
				"std" => 0,
				"type" => "checkbox"
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crework')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crework')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crework')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crework')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
		
		
		
			// Section 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'crework'),
				"desc" => wp_kses_data( __('Select set of widgets and columns number in the site footer', 'crework') )
							. '<br>'
							. wp_kses_data( $msg_override ),
				"type" => "section"
				),
			'footer_style' => array(
				"title" => esc_html__('Footer style', 'crework'),
				"desc" => wp_kses_data( __('Select style to display the site footer', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'crework')
				),
				"std" => 'footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'crework'),
				"desc" => wp_kses_data( __('Select color scheme to decorate footer area', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'crework')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'crework'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'crework')
				),
				"dependency" => array(
					'footer_style' => array('footer-default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'crework'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'crework')
				),
				"dependency" => array(
					'footer_style' => array('footer-default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => crework_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwide', 'crework'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'crework') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'crework')
				),
				"dependency" => array(
					'footer_style' => array('footer-default')
				),
				"std" => 1,
				"type" => "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'crework'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'crework') ),
				"std" => esc_html__('AxiomThemes &copy; {Y}. All rights reserved.', 'crework'),
				"dependency" => array(
					'footer_style' => array('footer-default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
		
		
		
			// Section 'Homepage' - settings for home page
			'homepage' => array(
				"title" => esc_html__('Homepage', 'crework'),
				"desc" => wp_kses_data( __("Select blog style and widgets to display on the default homepage. Attention! If you use custom page as the homepage - please set up parameters in the 'Theme Options' section of this page.", 'crework') ),
				"type" => "section"
				),
			'expand_content_home' => array(
				"title" => esc_html__('Expand content', 'crework'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden on the Homepage', 'crework') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),
			'blog_style_home' => array(
				"title" => esc_html__('Blog style', 'crework'),
				"desc" => wp_kses_data( __('Select posts style for the homepage', 'crework') ),
				"std" => 'excerpt',
				"options" => array(),
				"type" => "select"
				),
			'first_post_large_home' => array(
				"title" => esc_html__('First post large', 'crework'),
				"desc" => wp_kses_data( __('Make first post large (with Excerpt layout) on the Classic layout of the Homepage', 'crework') ),
				"dependency" => array(
					'blog_style_home' => array('classic')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'header_style_home' => array(
				"title" => esc_html__('Header style', 'crework'),
				"desc" => wp_kses_data( __('Select style to display the site header on the homepage', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'header_position_home' => array(
				"title" => esc_html__('Header position', 'crework'),
				"desc" => wp_kses_data( __('Select position to display the site header on the homepage', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'header_widgets_home' => array(
				"title" => esc_html__('Header widgets', 'crework'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on the homepage', 'crework') ),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'sidebar_widgets_home' => array(
				"title" => esc_html__('Sidebar widgets', 'crework'),
				"desc" => wp_kses_data( __('Select sidebar to show on the homepage', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'sidebar_position_home' => array(
				"title" => esc_html__('Sidebar position', 'crework'),
				"desc" => wp_kses_data( __('Select position to show sidebar on the homepage', 'crework') ),
				"refresh" => false,
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'widgets_above_page_home' => array(
				"title" => esc_html__('Widgets above the page', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'crework') ),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'widgets_above_content_home' => array(
				"title" => esc_html__('Widgets above the content', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'crework') ),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'widgets_below_content_home' => array(
				"title" => esc_html__('Widgets below the content', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'crework') ),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'widgets_below_page_home' => array(
				"title" => esc_html__('Widgets below the page', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'crework') ),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			
		
		
			// Section 'Blog archive'
			'blog' => array(
				"title" => esc_html__('Blog archive', 'crework'),
				"desc" => wp_kses_data( __('Options for the blog archive', 'crework') ),
				"type" => "section",
				),
			'expand_content_blog' => array(
				"title" => esc_html__('Expand content', 'crework'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden on the blog archive', 'crework') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),
			'blog_style' => array(
				"title" => esc_html__('Blog style', 'crework'),
				"desc" => wp_kses_data( __('Select posts style for the blog archive', 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'crework')
				),
				"dependency" => array(
					'#page_template' => array('blog.php'),
                    '.editor-page-attributes__template select' => array( 'blog.php' ),
				),
				"std" => 'excerpt',
				"options" => array(),
				"type" => "select"
				),
			'blog_columns' => array(
				"title" => esc_html__('Blog columns', 'crework'),
				"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'crework') ),
				"std" => 2,
				"options" => crework_get_list_range(2,4),
				"type" => "hidden"
				),
			'post_type' => array(
				"title" => esc_html__('Post type', 'crework'),
				"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'crework')
				),
				"dependency" => array(
					'#page_template' => array('blog.php'),
                    '.editor-page-attributes__template select' => array( 'blog.php' ),
				),
				"linked" => 'parent_cat',
				"refresh" => false,
				"hidden" => true,
				"std" => 'post',
				"options" => array(),
				"type" => "select"
				),
			'parent_cat' => array(
				"title" => esc_html__('Category to show', 'crework'),
				"desc" => wp_kses_data( __('Select category to show in the blog archive', 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'crework')
				),
				"dependency" => array(
					'#page_template' => array('blog.php'),
                    '.editor-page-attributes__template select' => array( 'blog.php' ),
				),
				"refresh" => false,
				"hidden" => true,
				"std" => '0',
				"options" => array(),
				"type" => "select"
				),
			'posts_per_page' => array(
				"title" => esc_html__('Posts per page', 'crework'),
				"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'crework')
				),
				"dependency" => array(
					'#page_template' => array('blog.php'),
                    '.editor-page-attributes__template select' => array( 'blog.php' ),
				),
				"hidden" => true,
				"std" => '',
				"type" => "text"
				),
			'meta_parts' => array(
				"title" => esc_html__('Post meta', 'crework'),
				"desc" => wp_kses_data( __("Select elements to show in the post meta area on default blog archive and search results. You can drag items to change their order. Attention! If your blog archive created by page with parameter 'Page template' equal to 'Blog archive' - please set up parameter 'Post meta' in the 'Theme Options' section of this page.", 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'crework')
				),
				"dependency" => array(
					'#page_template' => array('blob.php')
				),
				"dir" => 'vertical',
				"hidden" => true,
				"sortable" => true,
				"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=1',
				"options" => array(
					'categories' => esc_html__('Categories', 'crework'),
					'date'		 => esc_html__('Post date', 'crework'),
					'author'	 => esc_html__('Post author', 'crework'),
					'counters'	 => esc_html__('Post counters', 'crework'),
					'share'		 => esc_html__('Share links', 'crework'),
					'edit'		 => esc_html__('Edit link', 'crework')
				),
				"type" => "checklist"
			),
			'counters' => array(
				"title" => esc_html__('Counters', 'crework'),
				"desc" => wp_kses_data( __("Select counters to show in the post meta area on default blog archive and search results. If your blog archive created by page with parameter 'Page template' equal to 'Blog archive' - please set up parameter 'Counters' in the 'Theme Options' section of this page. Attention! You can drag items to change their order. Likes and Views available only if ThemeREX Addons is active", 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'crework')
				),
				"dependency" => array(
					'#page_template' => array('blob.php')
				),
				"dir" => 'vertical',
				"hidden" => true,
				"sortable" => true,
				"std" => 'views=1|likes=1|comments=1',
				"options" => array(
					'views' => esc_html__('Views', 'crework'),
					'likes' => esc_html__('Likes', 'crework'),
					'comments' => esc_html__('Comments', 'crework')
				),
				"type" => "checklist"
			),
			"blog_pagination" => array( 
				"title" => esc_html__('Pagination style', 'crework'),
				"desc" => wp_kses_data( __('Show Page numbers below the posts list', 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'crework')
				),
				"std" => "pages",
				"options" => array(
					'pages'	=> esc_html__("Page numbers", 'crework'),
					'infinite' => esc_html__("Infinite scroll", 'crework')
				),
				"type" => "select"
				),
			'show_filters' => array(
				"title" => esc_html__('Show filters', 'crework'),
				"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'crework')
				),
				"dependency" => array(
					'#page_template' => array('blob.php'),
					'blog_style' => array('portfolio', 'gallery')
				),
				"hidden" => true,
				"std" => 0,
				"type" => "checkbox"
				),
			'first_post_large' => array(
				"title" => esc_html__('First post large', 'crework'),
				"desc" => wp_kses_data( __('Make first post large (with Excerpt layout) on the Classic layout of blog archive', 'crework') ),
				"dependency" => array(
					'blog_style' => array('classic')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			"blog_content" => array( 
				"title" => esc_html__('Posts content', 'crework'),
				"desc" => wp_kses_data( __("Show full post's content in the blog or only post's excerpt", 'crework') ),
				"std" => "excerpt",
				"options" => array(
					'excerpt'	=> esc_html__('Excerpt',	'crework'),
					'fullpost'	=> esc_html__('Full post',	'crework')
				),
				"type" => "select"
				),
			'time_diff_before' => array(
				"title" => esc_html__('Time difference', 'crework'),
				"desc" => wp_kses_data( __("How many days show time difference instead post's date", 'crework') ),
				"std" => 5,
				"type" => "text"
				),
			'sticky_style' => array(
				"title" => esc_html__('Sticky posts style', 'crework'),
				"desc" => wp_kses_data( __('Select style of the sticky posts output', 'crework') ),
				"std" => 'inherit',
				"options" => array(
					'inherit' => esc_html__('Decorated posts', 'crework'),
					'columns' => esc_html__('Mini-cards',	'crework')
				),
				"type" => "select"
				),
			"blog_animation" => array( 
				"title" => esc_html__('Animation for the posts', 'crework'),
				"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'crework')
				),
				"dependency" => array(
					'#page_template' => array('blog.php'),
                    '.editor-page-attributes__template select' => array( 'blog.php' ),
				),
				"std" => "none",
				"options" => array(),
				"type" => "select"
				),
			'header_style_blog' => array(
				"title" => esc_html__('Header style', 'crework'),
				"desc" => wp_kses_data( __('Select style to display the site header on the blog archive', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'header_position_blog' => array(
				"title" => esc_html__('Header position', 'crework'),
				"desc" => wp_kses_data( __('Select position to display the site header on the blog archive', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'header_widgets_blog' => array(
				"title" => esc_html__('Header widgets', 'crework'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on the blog archive', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'sidebar_widgets_blog' => array(
				"title" => esc_html__('Sidebar widgets', 'crework'),
				"desc" => wp_kses_data( __('Select sidebar to show on the blog archive', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'sidebar_position_blog' => array(
				"title" => esc_html__('Sidebar position', 'crework'),
				"desc" => wp_kses_data( __('Select position to show sidebar on the blog archive', 'crework') ),
				"refresh" => false,
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'hide_sidebar_on_single_blog' => array(
				"title" => esc_html__('Hide sidebar on the single post', 'crework'),
				"desc" => wp_kses_data( __("Hide sidebar on the single post", 'crework') ),
				"std" => 0,
				"type" => "checkbox"
				),
			'widgets_above_page_blog' => array(
				"title" => esc_html__('Widgets above the page', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'widgets_above_content_blog' => array(
				"title" => esc_html__('Widgets above the content', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'widgets_below_content_blog' => array(
				"title" => esc_html__('Widgets below the content', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			'widgets_below_page_blog' => array(
				"title" => esc_html__('Widgets below the page', 'crework'),
				"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'crework') ),
				"std" => 'inherit',
				"options" => array(),
				"type" => "select"
				),
			
		
		
			// Section 'Colors' - choose color scheme and customize separate colors from it
			'scheme' => array(
				"title" => esc_html__('* Color scheme editor', 'crework'),
				"desc" => esc_html__("Modify colors and preview changes on your site", 'crework'),
				"priority" => 1000,
				"type" => "section"
				),
		
			'scheme_storage' => array(
				"title" => esc_html__('Color schemes', 'crework'),
				"desc" => esc_html__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'crework'),
				"std" => '$crework_get_scheme_storage',
				"refresh" => false,
				"type" => "scheme_editor"
				),


			// Section 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'crework'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'crework') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Title', 'crework')
				),
				"hidden" => true,
				"std" => '',
				"type" => "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'crework'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'crework') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Title', 'crework')
				),
				"hidden" => true,
				"std" => '',
				"type" => "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// Panel 'Fonts' - manage fonts loading and set parameters of the base theme elements
			'fonts' => array(
				"title" => esc_html__('* Fonts settings', 'crework'),
				"desc" => '',
				"priority" => 1500,
				"type" => "panel"
				),

			// Section 'Load_fonts'
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'crework'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'crework') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'crework') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'crework'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'crework') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'crework') ),
				"class" => "crework_column-1_3 crework_new_row",
				"refresh" => false,
				"std" => '$crework_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=crework_get_theme_setting('max_load_fonts'); $i++) {
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'crework'),
				"desc" => '',
				"class" => "crework_column-1_3 crework_new_row",
				"refresh" => false,
				"std" => '$crework_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'crework'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'crework') )
							: '',
				"class" => "crework_column-1_3",
				"refresh" => false,
				"std" => '$crework_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'crework'),
					'serif' => esc_html__('serif', 'crework'),
					'sans-serif' => esc_html__('sans-serif', 'crework'),
					'monospace' => esc_html__('monospace', 'crework'),
					'cursive' => esc_html__('cursive', 'crework'),
					'fantasy' => esc_html__('fantasy', 'crework')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'crework'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'crework') )
											. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'crework') )
							: '',
				"class" => "crework_column-1_3",
				"refresh" => false,
				"std" => '$crework_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Sections with font's attributes for each theme element
		$theme_fonts = crework_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								: esc_html(sprintf(esc_html__('%s settings', 'crework'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								: wp_kses( sprintf(__('Font settings of the "%s" tag.', 'crework'), $tag), 'crework_kses_content' ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'crework'),
						'100' => esc_html__('100 (Light)', 'crework'), 
						'200' => esc_html__('200 (Light)', 'crework'), 
						'300' => esc_html__('300 (Thin)',  'crework'),
						'400' => esc_html__('400 (Normal)', 'crework'),
						'500' => esc_html__('500 (Semibold)', 'crework'),
						'600' => esc_html__('600 (Semibold)', 'crework'),
						'700' => esc_html__('700 (Bold)', 'crework'),
						'800' => esc_html__('800 (Black)', 'crework'),
						'900' => esc_html__('900 (Black)', 'crework')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'crework'),
						'normal' => esc_html__('Normal', 'crework'), 
						'italic' => esc_html__('Italic', 'crework')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'crework'),
						'none' => esc_html__('None', 'crework'), 
						'underline' => esc_html__('Underline', 'crework'),
						'overline' => esc_html__('Overline', 'crework'),
						'line-through' => esc_html__('Line-through', 'crework')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'crework'),
						'none' => esc_html__('None', 'crework'), 
						'uppercase' => esc_html__('Uppercase', 'crework'),
						'lowercase' => esc_html__('Lowercase', 'crework'),
						'capitalize' => esc_html__('Capitalize', 'crework')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "crework_column-1_5",
					"refresh" => false,
					"std" => '$crework_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters into Theme Options
		crework_storage_merge_array('options', '', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			crework_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'crework'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'crework') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'crework')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}
	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('crework_options_get_list_cpt_options')) {
	function crework_options_get_list_cpt_options($cpt) {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Header style', 'crework'),
						"desc" => wp_kses_data( sprintf(__('Select style to display the site header on the %s pages', 'crework'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'crework'),
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'crework'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => "select"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'crework'),
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'crework'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'crework'),
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'crework'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'crework'),
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'crework'), $title) ),
						"refresh" => false,
						"std" => 'left',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'crework'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'crework') ),
						"std" => 0,
						"type" => "checkbox"
						),
					"expand_content_{$cpt}" => array(
						"title" => esc_html__('Expand content', 'crework'),
						"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'crework') ),
						"refresh" => false,
						"std" => 1,
						"type" => "checkbox"
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'crework'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'crework') ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'crework'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'crework') ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'crework'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'crework') ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'crework'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'crework') ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"footer_scheme_{$cpt}" => array(
						"title" => esc_html__('Footer Color Scheme', 'crework'),
						"desc" => wp_kses_data( __('Select color scheme to decorate footer area', 'crework') ),
						"std" => 'dark',
						"options" => array(),
						"type" => "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('crework_options_get_list_choises')) {
	add_filter('crework_filter_options_get_list_choises', 'crework_options_get_list_choises', 10, 2);
	function crework_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = crework_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = crework_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = crework_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (strpos($id, 'header_scheme')===0 
					|| strpos($id, 'menu_scheme')===0
					|| strpos($id, 'color_scheme')===0
					|| strpos($id, 'sidebar_scheme')===0
					|| strpos($id, 'footer_scheme')===0)
				$list = crework_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = crework_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = crework_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = crework_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = crework_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = crework_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = crework_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = crework_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = crework_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = crework_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = crework_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = crework_array_merge(array(0 => esc_html__('- Select category -', 'crework')), crework_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = crework_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = crework_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = crework_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>