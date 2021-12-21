<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

$crework_blog_style = explode('_', crework_get_theme_option('blog_style'));
$crework_columns = empty($crework_blog_style[1]) ? 2 : max(2, $crework_blog_style[1]);
$crework_expanded = !crework_sidebar_present() && crework_is_on(crework_get_theme_option('expand_content'));
$crework_post_format = get_post_format();
$crework_post_format = empty($crework_post_format) ? 'standard' : str_replace('post-format-', '', $crework_post_format);
$crework_animation = crework_get_theme_option('blog_animation');
$crework_components = crework_is_inherit(crework_get_theme_option_from_meta('meta_parts')) 
							? 'categories,date,counters'.($crework_columns < 3 ? ',edit' : '')
							: 'categories,date,counters'.($crework_columns < 3 ? ',edit' : '');
$crework_counters = crework_is_inherit(crework_get_theme_option_from_meta('counters')) 
							? 'comments'
							: 'comments';

?><div class="<?php crework_show_layout($crework_blog_style[0] == 'classic' ? 'column' : 'masonry_item masonry_item'); ?>-1_<?php echo esc_attr($crework_columns); ?>"><article id="post-<?php the_ID(); ?>"
	<?php post_class( 'post_item post_format_'.esc_attr($crework_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($crework_columns)
					. ' post_layout_'.esc_attr($crework_blog_style[0]) 
					. ' post_layout_'.esc_attr($crework_blog_style[0]).'_'.esc_attr($crework_columns)
					); ?>
	<?php echo (!crework_is_off($crework_animation) ? ' data-animation="'.esc_attr(crework_get_animation_classes($crework_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	crework_show_post_featured( array( 'thumb_size' => crework_get_thumb_size($crework_blog_style[0] == 'classic'
													? (strpos(crework_get_theme_option('body_style'), 'full')!==false 
															? ( $crework_columns > 2 ? 'big' : 'huge' )
															: (	$crework_columns > 2
																? ($crework_expanded ? 'med' : 'small')
																: ($crework_expanded ? 'big' : 'med')
																)
														)
													: (strpos(crework_get_theme_option('body_style'), 'full')!==false 
															? ( $crework_columns > 2 ? 'masonry-big' : 'full' )
															: (	$crework_columns <= 2 && $crework_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($crework_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('crework_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('crework_action_before_post_meta'); 

			// Post meta
			if (!empty($crework_components))
				crework_show_post_meta(apply_filters('crework_filter_post_meta_args', array(
					'components' => $crework_components,
					'counters' => $crework_counters,
					'seo' => false
					), $crework_blog_style[0], $crework_columns)
				);

			do_action('crework_action_after_post_meta'); 
			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$crework_show_learn_more = false;
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($crework_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($crework_post_format == 'quote') {
				if (($quote = crework_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					crework_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 1)!='[') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($crework_post_format, array('link', 'aside', 'status', 'quote'))) {
			if (!empty($crework_components))
				crework_show_post_meta(apply_filters('crework_filter_post_meta_args', array(
					'components' => $crework_components,
					'counters' => $crework_counters
					), $crework_blog_style[0], $crework_columns)
				);
		}
		// More button
		if ( $crework_show_learn_more ) {
			?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'crework'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>