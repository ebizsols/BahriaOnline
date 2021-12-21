<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

$crework_post_format = get_post_format();
$crework_post_format = empty($crework_post_format) ? 'standard' : str_replace('post-format-', '', $crework_post_format);
$crework_animation = crework_get_theme_option('blog_animation');
$crework_meta = !in_array($crework_post_format, array('gallery', 'image'));

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($crework_post_format) ); ?>
	<?php echo (!crework_is_off($crework_animation) ? ' data-animation="'.esc_attr(crework_get_animation_classes($crework_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	crework_show_post_featured(array( 'thumb_size' => crework_get_thumb_size( strpos(crework_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));

	// Title and post meta
	if (get_the_title() != '') {
		if ( !has_post_thumbnail() ) {
			if ( $crework_meta ) {
		?>
		<div class="post_meta_under_featured">
			<?php
			crework_show_post_meta(apply_filters('crework_filter_post_meta_args', array(
				'components' => 'categories',	//categories,tags,date,author,counters,share,edit
				'counters' => '',
				), 'excerpt', 1)
			);							
			?>
		</div>
		<?php
			}
		}
		?>
		<div class="post_header entry-header">
			<?php
			do_action('crework_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

			do_action('crework_action_before_post_meta'); 

			// Post meta
			crework_show_post_meta(apply_filters('crework_filter_post_meta_args', array(
				'components' => 'date,counters,edit',
				'counters' => 'comments',
				'seo' => false
				), 'excerpt', 1)
			);
			?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (crework_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'crework' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'crework' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$crework_show_learn_more = !in_array($crework_post_format, array('link', 'aside', 'status'));

			// Post content area
			?><div class="post_content_inner"><?php
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
			?></div><?php
			// More button
			if ( $crework_show_learn_more ) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'crework'); ?></a></p><?php
			}

		}
	?></div><!-- .entry-content -->
</article>