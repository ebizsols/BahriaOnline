<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												. ' itemscope'
												); ?>
		itemscope itemtype="//schema.org/<?php echo esc_attr(is_single() ? 'BlogPosting' : 'Article'); ?>">
	<?php
	do_action('crework_action_before_post_data'); 

	// Structured data snippets
	if (crework_is_on(crework_get_theme_option('seo_snippets'))) {
		?>
		<div class="structured_data_snippets">
			<meta itemprop="headline" content="<?php the_title_attribute(); ?>">
			<meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
			<meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('Y-m-d')); ?>">
			<meta itemscope itemprop="mainEntityOfPage" itemType="//schema.org/WebPage" itemid="<?php echo esc_url(get_the_permalink()); ?>" content="<?php the_title_attribute(); ?>"/>
			<div itemprop="publisher" itemscope itemtype="//schema.org/Organization">
				<div itemprop="logo" itemscope itemtype="//schema.org/ImageObject">
					<?php 
					$crework_logo_image = crework_get_retina_multiplier(2) > 1 
										? crework_get_theme_option( 'logo_retina' )
										: crework_get_theme_option( 'logo' );
					if (!empty($crework_logo_image)) {
						$crework_attr = crework_getimagesize($crework_logo_image);
						?>
						<img itemprop="url" src="<?php echo esc_url($crework_logo_image); ?>">
						<meta itemprop="width" content="<?php echo esc_attr($crework_attr[0]); ?>">
						<meta itemprop="height" content="<?php echo esc_attr($crework_attr[1]); ?>">
						<?php
					}
					?>
				</div>
				<meta itemprop="name" content="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
				<meta itemprop="telephone" content="">
				<meta itemprop="address" content="">
			</div>
		</div>
		<?php
	}

	do_action('crework_action_before_post_featured'); 
	
	// Featured image
	if ( !crework_sc_layouts_showed('featured') && strpos(get_the_content(), '[trx_widget_banner]')===false)
		crework_show_post_featured();

	// Title and post meta
	if ( (!crework_sc_layouts_showed('title') || !crework_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('crework_action_before_post_title'); 
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if (!crework_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.(crework_is_on(crework_get_theme_option('seo_snippets')) ? ' itemprop="headline"' : '').'>', '</h3>' );
			}
			// Post meta
			
			?>
		</div><!-- .post_header -->
		<?php
	}

	do_action('crework_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="articleBody">
		<?php
		the_content( );

		do_action('crework_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'crework' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'crework' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );

		// Taxonomies and share
		if ( is_single() && !is_attachment() ) {

			do_action('crework_action_before_post_meta'); 

			?><div class="post_meta post_meta_single"><?php
				
				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">'.esc_html__('Tags:', 'crework').'</span> ', ', ', '</span>' );

				// Share
				crework_show_share_links(array(
						'type' => 'block',
						'caption' => '',
						'before' => '<span class="post_meta_item post_share">',
						'after' => '</span>'
					));
			?></div><?php

			do_action('crework_action_after_post_meta'); 
		}
		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('crework_action_after_post_content'); 

	// Author bio.
	if ( crework_get_theme_option('author_info')==1 && is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {
		do_action('crework_action_before_post_author'); 
		get_template_part( 'templates/author-bio' );
		do_action('crework_action_after_post_author'); 
	}

	do_action('crework_action_after_post_data'); 
	?>
</article>
