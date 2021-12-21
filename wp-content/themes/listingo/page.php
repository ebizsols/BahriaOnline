<?php
/**
 *
 * Theme Page template
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
get_header();
global $post;
$sidebar_type  = 'full';
$sd_sidebar	   = '';
$section_width = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
if (function_exists('listingo_sidebars_get_current_position')) {
    $current_position = listingo_sidebars_get_current_position($post->ID);
    if ( !empty($current_position['sd_layout']) && $current_position['sd_layout'] !== 'default' ) {
        $sidebar_type  		= !empty($current_position['sd_layout']) ? $current_position['sd_layout'] : 'full';
		$sd_sidebar	   		= !empty($current_position['sd_sidebar']) ? $current_position['sd_sidebar'] : '';
        $section_width 		= 'col-lg-9 col-md-8 col-sm-8 col-xs-12';
    }else{
		if (function_exists('fw_get_db_settings_option')) {
			$sd_layout_pages    = fw_get_db_settings_option('sd_layout_pages');
			$sd_sidebar_pages   = fw_get_db_settings_option('sd_sidebar_pages');
			$sidebar_type  		= !empty($sd_layout_pages) ? $sd_layout_pages : 'full';
			$sd_sidebar	   		= !empty($sd_sidebar_pages) ? $sd_sidebar_pages : '';
			$section_width 		= 'col-lg-9 col-md-8 col-sm-8 col-xs-12';
		}
	}
}
$height = 466;
$width  = 1170;

if (isset($sidebar_type) && ( $sidebar_type == 'full' )) {
    while (have_posts()) : the_post();
  		global $post;
        ?>
        <div class="container">
            <div class="row">
                <?php
                do_action('listingo_prepare_section_wrapper_before');
                $thumbnail = listingo_prepare_thumbnail($post->ID , $width , $height);
  				if( $thumbnail ){
                    ?>
                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo sanitize_title(get_the_title()); ?>" >
                <?php
                }
                
				the_content();
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'listingo' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                do_action('listingo_prepare_section_wrapper_after');
                ?>
            </div>
        </div>
        <?php
    endwhile;
} else {
    if (isset($sidebar_type) && $sidebar_type == 'right') {
        $aside_class   = 'pull-right';
        $content_class = 'pull-left';
    } else {
        $aside_class   = 'pull-left';
        $content_class = 'pull-right';
    }
    ?> 
    <div class="container">
        <div class="row">
            <?php do_action('listingo_prepare_section_wrapper_before'); ?>
            <div class="<?php echo esc_attr($section_width); ?> <?php echo sanitize_html_class($content_class); ?>  page-section">
                <div class="row">
                    <?php
                    while (have_posts()) : the_post();
                        global $post;
                        $thumbnail = listingo_prepare_thumbnail($post->ID , $width , $height);
                        if( $thumbnail ){ ?>
                        	<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo sanitize_title(get_the_title()); ?>" >
                        <?php
                        }
	
                        the_content();
						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'listingo' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
	
                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                    endwhile;
                    ?>
                </div>
            </div>
            <?php
			if (function_exists('listingo_sidebars_get_current_position')) {
				if (isset($sidebar_type) && $sidebar_type !== 'full' && !empty($sd_sidebar)) {?>
				<aside class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sidebar-section <?php echo sanitize_html_class($aside_class); ?>" id="tg-sidebar">
					<div class="tg-sidebar page-dynamic-sidebar">
						<?php dynamic_sidebar( $sd_sidebar );?>
					</div>
				</aside>
            <?php }}?>
            <?php do_action('listingo_prepare_section_wrapper_after'); ?>
        </div>
    </div>
<?php } ?>
<?php get_footer();