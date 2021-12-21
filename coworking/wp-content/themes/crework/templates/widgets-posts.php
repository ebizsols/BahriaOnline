<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

$crework_post_id    = get_the_ID();
$crework_post_date  = crework_get_date();
$crework_post_title = get_the_title();
$crework_post_link  = get_permalink();
$crework_post_author_id   = get_the_author_meta('ID');
$crework_post_author_name = get_the_author_meta('display_name');
$crework_post_author_url  = get_author_posts_url($crework_post_author_id, '');

$crework_args = get_query_var('crework_args_widgets_posts');
$crework_show_date = isset($crework_args['show_date']) ? (int) $crework_args['show_date'] : 1;
$crework_show_image = isset($crework_args['show_image']) ? (int) $crework_args['show_image'] : 1;
$crework_show_author = isset($crework_args['show_author']) ? (int) $crework_args['show_author'] : 1;
$crework_show_counters = isset($crework_args['show_counters']) ? (int) $crework_args['show_counters'] : 1;
$crework_show_categories = isset($crework_args['show_categories']) ? (int) $crework_args['show_categories'] : 1;

$crework_output = crework_storage_get('crework_output_widgets_posts');

$crework_post_counters_output = '';
if ( $crework_show_counters ) {
	$crework_post_counters_output = '<span class="post_info_item post_info_counters">'
								. crework_get_post_counters('comments')
							. '</span>';
}


$crework_output .= '<article class="post_item with_thumb">';

if ($crework_show_image) {
	$crework_post_thumb = get_the_post_thumbnail($crework_post_id, crework_get_thumb_size('tiny'), array(
		'alt' => the_title_attribute( array( 'echo' => false ) )
	));
	if ($crework_post_thumb) $crework_output .= '<div class="post_thumb">' . ($crework_post_link ? '<a href="' . esc_url($crework_post_link) . '">' : '') . ($crework_post_thumb) . ($crework_post_link ? '</a>' : '') . '</div>';
}

$crework_output .= '<div class="post_content">'
			. ($crework_show_categories 
					? '<div class="post_categories">'
						. crework_get_post_categories()
						. $crework_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($crework_post_link ? '<a href="' . esc_url($crework_post_link) . '">' : '') . ($crework_post_title) . ($crework_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('crework_filter_get_post_info', 
								'<div class="post_info">'
									. ($crework_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($crework_post_link ? '<a href="' . esc_url($crework_post_link) . '" class="post_info_date">' : '') 
											. esc_html($crework_post_date) 
											. ($crework_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($crework_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'crework') . ' ' 
											. ($crework_post_link ? '<a href="' . esc_url($crework_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($crework_post_author_name) 
											. ($crework_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$crework_show_categories && $crework_post_counters_output
										? $crework_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
crework_storage_set('crework_output_widgets_posts', $crework_output);
?>