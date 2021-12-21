<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0
 */
?>
<div class="author_info_border"></div>
<div class="author_info scheme_default author vcard" itemprop="author" itemscope itemtype="//schema.org/Person">

	<div class="author_avatar" itemprop="image">
		<?php 
		$crework_mult = crework_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 272*$crework_mult ); 
		?>
	</div><div class="author_description">
		<h5 class="author_title" itemprop="name"><?php echo wp_kses_data(sprintf(__('About %s', 'crework'), '<span class="fn">'.get_the_author().'</span>')); ?></h5>

		<div class="author_bio" itemprop="description">
			<?php echo wp_kses(wpautop(get_the_author_meta( 'description' )), 'crework_kses_content'); ?>
			<a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( esc_html__( 'Read More', 'crework' ), '<span class="author_name">' . esc_html(get_the_author()) . '</span>' ); ?>
			</a>
			<?php do_action('crework_action_user_meta'); ?>
		</div><!-- .author_bio -->

	</div><!-- .author_description -->

</div><!-- .author_info -->
