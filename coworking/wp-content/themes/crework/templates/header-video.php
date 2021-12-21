<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage CREWORK
 * @since CREWORK 1.0.14
 */
$crework_header_video = crework_get_header_video();
$crework_embed_video = '';
if (!empty($crework_header_video) && !crework_is_from_uploads($crework_header_video)) {
	if (crework_is_youtube_url($crework_header_video) && preg_match('/[=\/]([^=\/]*)$/', $crework_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$crework_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($crework_header_video) . '[/embed]' ));
			$crework_embed_video = crework_make_video_autoplay($crework_embed_video);
		} else {
			$crework_header_video = str_replace('/watch?v=', '/embed/', $crework_header_video);
			$crework_header_video = crework_add_to_url($crework_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url('/'),
				'widgetid' => 1
			));
			$crework_embed_video = '<iframe src="' . esc_url($crework_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php crework_show_layout($crework_embed_video); ?></div><?php
	}
}
?>