<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

// Page (category, tag, archive, author) title

if ( crework_need_page_title() ) {
	crework_sc_layouts_showed('title', true);
	crework_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								crework_show_post_meta(apply_filters('crework_filter_post_meta_args', array(
									'components' => 'categories,date,counters,edit',
									'counters' => 'views,comments,likes',
									'seo' => true
									), 'header', 1)
								);
							?></div><?php
						}
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$crework_blog_title = crework_get_blog_title();
							$crework_blog_title_text = $crework_blog_title_class = $crework_blog_title_link = $crework_blog_title_link_text = '';
							if (is_array($crework_blog_title)) {
								$crework_blog_title_text = $crework_blog_title['text'];
								$crework_blog_title_class = !empty($crework_blog_title['class']) ? ' '.$crework_blog_title['class'] : '';
								$crework_blog_title_link = !empty($crework_blog_title['link']) ? $crework_blog_title['link'] : '';
								$crework_blog_title_link_text = !empty($crework_blog_title['link_text']) ? $crework_blog_title['link_text'] : '';
							} else
								$crework_blog_title_text = $crework_blog_title;
							?>
							<h1 class="sc_layouts_title_caption<?php echo esc_attr($crework_blog_title_class); ?>"><?php
								$crework_top_icon = crework_get_category_icon();
								if (!empty($crework_top_icon)) {
									$crework_attr = crework_getimagesize($crework_top_icon);
									?><img src="<?php echo esc_url($crework_top_icon); ?>" alt="'.esc_attr__('img', 'crework').'"" <?php if (!empty($crework_attr[3])) crework_show_layout($crework_attr[3]);?>><?php
								}
								echo wp_kses($crework_blog_title_text, 'crework_kses_content');
							?></h1>
							<?php
							if (!empty($crework_blog_title_link) && !empty($crework_blog_title_link_text)) {
								?><a href="<?php echo esc_url($crework_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($crework_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'crework_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>