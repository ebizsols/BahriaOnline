<?php
/**
 * The template to display the main menu
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */
?>
<div class="top_panel_navi sc_layouts_row sc_layouts_row_type_normal sc_layouts_row_fixed sc_layouts_row_delimiter
			scheme_<?php echo esc_attr(crework_is_inherit(crework_get_theme_option('menu_scheme')) 
												? (crework_is_inherit(crework_get_theme_option('header_scheme')) 
													? crework_get_theme_option('color_scheme') 
													: crework_get_theme_option('header_scheme')) 
												: crework_get_theme_option('menu_scheme')); ?>">
	<div class="content_wrap">
		<div class="columns_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_left sc_layouts_column_icons_position_left column-1_6">
				<?php
				// Logo
				?><div class="sc_layouts_item"><?php
					get_template_part( 'templates/header-logo' );
				?></div>
			</div><?php
			
			// Attention! Don't place any spaces between columns!
			?><div class="sc_layouts_column sc_layouts_column_align_center sc_layouts_column_icons_position_left column-2_3">
				<div class="sc_layouts_item">
					<?php
					// Main menu
					$crework_menu_main = crework_get_nav_menu(array(
						'location' => 'menu_main', 
						'class' => 'sc_layouts_menu sc_layouts_menu_default sc_layouts_hide_on_mobile'
						)
					);
					if (empty($crework_menu_main)) {
						$crework_menu_main = crework_get_nav_menu(array(
							'class' => 'sc_layouts_menu sc_layouts_menu_default sc_layouts_hide_on_mobile'
							)
						);
					}
					crework_show_layout($crework_menu_main);
					// Mobile menu button
					?>
					<div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
						<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
							<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
						</a>
					</div>
				</div>
			
			</div><div class="sc_layouts_column sc_layouts_column_align_right sc_layouts_column_icons_position_left column-1_6">
				<?php
				// Attention! Don't place any spaces between layouts items!
				if (crework_exists_trx_addons()) {
					?><div class="sc_layouts_item">
						<aside class="widget widget_socials">
							<div class="socials_wrap sc_align_left"><?php
								// Social icons
								crework_show_layout(crework_get_socials_links());
								?>
							</div>
						</aside>
					</div><div class="sc_layouts_item"><?php
					// Display search field
					do_action('crework_action_search', 'fullscreen', 'header_search', false);
					?></div><?php
				}
				?>
			</div>
		</div><!-- /.sc_layouts_row -->
	</div><!-- /.content_wrap -->
</div><!-- /.top_panel_navi -->