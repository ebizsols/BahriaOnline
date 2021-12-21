<?php
/**
 * The style "classic" of the Blogger
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_blogger');

$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$post_link = get_permalink();
$post_title = get_the_title();

?><div <?php post_class( 'sc_blogger_item post_format_'.esc_attr($post_format) ); ?>><?php



	// Featured image
	trx_addons_get_template_part('templates/tpl.featured.php',
									'trx_addons_args_featured',
									apply_filters('trx_addons_filter_args_featured', array(
														'class' => 'sc_blogger_item_featured',
														'hover' => 'zoomin',
														'thumb_size' => trx_addons_get_thumb_size($args['columns'] > 2 ? 'post-modern' : 'big')
														), 'blogger-modern')
								);

	// Post content
	?><div class="sc_blogger_item_content entry-content"><div class="sc_blogger_item_container"><?php
		// Post meta
		trx_addons_sc_show_post_meta('sc_blogger', apply_filters('trx_addons_filter_show_post_meta', array(
			'components' => 'categories'
			), 'sc_blogger_default', 1)
		);

		// Post title
		if ( !in_array($post_format, array('link', 'aside', 'status', 'quote')) ) {
			?><div class="sc_blogger_item_header entry-header"><?php 
				// Post title
				the_title( sprintf( '<h5 class="sc_blogger_item_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
			?></div><!-- .entry-header --><?php
		}		

		// Post content
		if (!isset($args['hide_excerpt']) || $args['hide_excerpt']==0) {
			?><div class="sc_blogger_item_excerpt">
				<div class="sc_blogger_item_excerpt_text">
					<?php
					$show_more = !in_array($post_format, array('link', 'aside', 'status', 'quote'));
					if (has_excerpt()) {
						crework_the_excerpt_max_charlength(68);
					} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
						the_content( '' );
					} else if (!$show_more) {
						crework_the_excerpt_max_charlength(68);
					} else {
						crework_the_excerpt_max_charlength(68);
					}
					?>
				</div></div><!-- .sc_blogger_item_excerpt --><?php
		}
						// Post meta
	?><div class="post_meta_footer"><?php
		// Post meta
		trx_addons_sc_show_post_meta('sc_blogger', apply_filters('trx_addons_filter_show_post_meta', array(
			'components' => 'date,counters',
			'counters' => 'comments'
			), 'sc_blogger_default', 1)
		);
	
	?></div>
	</div></div><!-- .entry-content -->
</div><!-- .sc_blogger_item --><?php
?>