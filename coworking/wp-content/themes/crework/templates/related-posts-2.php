<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

$crework_link = get_permalink();
$crework_post_format = get_post_format();
$crework_post_format = empty($crework_post_format) ? 'standard' : str_replace('post-format-', '', $crework_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_2 post_format_'.esc_attr($crework_post_format) ); ?>><?php
	crework_show_post_featured(array(
		'thumb_size' => crework_get_thumb_size( (int) crework_get_theme_option('related_posts') == 1 ? 'huge' : 'big' ),
		'show_no_image' => false,
		'singular' => false
		)
	);
	?><div class="related_item_container"><div class="post_header entry-header">
			<?php
			// Post meta
			crework_show_post_meta(apply_filters('crework_filter_post_meta_args', array(
				'components' => 'categories',
				'seo' => false
				), 'excerpt', 1)
			);
			?>	
		<h6 class="post_title entry-title"><a href="<?php echo esc_url($crework_link); ?>"><?php echo the_title(); ?></a></h6>
		<div class="post_contant"><?php crework_the_excerpt_max_charlength(75); ?></div>
	</div>
	<div class="post_footer">
		<?php
		// Post meta
		crework_show_post_meta(apply_filters('crework_filter_post_meta_args', array(
			'components' => 'date,counters',
			'counters' => 'comments',
			'seo' => false
			), 'excerpt', 1)
		);
		?>		
	</div></div>
</div>