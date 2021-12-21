<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

$crework_blog_style = explode('_', crework_get_theme_option('blog_style'));
$crework_columns = empty($crework_blog_style[1]) ? 2 : max(2, $crework_blog_style[1]);
$crework_post_format = get_post_format();
$crework_post_format = empty($crework_post_format) ? 'standard' : str_replace('post-format-', '', $crework_post_format);
$crework_animation = crework_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($crework_columns).' post_format_'.esc_attr($crework_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!crework_is_off($crework_animation) ? ' data-animation="'.esc_attr(crework_get_animation_classes($crework_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$crework_image_hover = crework_get_theme_option('image_hover');
	// Featured image
	crework_show_post_featured(array(
		'thumb_size' => crework_get_thumb_size(strpos(crework_get_theme_option('body_style'), 'full')!==false || $crework_columns < 3 ? 'masonry-big' : 'masonry'),
		'show_no_image' => true,
		'class' => $crework_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $crework_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>