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
$crework_columns = empty($crework_blog_style[1]) ? 1 : max(1, $crework_blog_style[1]);
$crework_expanded = !crework_sidebar_present() && crework_is_on(crework_get_theme_option('expand_content'));
$crework_post_format = get_post_format();
$crework_post_format = empty($crework_post_format) ? 'standard' : str_replace('post-format-', '', $crework_post_format);
$crework_animation = crework_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($crework_columns).' post_format_'.esc_attr($crework_post_format) ); ?>
	<?php echo (!crework_is_off($crework_animation) ? ' data-animation="'.esc_attr(crework_get_animation_classes($crework_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($crework_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.the_title_attribute( array( 'echo' => false ) ).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	crework_show_post_featured( array(
											'class' => $crework_columns == 1 ? 'trx-stretch-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => crework_get_thumb_size(
																	strpos(crework_get_theme_option('body_style'), 'full')!==false
																		? ( $crework_columns > 1 ? 'huge' : 'original' )
																		: (	$crework_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('crework_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('crework_action_before_post_meta'); 

			// Post meta
			$crework_components = crework_is_inherit(crework_get_theme_option_from_meta('meta_parts')) 
										? 'categories,date'.($crework_columns < 3 ? ',counters' : '').($crework_columns == 1 ? ',edit' : '')
										: 'categories,date'.($crework_columns < 3 ? ',counters' : '').($crework_columns == 1 ? ',edit' : '');
			$crework_counters = crework_is_inherit(crework_get_theme_option_from_meta('counters')) 
										? 'comments'
										: 'comments';
			$crework_post_meta = empty($crework_components) 
										? '' 
										: crework_show_post_meta(apply_filters('crework_filter_post_meta_args', array(
												'components' => $crework_components,
												'counters' => $crework_counters,
												'seo' => false,
												'echo' => false
												), $crework_blog_style[0], $crework_columns)
											);
			crework_show_layout($crework_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$crework_show_learn_more = !in_array($crework_post_format, array('link', 'aside', 'status', 'quote'));
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
				crework_show_layout($crework_post_meta);
			}
			// More button
			if ( $crework_show_learn_more ) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'crework'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>