<?php if (!defined('FW')) die('Forbidden'); ?>
<?php

//$success_row_start	 	= '<div class="row">';
//$success_row_end	 	 	= '</div>';
$success_row_start = '';
$success_row_end = '';
global $post;
$success_sidebar = 'full';
if (function_exists('listingo_sidebars_get_current_position')) {
    $current_position = listingo_sidebars_get_current_position($post->ID);
    if ( !empty($current_position['sd_layout']) 
		&& ( $current_position['sd_layout'] !== 'full' && $current_position['sd_layout']  !== true ) 
		&& ( $current_position['sd_layout'] == 'left' || $current_position['sd_layout'] == 'right' )
	) {
        $success_row_start = '';
        $success_row_end = '';
    }
}
echo do_shortcode($success_row_start );
echo do_shortcode($content);
echo do_shortcode($success_row_end );

