<?php

if (!defined('FW')) {
    die('Forbidden');
}
$options = array(
    'sidebars' => array(
        'title' => esc_html__('Sidebar Settings', 'listingo'),
        'type' => 'tab',
        'options' => array(
            'pages-box' => array(
                'title' => esc_html__('Pages', 'listingo'),
                'type' => 'tab',
                'options' => array(
					'default-sidebars' => array(
						'type' => 'html',
						'html' => 'Default sidebars',
						'label' => esc_html__('', 'listingo'),
						'desc' => esc_html__('You can set global sidebar for all the pages from here. You can edit any page and set custom sidebar from the page settings', 'listingo'),
						'images_only' => true,
					),
                    'sd_layout_pages' => array(
						'label'   => esc_html__( 'Layout', 'listingo' ),
						'desc'    => esc_html__( 'Select sidebar position for pages.', 'listingo' ),
						'type'    => 'select',
						'value'   => 'full',
						'choices' => array(
							'left' 		=> esc_html__('Left sidebar', 'listingo'),	
							'right' 	=> esc_html__('Right sidebar', 'listingo'),	
							'full' 		=> esc_html__('Full width', 'listingo'),
						)
					),
					'sd_sidebar_pages' => array(
						'label'   => esc_html__( 'Sidebar', 'listingo' ),
						'desc'    => esc_html__( 'Select sidebar to display on the page detail.', 'listingo' ),
						'type'    => 'select',
						'value'   => 'full',
						'choices' => listingoGetRegisterSidebars()
					)
                )
            ),
			'posts-box' => array(
                'title' => esc_html__('Posts', 'listingo'),
                'type' => 'tab',
                'options' => array(
					'default-sidebarsp' => array(
						'type' => 'html',
						'html' => 'Default sidebars',
						'label' => esc_html__('', 'listingo'),
						'desc' => esc_html__('You can set global sidebar for all the post types from here. You can edit any post type and set custom sidebar from the post settings', 'listingo'),
						'images_only' => true,
					),
                    'sd_layout_posts' => array(
						'label'   => esc_html__( 'Layout', 'listingo' ),
						'desc'    => esc_html__( 'Select sidebar position for posts.', 'listingo' ),
						'type'    => 'select',
						'value'   => 'full',
						'choices' => array(
							'left' 		=> esc_html__('Left sidebar', 'listingo'),	
							'right' 	=> esc_html__('Right sidebar', 'listingo'),	
							'full' 		=> esc_html__('Full width', 'listingo'),
						)
					),
					'sd_sidebar_posts' => array(
						'label'   => esc_html__( 'Sidebar', 'listingo' ),
						'desc'    => esc_html__( 'Select sidebar to display on post detail page.', 'listingo' ),
						'type'    => 'select',
						'value'   => 'full',
						'choices' => listingoGetRegisterSidebars()
					)
                )
            ),
	
			'articles-box' => array(
                'title' => esc_html__('Articles', 'listingo'),
                'type' => 'tab',
                'options' => array(
					'default-sidebararticles' => array(
						'type' => 'html',
						'html' => 'Default sidebars',
						'label' => esc_html__('', 'listingo'),
						'desc' => esc_html__('You can set global sidebar for articles from here.', 'listingo'),
						'images_only' => true,
					),
                    'sd_layout_articles' => array(
						'label'   => esc_html__( 'Layout', 'listingo' ),
						'desc'    => esc_html__( 'Select sidebar position for articles.', 'listingo' ),
						'type'    => 'select',
						'value'   => 'full',
						'choices' => array(
							'left' 		=> esc_html__('Left sidebar', 'listingo'),	
							'right' 	=> esc_html__('Right sidebar', 'listingo'),	
							'full' 		=> esc_html__('Full width', 'listingo'),
						)
					),
					'sd_sidebar_articles' => array(
						'label'   => esc_html__( 'Sidebar', 'listingo' ),
						'desc'    => esc_html__( 'Select sidebar to display on articles detail page.', 'listingo' ),
						'type'    => 'select',
						'value'   => 'full',
						'choices' => listingoGetRegisterSidebars()
					)
                )
            ),
			'questions-box' => array(
                'title' => esc_html__('Questions', 'listingo'),
                'type' => 'tab',
                'options' => array(
					'default-sidebarquestions' => array(
						'type' => 'html',
						'html' => 'Default sidebars',
						'label' => esc_html__('', 'listingo'),
						'desc' => esc_html__('You can set global sidebar for questions from here.', 'listingo'),
						'images_only' => true,
					),
                    'sd_layout_questions' => array(
						'label'   => esc_html__( 'Layout', 'listingo' ),
						'desc'    => esc_html__( 'Select sidebar position for questions.', 'listingo' ),
						'type'    => 'select',
						'value'   => 'full',
						'choices' => array(
							'left' 		=> esc_html__('Left sidebar', 'listingo'),	
							'right' 	=> esc_html__('Right sidebar', 'listingo'),	
							'full' 		=> esc_html__('Full width', 'listingo'),
						)
					),
					'sd_sidebar_questions' => array(
						'label'   => esc_html__( 'Sidebar', 'listingo' ),
						'desc'    => esc_html__( 'Select sidebar to display on questions detail page.', 'listingo' ),
						'type'    => 'select',
						'value'   => 'full',
						'choices' => listingoGetRegisterSidebars()
					)
                )
            ),
        )
    )
);
