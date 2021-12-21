<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */

crework_storage_set('blog_archive', true);

// Load scripts for both 'Gallery' and 'Portfolio' layouts!
wp_enqueue_script( 'imagesloaded' );
wp_enqueue_script( 'masonry' );
wp_enqueue_script( 'classie', crework_get_file_url('js/theme.gallery/classie.min.js'), array(), null, true );
wp_enqueue_script( 'crework-gallery-script', crework_get_file_url('js/theme.gallery/theme.gallery.js'), array(), null, true );

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	$crework_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$crework_sticky_out = crework_get_theme_option('sticky_style')=='columns' 
							&& is_array($crework_stickies) && count($crework_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$crework_cat = crework_get_theme_option('parent_cat');
	$crework_post_type = crework_get_theme_option('post_type');
	$crework_taxonomy = crework_get_post_type_taxonomy($crework_post_type);
	$crework_show_filters = crework_get_theme_option('show_filters');
	$crework_tabs = array();
	if (!crework_is_off($crework_show_filters)) {
		$crework_args = array(
			'type'			=> $crework_post_type,
			'child_of'		=> $crework_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $crework_taxonomy,
			'pad_counts'	=> false
		);
		$crework_portfolio_list = get_terms($crework_args);
		if (is_array($crework_portfolio_list) && count($crework_portfolio_list) > 0) {
			$crework_tabs[$crework_cat] = esc_html__('All', 'crework');
			foreach ($crework_portfolio_list as $crework_term) {
				if (isset($crework_term->term_id)) $crework_tabs[$crework_term->term_id] = $crework_term->name;
			}
		}
	}
	if (count($crework_tabs) > 0) {
		$crework_portfolio_filters_ajax = true;
		$crework_portfolio_filters_active = $crework_cat;
		$crework_portfolio_filters_id = 'portfolio_filters';
		if (!is_customize_preview())
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
		?>
		<div class="portfolio_filters crework_tabs crework_tabs_ajax">
			<ul class="portfolio_titles crework_tabs_titles">
				<?php
				foreach ($crework_tabs as $crework_id=>$crework_title) {
					?><li><a href="<?php echo esc_url(crework_get_hash_link(sprintf('#%s_%s_content', $crework_portfolio_filters_id, $crework_id))); ?>" data-tab="<?php echo esc_attr($crework_id); ?>"><?php echo esc_html($crework_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$crework_ppp = crework_get_theme_option('posts_per_page');
			if (crework_is_inherit($crework_ppp)) $crework_ppp = '';
			foreach ($crework_tabs as $crework_id=>$crework_title) {
				$crework_portfolio_need_content = $crework_id==$crework_portfolio_filters_active || !$crework_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $crework_portfolio_filters_id, $crework_id)); ?>"
					class="portfolio_content crework_tabs_content"
					data-blog-template="<?php echo esc_attr(crework_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(crework_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($crework_ppp); ?>"
					data-post-type="<?php echo esc_attr($crework_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($crework_taxonomy); ?>"
					data-cat="<?php echo esc_attr($crework_id); ?>"
					data-parent-cat="<?php echo esc_attr($crework_cat); ?>"
					data-need-content="<?php echo (false===$crework_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($crework_portfolio_need_content) 
						crework_show_portfolio_posts(array(
							'cat' => $crework_id,
							'parent_cat' => $crework_cat,
							'taxonomy' => $crework_taxonomy,
							'post_type' => $crework_post_type,
							'page' => 1,
							'sticky' => $crework_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		crework_show_portfolio_posts(array(
			'cat' => $crework_cat,
			'parent_cat' => $crework_cat,
			'taxonomy' => $crework_taxonomy,
			'post_type' => $crework_post_type,
			'page' => 1,
			'sticky' => $crework_sticky_out
			)
		);
	}

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>