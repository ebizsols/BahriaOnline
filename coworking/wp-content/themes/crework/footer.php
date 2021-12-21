<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

						// Widgets area inside page content
						crework_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					crework_create_widgets_area('widgets_below_page');

					$crework_body_style = crework_get_theme_option('body_style');
					if ($crework_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$crework_footer_style = crework_get_theme_option("footer_style");
			if (strpos($crework_footer_style, 'footer-custom-')===0) $crework_footer_style = 'footer-custom';
			get_template_part( "templates/{$crework_footer_style}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (crework_is_on(crework_get_theme_option('debug_mode')) && crework_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(crework_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>