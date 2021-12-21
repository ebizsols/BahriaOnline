<?php
/**
 * Theme Options, Color Schemes and Fonts utilities
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

// -----------------------------------------------------------------
// -- Create and manage Theme Options
// -----------------------------------------------------------------

// Theme init priorities:
// 2 - create Theme Options
if (!function_exists('crework_options_theme_setup2')) {
	add_action( 'after_setup_theme', 'crework_options_theme_setup2', 2 );
	function crework_options_theme_setup2() {
		crework_create_theme_options();
	}
}

// Step 1: Load default settings and previously saved mods
if (!function_exists('crework_options_theme_setup5')) {
	add_action( 'after_setup_theme', 'crework_options_theme_setup5', 5 );
	function crework_options_theme_setup5() {
		crework_storage_set('options_reloaded', false);
		crework_load_theme_options();
	}
}

// Step 2: Load current theme customization mods
if (is_customize_preview()) {
	if (!function_exists('crework_load_custom_options')) {
		add_action( 'wp_loaded', 'crework_load_custom_options' );
		function crework_load_custom_options() {
			if (!crework_storage_get('options_reloaded')) {
				crework_storage_set('options_reloaded', true);
				crework_load_theme_options();
			}
		}
	}
}

// Load current values for each customizable option
if ( !function_exists('crework_load_theme_options') ) {
	function crework_load_theme_options() {
		$options = crework_storage_get('options');
		$reset = (int) get_theme_mod('reset_options', 0);
		foreach ($options as $k=>$v) {
			if (isset($v['std'])) {
				$value = crework_get_theme_option_std($k, $v['std']);
				if (!$reset) {
					if (isset($_GET[$k]))
						$value = crework_get_value_gpc($k);
					else {
						$tmp = get_theme_mod($k, -987654321);
						if ($tmp != -987654321) $value = $tmp;
					}
				}
				crework_storage_set_array2('options', $k, 'val', $value);
				if ($reset) remove_theme_mod($k);
			}
		}
		if ($reset) {
			// Unset reset flag
			set_theme_mod('reset_options', 0);
			// Regenerate CSS with default colors and fonts
			crework_customizer_save_css();
		} else {
			do_action('crework_action_load_options');
		}
	}
}

// Override options with stored page/post meta
if ( !function_exists('crework_override_theme_options') ) {
	add_action( 'wp', 'crework_override_theme_options', 1 );
	function crework_override_theme_options($query=null) {
		if (is_page_template('blog.php')) {
			crework_storage_set('blog_archive', true);
			crework_storage_set('blog_template', get_the_ID());
		}
		crework_storage_set('blog_mode', crework_detect_blog_mode());
		if (is_singular()) {
			crework_storage_set('options_meta', get_post_meta(get_the_ID(), 'crework_options', true));
		}
	}
}


// Return 'std' value of the option, processed by special function (if specified)
if (!function_exists('crework_get_theme_option_std')) {
	function crework_get_theme_option_std($opt_name, $opt_std) {
		if (strpos($opt_std, '$crework_')!==false) {
			$func = substr($opt_std, 1);
			if (function_exists($func)) {
				$opt_std = $func($opt_name);
			}
		}
		return $opt_std;
	}
}


// Return customizable option value
if (!function_exists('crework_get_theme_option')) {
	function crework_get_theme_option($name, $defa='', $strict_mode=false, $post_id=0) {
		$rez = $defa;
		$from_post_meta = false;
		if ($post_id > 0) {
			if (!crework_storage_isset('post_options_meta', $post_id))
				crework_storage_set_array('post_options_meta', $post_id, get_post_meta($post_id, 'crework_options', true));
			if (crework_storage_isset('post_options_meta', $post_id, $name)) {
				$tmp = crework_storage_get_array('post_options_meta', $post_id, $name);
				if (!crework_is_inherit($tmp)) {
					$rez = $tmp;
					$from_post_meta = true;
				}
			}
		}
		if (!$from_post_meta && crework_storage_isset('options')) {
			$blog_mode = crework_storage_get('blog_mode');
			if ( !crework_storage_isset('options', $name) && (empty($blog_mode) || !crework_storage_isset('options', $name.'_'.$blog_mode)) ) {
				$rez = $tmp = '_not_exists_';
				if (function_exists('trx_addons_get_option'))
					$rez = trx_addons_get_option($name, $tmp, false);
				if ($rez === $tmp) {
					if ($strict_mode) {
						$s = debug_backtrace();

						$s = array_shift($s);
						echo '<pre>' . sprintf(esc_html__('Undefined option "%s" called from:', 'crework'), $name);
						if (function_exists('dco')) dco($s);
						else print_r($s);
						echo '</pre>';
						wp_die();
					} else
						$rez = $defa;
				}
			} else {
				// Override option from GET or POST for current blog mode
				if (!empty($blog_mode) && isset($_REQUEST[$name . '_' . $blog_mode])) {
					$rez = crework_get_value_gpc($name . '_' . $blog_mode);
				// Override option from GET
				} else if (isset($_REQUEST[$name])) {
					$rez = crework_get_value_gpc($name);
				// Override option from current page settings (if exists)
				} else if (crework_storage_isset('options_meta', $name) && !crework_is_inherit(crework_storage_get_array('options_meta', $name))) {
					$rez = crework_storage_get_array('options_meta', $name);
				// Override option from current blog mode settings: 'home', 'search', 'page', 'post', 'blog', etc. (if exists)
				} else if (!empty($blog_mode) && crework_storage_isset('options', $name . '_' . $blog_mode, 'val') && !crework_is_inherit(crework_storage_get_array('options', $name . '_' . $blog_mode, 'val'))) {
					$rez = crework_storage_get_array('options', $name . '_' . $blog_mode, 'val');
				// Get saved option value
				} else if (crework_storage_isset('options', $name, 'val')) {
					$rez = crework_storage_get_array('options', $name, 'val');
				// Get ThemeREX Addons option value
				} else if (function_exists('trx_addons_get_option')) {
					$rez = trx_addons_get_option($name, $defa, false);
				}
			}
		}
		return $rez;
	}
}


// Check if customizable option exists
if (!function_exists('crework_check_theme_option')) {
	function crework_check_theme_option($name) {
		return crework_storage_isset('options', $name);
	}
}


// Return customizable option value, stored in the posts meta
if (!function_exists('crework_get_theme_option_from_meta')) {
	function crework_get_theme_option_from_meta($name, $defa='') {
		$rez = $defa;
		if (crework_storage_isset('options_meta')) {
			if (crework_storage_isset('options_meta', $name))
				$rez = crework_storage_get_array('options_meta', $name);
			else
				$rez = 'inherit';
		}
		return $rez;
	}
}


// Get dependencies list from the Theme Options
if ( !function_exists('crework_get_theme_dependencies') ) {
	function crework_get_theme_dependencies() {
		$options = crework_storage_get('options');
		$depends = array();
		foreach ($options as $k=>$v) {
			if (isset($v['dependency'])) 
				$depends[$k] = $v['dependency'];
		}
		return $depends;
	}
}



// -----------------------------------------------------------------
// -- Theme Settings utilities
// -----------------------------------------------------------------

// Return internal theme setting value
if (!function_exists('crework_get_theme_setting')) {
	function crework_get_theme_setting($name) {
		if ( !crework_storage_isset('settings', $name) ) {
			$s = debug_backtrace();

			$s = array_shift($s);
			echo '<pre>' . sprintf(esc_html__('Undefined setting "%s" called from:', 'crework'), $name);
			if (function_exists('dco')) dco($s);
			else print_r($s);
			echo '</pre>';
			wp_die();
		} else
			return crework_storage_get_array('settings', $name);
	}
}

// Set theme setting
if ( !function_exists( 'crework_set_theme_setting' ) ) {
	function crework_set_theme_setting($option_name, $value) {
		if (crework_storage_isset('settings', $option_name))
			crework_storage_set_array('settings', $option_name, $value);
	}
}



// -----------------------------------------------------------------
// -- Color Schemes utilities
// -----------------------------------------------------------------

// Load saved values into color schemes
if (!function_exists('crework_load_schemes')) {
	add_action('crework_action_load_options', 'crework_load_schemes');
	function crework_load_schemes() {
		$schemes = crework_storage_get('schemes');
		$storage = crework_unserialize(crework_get_theme_option('scheme_storage'));
		if (is_array($storage) && count($storage) > 0)  {
			foreach ($storage as $k=>$v) {
				if (isset($schemes[$k])) {
					$schemes[$k] = $v;
				}
			}
			crework_storage_set('schemes', $schemes);
		}
	}
}

// Return specified color from current (or specified) color scheme
if ( !function_exists( 'crework_get_scheme_color' ) ) {
	function crework_get_scheme_color($color_name, $scheme = '') {
		if (empty($scheme)) $scheme = crework_get_theme_option( 'color_scheme' );
		if (empty($scheme) || crework_storage_empty('schemes', $scheme)) $scheme = 'default';
		$colors = crework_storage_get_array('schemes', $scheme, 'colors');
		return $colors[$color_name];
	}
}

// Return colors from current color scheme
if ( !function_exists( 'crework_get_scheme_colors' ) ) {
	function crework_get_scheme_colors($scheme = '') {
		if (empty($scheme)) $scheme = crework_get_theme_option( 'color_scheme' );
		if (empty($scheme) || crework_storage_empty('schemes', $scheme)) $scheme = 'default';
		return crework_storage_get_array('schemes', $scheme, 'colors');
	}
}

// Return colors from all schemes
if ( !function_exists( 'crework_get_scheme_storage' ) ) {
	function crework_get_scheme_storage($scheme = '') {
		return serialize(crework_storage_get('schemes'));
	}
}

// Return schemes list
if ( !function_exists( 'crework_get_list_schemes' ) ) {
	function crework_get_list_schemes($prepend_inherit=false) {
		$list = array();
		$schemes = crework_storage_get('schemes');
		if (is_array($schemes) && count($schemes) > 0) {
			foreach ($schemes as $slug => $scheme) {
				$list[$slug] = $scheme['title'];
			}
		}
		return $prepend_inherit ? crework_array_merge(array('inherit' => esc_html__("Inherit", 'crework')), $list) : $list;
	}
}



// -----------------------------------------------------------------
// -- Theme Fonts utilities
// -----------------------------------------------------------------

// Load saved values into fonts list
if (!function_exists('crework_load_fonts')) {
	add_action('crework_action_load_options', 'crework_load_fonts');
	function crework_load_fonts() {
		// Fonts to load when theme starts
		$fonts = array();
		for ($i=1; $i<=crework_get_theme_setting('max_load_fonts'); $i++) {
			if (($name = crework_get_theme_option("load_fonts-{$i}-name")) != '') {
				$fonts[] = array(
					'name'	 => $name,
					'family' => crework_get_theme_option("load_fonts-{$i}-family"),
					'styles' => crework_get_theme_option("load_fonts-{$i}-styles")
				);
			}
		}
		crework_storage_set('load_fonts', $fonts);
		crework_storage_set('load_fonts_subset', crework_get_theme_option("load_fonts_subset"));
		
		// Font parameters of the main theme's elements
		$fonts = crework_get_theme_fonts();
		foreach ($fonts as $tag=>$v) {
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$fonts[$tag][$css_prop] = crework_get_theme_option("{$tag}_{$css_prop}");
			}
		}
	crework_storage_set('theme_fonts', $fonts);
	}
}

// Return slug of the loaded font
if (!function_exists('crework_get_load_fonts_slug')) {
	function crework_get_load_fonts_slug($name) {
		return str_replace(' ', '-', $name);
	}
}

// Return load fonts parameter's default value
if (!function_exists('crework_get_load_fonts_option')) {
	function crework_get_load_fonts_option($option_name) {
		$rez = '';
		$parts = explode('-', $option_name);
		$load_fonts = (array)crework_storage_get('load_fonts');
		if ($parts[0] == 'load_fonts' && count($load_fonts) > $parts[1]-1 && isset($load_fonts[$parts[1]-1][$parts[2]])) {
			$rez = $load_fonts[$parts[1]-1][$parts[2]];
		}
		return $rez;
	}
}

// Return load fonts subset's default value
if (!function_exists('crework_get_load_fonts_subset')) {
	function crework_get_load_fonts_subset($option_name) {
		return crework_storage_get('load_fonts_subset');
	}
}

// Return load fonts list
if (!function_exists('crework_get_list_load_fonts')) {
	function crework_get_list_load_fonts($prepend_inherit=false) {
		$list = array();
		$load_fonts = crework_storage_get('load_fonts');
		if (is_array($load_fonts) && count($load_fonts) > 0) {
			foreach ($load_fonts as $font) {
				$list['"'.trim($font['name']).'"'.(!empty($font['family']) ? ','.trim($font['family']): '')] = $font['name'];
			}
		}
		return $prepend_inherit ? crework_array_merge(array('inherit' => esc_html__("Inherit", 'crework')), $list) : $list;
	}
}

// Return font settings of the theme specific elements
if ( !function_exists( 'crework_get_theme_fonts' ) ) {
	function crework_get_theme_fonts() {
		return crework_storage_get('theme_fonts');
	}
}

// Return theme fonts parameter's default value
if (!function_exists('crework_get_theme_fonts_option')) {
	function crework_get_theme_fonts_option($option_name) {
		$rez = '';
		$parts = explode('_', $option_name);
		$theme_fonts = crework_storage_get('theme_fonts');
		if (!empty($theme_fonts[$parts[0]][$parts[1]])) {
			$rez = $theme_fonts[$parts[0]][$parts[1]];
		}
		// For the font-families update options list also
		if ($parts[1] == 'font-family') {
			crework_storage_set_array2('options', $option_name, 'options', crework_get_list_load_fonts(true));
		}
		return $rez;
	}
}



// -----------------------------------------------------------------
// -- Other options utilities
// -----------------------------------------------------------------


// Return all vars from Theme Options with option 'customizer'
if ( ! function_exists( 'crework_get_theme_vars' ) ) {
	function crework_get_theme_vars() {
		$options = crework_storage_get( 'options' );
		$vars    = array();
		foreach ( $options as $k => $v ) {
			if ( ! empty( $v['customizer'] ) ) {
				$vars[ $v['customizer'] ] = crework_get_theme_option( $k );
			}
		}
		return $vars;
	}
}

// Return current theme-specific border radius for form's fields and buttons
if ( !function_exists( 'crework_get_border_radius' ) ) {
	function crework_get_border_radius() {
		$rad = str_replace(' ', '', crework_get_theme_option('border_radius'));
		if (empty($rad)) $rad = 0;
		return crework_prepare_css_value($rad); 
	}
}




// -----------------------------------------------------------------
// -- Theme Options page
// -----------------------------------------------------------------

if ( !function_exists('crework_options_init_page_builder') ) {
	add_action( 'after_setup_theme', 'crework_options_init_page_builder' );
	function crework_options_init_page_builder() {
		if ( is_admin() ) {
			add_action('admin_enqueue_scripts',	'crework_options_add_scripts');
		}
	}
}
	
// Load required styles and scripts for admin mode
if ( !function_exists( 'crework_options_add_scripts' ) ) {
	
	function crework_options_add_scripts() {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && $screen->id == 'appearance_page_theme_options') {
			wp_enqueue_style( 'fontello-icons',  crework_get_file_url('css/font-icons/css/fontello-embedded.css') );
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'jquery-ui-accordion', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'crework-options', crework_get_file_url('theme-options/theme.options.js'), array('jquery'), null, true );
			wp_localize_script( 'crework-options', 'crework_dependencies', crework_get_theme_dependencies() );
			wp_localize_script( 'crework-options', 'crework_color_schemes', crework_storage_get('schemes') );
			wp_localize_script( 'crework-options', 'crework_simple_schemes', crework_storage_get('schemes_simple') );
			
			//-------
			wp_localize_script( 'crework-options', 'crework_theme_fonts', crework_storage_get('theme_fonts') );
			wp_localize_script( 'crework-options', 'crework_theme_vars', crework_get_theme_vars() );
			wp_localize_script( 'crework-options', 'crework_options_vars', apply_filters('crework_filter_options_vars', array(
				'max_load_fonts' => crework_get_theme_setting('max_load_fonts'),
			) ) );
            //-------
		}
	}
}

// Add Theme Options item in the Appearance menu
if (!function_exists('crework_options_add_menu_items')) {
	add_action( 'admin_menu', 'crework_options_add_menu_items' );
	function crework_options_add_menu_items() {
		add_theme_page(
			esc_html__('Theme Options', 'crework'),	//page_title
			esc_html__('Theme Options', 'crework'),	//menu_title
			'manage_options',						//capability
			'theme_options',						//menu_slug
			'crework_options_page_builder'			//callback

		);
	}
}


// Build options page
if (!function_exists('crework_options_page_builder')) {
	function crework_options_page_builder() {
		?>
		<div class="crework_options">
			<h2 class="crework_options_title"><?php esc_html_e('Theme Options', 'crework'); ?></h2>
			<?php crework_show_admin_messages(); ?>
			<form id="crework_options_form" action="#" method="post" enctype="multipart/form-data">
				<input type="hidden" name="crework_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
				<?php crework_options_show_fields(); ?>
				<div class="crework_options_buttons">
					<input type="submit" value="<?php  esc_attr_e('Save Options', 'crework'); ?>">
				</div>
			</form>
		</div>
		<?php
	}
}


// Display all option's fields
if ( !function_exists('crework_options_show_fields') ) {
	function crework_options_show_fields($options=false) {
		if (empty($options)) $options = crework_storage_get('options');
		$tabs_titles = $tabs_content = array();
		$last_panel = $last_section = $last_group = '';
		foreach ($options as $k=>$v) {
			// New tab
			if ($v['type']=='panel' || ($v['type']=='section' && empty($last_panel))) {
				if (!isset($tabs_titles[$k])) {
					$tabs_titles[$k] = $v['title'];
					$tabs_content[$k] = '';
				}
				if (!empty($last_group)) {
					$tabs_content[$last_section] .= '</div></div>';
					$last_group = '';
				}
				$last_section = $k;
				if ($v['type']=='panel') $last_panel = $k;

			// New group
			} else if ($v['type']=='group' || ($v['type']=='section' && !empty($last_panel))) {
				if (empty($last_group))
					$tabs_content[$last_section] = (!isset($tabs_content[$last_section]) ? '' : $tabs_content[$last_section]) 
													. '<div class="crework_options_groups">';
				else
					$tabs_content[$last_section] .= '</div>';
				$tabs_content[$last_section] .= '<h4 class="crework_options_group_title">' . esc_html($v['title']) . '</h4>'
												. '<div class="crework_options_group_content">';
				$last_group = $k;
			
			// End panel, section or group
			} else if (in_array($v['type'], array('group_end', 'section_end', 'panel_end'))) {
				if (!empty($last_group) && ($v['type'] != 'section_end' || empty($last_panel))) {
					$tabs_content[$last_section] .= '</div></div>';
					$last_group = '';
				}
				
			// Field's layout
			} else {
				$tabs_content[$last_section] = (!isset($tabs_content[$last_section]) ? '' : $tabs_content[$last_section]) 
												. crework_options_show_field($k, $v);
			}
		}
		if (!empty($last_group)) {
			$tabs_content[$last_section] .= '</div></div>';
		}
		
		if (count($tabs_content) > 0) {
			// Remove empty sections
			foreach ($tabs_content as $k=>$v) {
				if (empty($v)) {
					unset($tabs_titles[$k]);
					unset($tabs_content[$k]);
				}
			}
			?>
			<div id="crework_options_tabs" class="<?php echo count($tabs_titles) > 1 ? 'with_tabs' : 'no_tabs'; ?>">
				<?php if (count($tabs_titles) > 1) { ?>
					<ul><?php
						$cnt = 0;
						foreach ($tabs_titles as $k=>$v) {
							$cnt++;
							?><li><a href="#crework_options_section_<?php echo esc_attr($cnt); ?>"><?php echo esc_html($v); ?></a></li><?php
						}
					?></ul>
				<?php
				}
				$cnt = 0;
				foreach ($tabs_content as $k=>$v) {
					$cnt++;
					?>
					<div id="crework_options_section_<?php echo esc_attr($cnt); ?>" class="crework_options_section">
						<?php crework_show_layout($v); ?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}


// Display single option's field
if ( !function_exists('crework_options_show_field') ) {
	function crework_options_show_field($name, $field, $post_type='') {

		$inherit_allow = !empty($post_type);
		$inherit_state = !empty($post_type) && isset($field['val']) && crework_is_inherit($field['val']);

		if ($field['type'] == 'hidden' || (!empty($field['hidden']) && !$inherit_allow)) return '';
		
		$output = (!empty($field['class']) && strpos($field['class'], 'crework_new_row')!==false 
					? '<div class="crework_new_row_before"></div>'
					: '')
					. '<div class="crework_options_item crework_options_item_'.esc_attr($field['type'])
								. ($inherit_allow ? ' crework_options_inherit_'.($inherit_state ? 'on' : 'off' ) : '')
								. (!empty($field['class']) ? ' '.esc_attr($field['class']) : '')
								. '">'
						. '<h4 class="crework_options_item_title">'
							. esc_html($field['title'])
							. ($inherit_allow 
									? '<span class="crework_options_inherit_lock" id="crework_options_inherit_'.esc_attr($name).'"></span>'
									: '')
						. '</h4>'
						. '<div class="crework_options_item_data">'
							. '<div class="crework_options_item_field" data-param="'.esc_attr($name).'"'
									. (!empty($field['linked']) ? ' data-linked="'.esc_attr($field['linked']).'"' : '')
									. '>';
	
		// Type 'checkbox'
		if ($field['type']=='checkbox') {
			$output .= '<label class="crework_options_item_label">'
						. '<input type="checkbox" name="crework_options_field_'.esc_attr($name).'" value="1"'
								.($field['val']==1 ? ' checked="checked"' : '')
								.' />'
						. esc_html($field['title'])
					. '</label>';
		
		// Type 'switch' (2 choises) or 'radio' (3+ choises)
		} else if (in_array($field['type'], array('switch', 'radio'))) {
			$field['options'] = apply_filters('crework_filter_options_get_list_choises', $field['options'], $name);
			foreach ($field['options'] as $k=>$v) {
				$output .= '<label class="crework_options_item_label">'
							. '<input type="radio" name="crework_options_field_'.esc_attr($name).'"'
									. ' value="'.esc_attr($k).'"'.($field['val']==$k ? ' checked="checked"' : '')
									. ' />'
							. esc_html($v)
						. '</label>';
			}

		// Type 'text' or 'time' or 'date'
		} else if (in_array($field['type'], array('text', 'time', 'date'))) {
			$output .= '<input type="text" name="crework_options_field_'.esc_attr($name).'"'
							. ' value="'.esc_attr(crework_is_inherit($field['val']) ? '' : $field['val']).'"'
							. ' />';
		
		// Type 'textarea'
		} else if ($field['type']=='textarea') {
			$output .= '<textarea name="crework_options_field_'.esc_attr($name).'">'
							. esc_html(crework_is_inherit($field['val']) ? '' : $field['val'])
						. '</textarea>';
			
		// Type 'select'
		} else if ($field['type']=='select') {
			$field['options'] = apply_filters('crework_filter_options_get_list_choises', $field['options'], $name);
			$output .= '<select size="1" name="crework_options_field_'.esc_attr($name).'">';
			foreach ($field['options'] as $k=>$v) {
				$output .= '<option value="'.esc_attr($k).'"'.($field['val']==$k ? ' selected="selected"' : '').'>'.esc_html($v).'</option>';
			}
			$output .= '</select>';

		// Type 'image', 'media', 'video' or 'audio'
		} else if (in_array($field['type'], array('image', 'media', 'video', 'audio'))) {
			$output .= (!empty($field['multiple'])
						? '<input type="hidden" id="crework_options_field_'.esc_attr($name).'"'
							. ' name="crework_options_field_'.esc_attr($name).'"'
							. ' value="'.esc_attr(crework_is_inherit($field['val']) ? '' : $field['val']).'"'
							. ' />'
						: '<input type="text" id="crework_options_field_'.esc_attr($name).'"'
							. ' name="crework_options_field_'.esc_attr($name).'"'
							. ' value="'.esc_attr(crework_is_inherit($field['val']) ? '' : $field['val']).'"'
							. ' />')
					. crework_show_custom_field('crework_options_field_'.esc_attr($name).'_button',
												array(
													'type'			 => 'mediamanager',
													'multiple'		 => !empty($field['multiple']),
													'data_type'		 => $field['type'],
													'linked_field_id'=> 'crework_options_field_'.esc_attr($name)
												),
												crework_is_inherit($field['val']) ? '' : $field['val']);
		
		// Type 'icon'
		} else if ($field['type']=='icon') {
			$output .= '<input type="text" id="crework_options_field_'.esc_attr($name).'"'
							. ' name="crework_options_field_'.esc_attr($name).'"'
							. ' value="'.esc_attr(crework_is_inherit($field['val']) ? '' : $field['val']).'"'
							. ' />'
						. crework_show_custom_field('crework_options_field_'.esc_attr($name).'_button',
													array(
														'type'	 => 'icons',
														'button' => true,
														'icons'	 => true
													),
													$field['val']);
		
		// Type 'checklist'
		} else if ($field['type']=='checklist') {
			$output .= '<input type="hidden" id="crework_options_field_'.esc_attr($name).'"'
							. ' name="crework_options_field_'.esc_attr($name).'"'
							. ' value="'.esc_attr(crework_is_inherit($field['val']) ? '' : $field['val']).'"'
							. ' />'
						. crework_show_custom_field('crework_options_field_'.esc_attr($name).'_list',
													array(
														'type'	 => 'checklist',
														'options' => $field['options'],
														'sortable' => !empty($field['sortable']),
														'dir' => !empty($field['dir']) ? $field['dir'] : 'horizontal'
													),
													$field['val']);
		
		// Type 'scheme_editor'
		} else if ($field['type']=='scheme_editor') {
			$output .= '<input type="hidden" id="crework_options_field_'.esc_attr($name).'"'
							. ' name="crework_options_field_'.esc_attr($name).'"'
							. ' value="'.esc_attr(crework_is_inherit($field['val']) ? '' : $field['val']).'"'
							. ' />'
						. crework_show_custom_field('crework_options_field_'.esc_attr($name).'_scheme',
													array('type' => 'scheme_editor'),
													crework_unserialize($field['val']));
		}
		
		$output .= ($inherit_allow
						? '<div class="crework_options_inherit_cover'.(!$inherit_state ? ' crework_hidden' : '').'">'
							. '<span class="crework_options_inherit_label">' . esc_html__('Inherit', 'crework') . '</span>'
							. '<input type="hidden" name="crework_options_inherit_'.esc_attr($name).'"'
									. ' value="'.esc_attr($inherit_state ? 'inherit' : '').'"'
									. ' />'
							. '</div>'
						: '')
					. '</div>'
					. (!empty($field['override']['desc']) || !empty($field['desc'])
						? '<div class="crework_options_item_description">'
							. (!empty($field['override']['desc']) 	// param 'desc' already processed with wp_kses()!
									? $field['override']['desc'] 
									: $field['desc'])
							. '</div>'
						: '')
				. '</div>'
			. '</div>';
		return $output;
	}
}


// Show theme specific fields
function crework_show_custom_field($id, $field, $value) {
	$output = '';
	switch ($field['type']) {
		
		case 'mediamanager':
			wp_enqueue_media( );
			$title = empty($field['data_type']) || $field['data_type']=='image'
							? esc_html__( 'Choose Image', 'crework')
							: esc_html__( 'Choose Media', 'crework');
			$output .= '<a id="'.esc_attr($id).'"'
							. ' class="button mediamanager crework_media_selector"'
							. '	data-param="' . esc_attr($id) . '"'
							. '	data-choose="'.esc_attr(!empty($field['multiple']) ? esc_html__( 'Choose Images', 'crework') : $title).'"'
							. ' data-update="'.esc_attr(!empty($field['multiple']) ? esc_html__( 'Add to Gallery', 'crework') : $title).'"'
							. '	data-multiple="'.esc_attr(!empty($field['multiple']) ? '1' : '0').'"'
							. '	data-type="'.esc_attr(!empty($field['data_type']) ? $field['data_type'] : 'image').'"'
							. '	data-linked-field="'.esc_attr($field['linked_field_id']).'"'
							. '>'
							. (!empty($field['multiple'])
									? (empty($field['data_type']) || $field['data_type']=='image'
										? esc_html__( 'Add Images', 'crework')
										: esc_html__( 'Add Files', 'crework')
										)
									: esc_html($title)
								)
							. '</a>';
			$output .= '<span class="crework_options_field_preview">';
			$images = explode('|', $value);
			if (is_array($images)) {
				foreach ($images as $img)
					$output .= $img && !crework_is_inherit($img)
							? '<span>'
									. (in_array(crework_get_file_ext($img), array('gif', 'jpg', 'jpeg', 'png'))
											? '<img src="' . esc_url($img) . '" alt="'.esc_attr__('img', 'crework').'"">'
											: '<a href="' . esc_url($img) . '">' . esc_html(basename($img)) . '</a>'
										)
								. '</span>' 
							: '';
			}
			$output .= '</span>';
			break;

		case 'icons':
			$icons_type = !empty($field['style']) 
							? $field['style'] 
							: crework_get_theme_setting('icons_type');
			if (empty($field['return']))
				$field['return'] = 'full';
			$crework_icons = $icons_type=='images'
								? crework_get_list_images()
								: crework_array_from_list(crework_get_list_icons());
			if (is_array($crework_icons)) {
				if (!empty($field['button']))
					$output .= '<span id="'.esc_attr($id).'"'
									. ' class="crework_list_icons_selector'
											. ($icons_type=='icons' && !empty($value) ? ' '.esc_attr($value) : '')
											.'"'
									. ' title="'.esc_attr__('Select icon', 'crework').'"'
									. ' data-style="'.($icons_type=='images' ? 'images' : 'icons').'"'
									. ($icons_type=='images' && !empty($value) 
										? ' style="background-image: url('.esc_url($field['return']=='slug' 
																							? $crework_icons[$value] 
																							: $value).');"' 
											: '')
								. '></span>';
				if (!empty($field['icons'])) {
					$output .= '<div class="crework_list_icons">';
					foreach($crework_icons as $slug=>$icon) {
						$output .= '<span class="'.esc_attr($icons_type=='icons' ? $icon : $slug)
								. (($field['return']=='full' ? $icon : $slug) == $value ? ' crework_list_active' : '')
								. '"'
								. ' title="'.esc_attr($slug).'"'
								. ' data-icon="'.esc_attr($field['return']=='full' ? $icon : $slug).'"'
								. ($icons_type=='images' ? ' style="background-image: url('.esc_url($icon).');"' : '')
								. '></span>';
					}
					$output .= '</div>';
				}
			}
			break;

		case 'checklist':
			if (!empty($field['sortable']))
				wp_enqueue_script('jquery-ui-sortable', false, array('jquery', 'jquery-ui-core'), null, true);
			$output .= '<div class="crework_checklist crework_checklist_'.esc_attr($field['dir'])
						. (!empty($field['sortable']) ? ' crework_sortable' : '') 
						. '">';
			if (!is_array($value)) {
				if (!empty($value) && !crework_is_inherit($value)) parse_str(str_replace('|', '&', $value), $value);
				else $value = array();
			}
			// Sort options by values order
			if (!empty($field['sortable']) && is_array($value)) {
				$field['options'] = crework_array_merge($value, $field['options']);
			}
			foreach ($field['options'] as $k=>$v) {
				$output .= '<label class="crework_checklist_item_label' 
								. (!empty($field['sortable']) ? ' crework_sortable_item' : '') 
								. '">'
							. '<input type="checkbox" value="1" data-name="'.$k.'"'
								.( isset($value[$k]) && (int) $value[$k] == 1 ? ' checked="checked"' : '')
								.' />'
							. (substr($v, 0, 4)=='http' ? '<img src="'.esc_url($v).'">' : esc_html($v))
						. '</label>';
			}
			$output .= '</div>';
			break;
			
		case 'scheme_editor':
			if (!is_array($value)) break;
			$output .= '<div class="crework_scheme_editor">';
			// Select scheme
			$output .= '<select class="crework_scheme_editor_selector">';
			foreach ($value as $scheme=>$v)
				$output .= '<option value="' . esc_attr($scheme) . '">' . esc_html($v['title']) . '</option>';
			$output .= '</select>';
			// Select type
			$output .= '<div class="crework_scheme_editor_type">'
							. '<div class="crework_scheme_editor_row">'
								. '<span class="crework_scheme_editor_row_cell">'
									. esc_html__('Editor type', 'crework')
								. '</span>'
								. '<span class="crework_scheme_editor_row_cell crework_scheme_editor_row_cell_span">'
									.'<label>'
										. '<input name="crework_scheme_editor_type" type="radio" value="simple" checked="checked"> '
										. esc_html__('Simple', 'crework')
									. '</label>'
									. '<label>'
										. '<input name="crework_scheme_editor_type" type="radio" value="advanced"> '
										. esc_html__('Advanced', 'crework')
									. '</label>'
								. '</span>'
							. '</div>'
						. '</div>';
			// Colors
			$groups = crework_storage_get('scheme_color_groups');
			$colors = crework_storage_get('scheme_color_names');
			$output .= '<div class="crework_scheme_editor_colors">';
			foreach ($value as $scheme=>$v) {
				$output .= '<div class="crework_scheme_editor_header">'
								. '<span class="crework_scheme_editor_header_cell"></span>';
				foreach ($groups as $group_name=>$group_data) {
					$output .= '<span class="crework_scheme_editor_header_cell" title="'. esc_attr($group_data['description']).'">' 
								. esc_html($group_data['title'])
								. '</span>';
				}
				$output .= '</div>';
				foreach ($colors as $color_name=>$color_data) {
					$output .= '<div class="crework_scheme_editor_row">'
								. '<span class="crework_scheme_editor_row_cell" title="'. esc_attr($color_data['description']).'">'
								. esc_html($color_data['title'])
								. '</span>';
					foreach ($groups as $group_name=>$group_data) {
						$slug = $group_name == 'main' 
									? $color_name 
									: str_replace('text_', '', "{$group_name}_{$color_name}");
						$output .= '<span class="crework_scheme_editor_row_cell">'
									. (isset($v['colors'][$slug])
										? "<input type=\"text\" name=\"{$slug}\" class=\"iColorPicker\" value=\"".esc_attr($v['colors'][$slug])."\">"
										: ''
										)
									. '</span>';
					}
					$output .= '</div>';
				}
				break;
			}
			$output .= '</div>'
					. '</div>';
			break;
	}
	return apply_filters('crework_filter_show_custom_field', $output, $id, $field, $value);
}



// Save options
if (!function_exists('crework_options_save')) {
	add_action('after_setup_theme', 'crework_options_save', 4);
	function crework_options_save() {

		if (!isset($_REQUEST['page']) || $_REQUEST['page']!='theme_options' || crework_get_value_gp('crework_nonce')=='') return;

		// verify nonce
		if ( !wp_verify_nonce( crework_get_value_gp('crework_nonce'), admin_url() ) ) {
			crework_add_admin_message(esc_html__('Bad security code! Options are not saved!', 'crework'), 'error', true);
			return;
		}

		// Check permissions
		if (!current_user_can('manage_options')) {
			crework_add_admin_message(esc_html__('Manage options is denied for the current user! Options are not saved!', 'crework'), 'error', true);
			return;
		}

		// Save options
		$options = crework_storage_get('options');
		$values = get_theme_mods();
		$external_storages = array();
		foreach ($options as $k=>$v) {
			// Skip non-data options - sections, info, etc.
			if (!isset($v['std'])) continue;
			// Get option value from POST
			$value = isset($_POST['crework_options_field_' . $k])
							? crework_get_value_gpc('crework_options_field_' . $k)
							: ($v['type']=='checkbox' ? 0 : '');
			if ($value != crework_get_theme_option_std($k, $v['std']))
				$values[$k] = $value;
			else if (isset($values[$k]))
				unset($values[$k]);
			// External plugin's options
			if (!empty($v['options_storage'])) {
				if (!isset($external_storages[$v['options_storage']]))
					$external_storages[$v['options_storage']] = array();
				$external_storages[$v['options_storage']][$k] = $value;
			}
		}

		// Update options in the external storages
		foreach ($external_storages as $storage_name => $storage_values) {
			$storage = get_option($storage_name, false);
			if (is_array($storage)) {
				foreach ($storage_values as $k=>$v)
					$storage[$k] = $v;
				update_option($storage_name, $storage);
			}
		}

		// Update Theme Mods (internal Theme Options)
		$stylesheet_slug = get_option('stylesheet');
		update_option("theme_mods_{$stylesheet_slug}", $values);

		// Store new schemes colors
		if (!empty($values['scheme_storage'])) {
			$schemes = crework_unserialize($values['scheme_storage']);
			if (is_array($schemes) && count($schemes) > 0) 
				crework_storage_set('schemes', $schemes);
		}
		
		// Store new fonts parameters
		$fonts = crework_get_theme_fonts();
		foreach ($fonts as $tag=>$v) {
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				if (isset($values["{$tag}_{$css_prop}"])) $fonts[$tag][$css_prop] = $values["{$tag}_{$css_prop}"];
			}
		}
		crework_storage_set('theme_fonts', $fonts);

		// Update ThemeOptions save timestamp
		$stylesheet_time = time();
		update_option("crework_options_timestamp_{$stylesheet_slug}", $stylesheet_time);

		// Sinchronize theme options between child and parent themes
		if (crework_get_theme_setting('duplicate_options') == 'both') {
			$theme_slug = get_option('template');
			if ($theme_slug != $stylesheet_slug) {
				crework_customizer_duplicate_theme_options($stylesheet_slug, $theme_slug, $stylesheet_time);
			}
		}

		// Regenerate CSS with new colors
		crework_customizer_save_css();

		// Return result
		crework_add_admin_message(esc_html__('Options are saved', 'crework'));
	}
}


// Refresh data in the linked field
// according the main field value
if (!function_exists('crework_refresh_linked_data')) {
	function crework_refresh_linked_data($value, $linked_name) {
		if ($linked_name == 'parent_cat') {
			$tax = crework_get_post_type_taxonomy($value);
			$terms = !empty($tax) ? crework_get_list_terms(false, $tax) : array();
			$terms = crework_array_merge(array(0 => esc_html__('- Select category -', 'crework')), $terms);
			crework_storage_set_array2('options', $linked_name, 'options', $terms);
		}
	}
}


// AJAX: Refresh data in the linked fields
if (!function_exists('crework_callback_get_linked_data')) {
	add_action('wp_ajax_crework_get_linked_data', 		'crework_callback_get_linked_data');
	add_action('wp_ajax_nopriv_crework_get_linked_data','crework_callback_get_linked_data');
	function crework_callback_get_linked_data() {
		if ( !wp_verify_nonce( crework_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			wp_die();
		$chg_name = sanitize_text_field($_REQUEST['chg_name']);
		$chg_value = sanitize_text_field($_REQUEST['chg_value']);
		$response = array('error' => '');
		if ($chg_name == 'post_type') {
			$tax = crework_get_post_type_taxonomy($chg_value);
			$terms = !empty($tax) ? crework_get_list_terms(false, $tax) : array();
			$response['list'] = crework_array_merge(array(0 => esc_html__('- Select category -', 'crework')), $terms);
		}
		echo json_encode($response);
		wp_die();
	}
}
?>