<?php
/**
 * Theme functions file
 */

/**
 * Enqueue parent theme styles first
 * Replaces previous method using @import
 * <http://codex.wordpress.org/Child_Themes>
 */

function listingo_theme_enqueue_styles() {
	$parent_theme_version = wp_get_theme('listingo');
	$child_theme_version  = wp_get_theme('listingo-child');
	
    $parent_style = 'listingo_style';
  	wp_enqueue_style( 'listingo_child_styles',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
		$child_theme_version->get('Version')
    );
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array('bootstrap','chosen'),$parent_theme_version->get('Version'));
}

function myCustomScript() { ?>
  <script type="text/javascript">
  jQuery( document ).ready(function() {
      jQuery('input[type="radio"]').on('change', function(){
        var $target = jQuery('input[type="radio"]:checked');
          jQuery(".jsCategory").hide();
          jQuery($target.attr('data-section')).show();
      })
  });
  </script>
  <?php
}

add_action( 'wp_enqueue_scripts', 'listingo_theme_enqueue_styles' );
add_action( 'wp_footer', 'myCustomScript' );