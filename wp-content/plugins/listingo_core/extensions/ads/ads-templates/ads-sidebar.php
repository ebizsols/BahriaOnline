<?php 
/**
 *
 * The template used for displaying ad sidebar
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $post;
?>
<aside id="tg-sidebarvtwo" class="tg-sidebarvtwo">
	<?php
		include plugin_dir_path(__DIR__) . 'ads-templates/sidebar-ads-contact.php';
		include plugin_dir_path(__DIR__) . 'ads-templates/sidebar-ads-categories.php';
		include plugin_dir_path(__DIR__) . 'ads-templates/sidebar-ads-userdetails.php';
		include plugin_dir_path(__DIR__) . 'ads-templates/sidebar-ads-form.php';
		include plugin_dir_path(__DIR__) . 'ads-templates/sidebar-ads-social.php';
		include plugin_dir_path(__DIR__) . 'ads-templates/sidebar-ads-related.php';    
    ?>      
    <?php if (is_active_sidebar('ad-detail-sidebar')) {?>      
        <div class="tg-listingiaad">        	
            <?php dynamic_sidebar('ad-detail-sidebar'); ?>        	
        </div> 
    <?php } ?>
</aside>