<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WPBakery Page Builderto make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$crework_content = '';
$crework_blog_archive_mask = '%%CONTENT%%';
$crework_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $crework_blog_archive_mask);
if ( have_posts() ) {
	the_post(); 
	if (($crework_content = apply_filters('the_content', get_the_content())) != '') {
		if (($crework_pos = strpos($crework_content, $crework_blog_archive_mask)) !== false) {
			$crework_content = preg_replace('/(\<p\>\s*)?'.$crework_blog_archive_mask.'(\s*\<\/p\>)/i', $crework_blog_archive_subst, $crework_content);
		} else
			$crework_content .= $crework_blog_archive_subst;
		$crework_content = explode($crework_blog_archive_mask, $crework_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) crework_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$crework_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$crework_args = crework_query_add_posts_and_cats($crework_args, '', crework_get_theme_option('post_type'), crework_get_theme_option('parent_cat'));
$crework_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($crework_page_number > 1) {
	$crework_args['paged'] = $crework_page_number;
	$crework_args['ignore_sticky_posts'] = true;
}
$crework_ppp = crework_get_theme_option('posts_per_page');
if ((int) $crework_ppp != 0)
	$crework_args['posts_per_page'] = (int) $crework_ppp;
// Make a new query
query_posts( $crework_args );
// Set a new query as main WP Query
$GLOBALS['wp_the_query'] = $GLOBALS['wp_query'];

// Set query vars in the new query!
if (is_array($crework_content) && count($crework_content) == 2) {
	set_query_var('blog_archive_start', $crework_content[0]);
	set_query_var('blog_archive_end', $crework_content[1]);
}

get_template_part('index');
?>