<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Top Categories
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Top_Categories')) {

    class SC_VC_Skin_Listingo_Top_Categories extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_top_categories", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "section_heading" => '',
                "section_subheading" => '',
                "specific_posts" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_top_categories', $args);
            $classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;
            
           
			//setting search URL 
            $search_page = listingo_get_search_page_uri();

            /**
             * @var $atts
             */
            global $paged;
            $posts_in['post__in'] = !empty($specific_posts) ? explode(',', $specific_posts) : array();
            
            //total posts Query 
            $query_args = array(
                'post_type' => 'sp_categories',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1);

            //By Posts 
            if (!empty($posts_in)) {
                $query_args = array_merge($query_args, $posts_in);
            }
            
            $query = new WP_Query($query_args);
            
            ob_start();
            ?>               
            <div class="sp-sc-top-categories tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php if (!empty($section_heading) || !empty($section_subheading)) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
                        <div class="tg-sectionheadvtwo">
                            <div class="tg-sectiontitle">
                                <?php if (!empty($section_subheading)) { ?>
                                    <span><?php echo esc_attr($section_subheading); ?></span>
                                <?php } ?>
                                <?php if (!empty($section_heading)) { ?>
                                    <h2><?php echo esc_attr($section_heading); ?></h2>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="tg-catmainwrap">
					<div class="tg-topcategoriesvthree">
						<?php
						if ($query->have_posts()) {
							$counter = 1;

							while ($query->have_posts()) {
								$query->the_post();
								global $post;
								$category_icon = '';
								$category_color = '#363b4d';
								if (function_exists('fw_get_db_post_option')) {
									$categoy_bg_img = fw_get_db_post_option($post->ID, 'category_image', true);
									$category_icon = fw_get_db_post_option($post->ID, 'category_icon', true);
									$category_color = fw_get_db_post_option($post->ID, 'category_color', true);
								}

								$category_color = !empty($category_color) ? $category_color : '#363b4d';
								//Generate Directory page link
								$directory_link = add_query_arg('category', $post->post_name, $search_page);
								?>
								<div class="tg-category tg-carbg-<?php echo esc_attr($counter); ?> ">
									<a href="<?php echo esc_url(get_permalink()); ?>">
										<div class="tg-categorycontant">
											<?php
											if (isset($category_icon['type']) && $category_icon['type'] === 'icon-font') {
												do_action('enqueue_unyson_icon_css');
												if (!empty($category_icon['icon-class'])) {
													?>
													<i class="<?php echo esc_attr($category_icon['icon-class']); ?>" style="background: <?php echo esc_attr($category_color); ?>;"></i>
													<?php
												}
											} else if (isset($category_icon['type']) && $category_icon['type'] === 'custom-upload') {
												if (!empty($category_icon['url'])) {
													?>
													<em><img src="<?php echo esc_url($category_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>"></em>
													<?php
												}
											}
											?>
											<div class="tg-title">
												<h3><?php echo get_the_title(); ?></h3>
												<span><?php echo esc_html_e('View Listings', 'listingo_vc_shortcodes'); ?></span>
											</div>
										</div>
									</a>
								</div>
								<style scoped>
									.tg-category.tg-carbg-<?php echo esc_attr($counter); ?> a:hover{background: <?php echo esc_attr($category_color); ?>;border-color: <?php echo esc_attr($category_color); ?>}
								</style> 
								<?php
								$counter++;
							} wp_reset_postdata();
							?>
						<?php } ?>
					</div>
           		</div>
            </div>    
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Top_Categories();
}
