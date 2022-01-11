<?php

/**
 * Theme functions file
 */

/**
 * Enqueue parent theme styles first
 * Replaces previous method using @import
 * <http://codex.wordpress.org/Child_Themes>
 */

function listingo_theme_enqueue_styles()
{
  $parent_theme_version = wp_get_theme('listingo');
  $child_theme_version  = wp_get_theme('listingo-child');

  $parent_style = 'listingo_style';
  wp_enqueue_style(
    'listingo_child_styles',
    get_stylesheet_directory_uri() . '/style.css',
    array($parent_style),
    $child_theme_version->get('Version')
  );
  wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css', array('bootstrap', 'chosen'), $parent_theme_version->get('Version'));
}

function add_custom_css()
{
  wp_enqueue_style('listingo_child_stylesCustom', get_stylesheet_directory_uri() . '/css/newStyles.css', array(), time(), false );
}

function remove_has_published_posts_from_api_user_query($prepared_args, $request)
{
  unset($prepared_args['has_published_posts']);

  return $prepared_args;
}

function getAllUsers()
{
  register_rest_route('users/', 'all', array(
    'methods' => 'GET',
    'callback' => 'get_user_data',
  ));
}

function getCurrentUser()
{
  register_rest_route('users/', 'current', array(
    'methods' => 'GET',
    'callback' => 'get_current_logged_user',
  ));
}

function createUser()
{
  register_rest_route('users/', 'create', array(
    'methods' => 'GET',
    'callback' => 'create_user_data',
  ));
}

function get_user_data()
{
  return new WP_REST_Response(get_users());
}

function get_current_logged_user()
{
  echo "Here";
  // return new WP_REST_Response(wp_get_current_user());
}

function create_user_data()
{
  // echo "Create User";
}

//enqueue the script which will use the api
function api_callings_scripts() {
  wp_enqueue_script('listingo_child_jsCustom', get_stylesheet_directory_uri() . '/js/newJquery.js', ['jquery'], NULL, TRUE);
  // Pass nonce to JS.
  wp_localize_script('score-listingo_child_jsCustom', 'jsSettings', [
    'nonce' => wp_create_nonce('wp_rest'),
  ]);
}

add_action('wp_enqueue_scripts', 'listingo_theme_enqueue_styles');
add_action('wp_enqueue_scripts', 'add_custom_css');
add_action('wp_enqueue_scripts', 'api_callings_scripts' ); 
add_action('rest_api_init', 'getAllUsers');
add_action('rest_api_init', 'getCurrentUser');
add_action('rest_api_init', 'createUser');

