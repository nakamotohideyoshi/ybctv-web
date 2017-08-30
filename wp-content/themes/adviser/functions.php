<?php

/*
 *constants
 */

define('THEME_NAME', 'theme');
define('TEXT_DOMAIN', 'theme');
define('THEME_VERSION', '1.0');
define('THEME_PATH', get_template_directory_uri());
define('SERVER_PATH', get_template_directory());

/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Optional: set 'ot_show_new_layout' filter to false.
 * This will hide the "New Layout" section on the Theme Options page.
 */
add_filter( 'ot_show_new_layout', '__return_false' );

/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */

load_template( trailingslashit( SERVER_PATH ) . 'option-tree/ot-loader.php' );

/**
 * Required: include Theme Options
 */
load_template( trailingslashit( SERVER_PATH ) . 'extension/theme-options.php' );

/**
 * Required: include custom post type
 */
load_template( trailingslashit( SERVER_PATH ) . 'extension/portfolio-post-type.php' );

/**
 * Required: include meta box for portfolio and post
 */
load_template( trailingslashit( get_template_directory()  ) . 'extension/portfolio-meta-boxes.php' );

/**
 * Required: include theme-functions
 */
load_template( trailingslashit( SERVER_PATH ) . 'extension/theme-functions.php' );

/**
 * Required: include plugin Aqua Resizer
 */
load_template( trailingslashit( get_template_directory()  ) . 'extension/aq_resizer.php' );

/**
 * Required: include plugin theme scripts
 */
load_template( trailingslashit( get_template_directory()  ) . 'extension/theme-scripts.php' );

/**
 * Required: include plugin theme sidebars
 */
load_template( trailingslashit( get_template_directory()  ) . 'extension/theme-sidebars.php' );

/*
 * Required: include plugin theme scripts
 */
load_template( trailingslashit( get_template_directory()  ) . 'extension/process-option.php' );

/*
 * method load  portfolio-meta-boxes Scripts
 */

// Remove theme generator meta tag
remove_action('wp_head', 'wp_generator');

if (function_exists('add_theme_support')) {
    // enable featured image
    add_theme_support('post-thumbnails');
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ) );
}

add_action( 'after_setup_theme', 'setup' );



add_action('admin_head', 'portfolio_scripts');


function portfolio_scripts()
{
    if(is_admin()):

        wp_enqueue_style('theme-option', THEME_PATH . '/extension/assets/css/theme-options.css');

        wp_enqueue_script('portfolio_meta_boxes', THEME_PATH . '/extension/assets/js/portfolio_meta_boxes.js', false, '1.0', $in_footer=true);

        wp_enqueue_script('portfolio_theme_option', THEME_PATH . '/extension/assets/js/portfolio_theme_option.js', false, '1.0', $in_footer=true);

        ?>

        <style type="text/css">
            #portfolio_meta_box .format-setting-label {
                border: none;
                margin: 0;
            }
            #portfolio_meta_box .ot-metabox-wrapper .format-settings {
                margin-bottom: 15px;
            }
        </style>

        <?php
    endif;

}
/*
 *  method add global javascript variable THEME_PREFIX to admin_head
 */

function theme_addto_header() {
    ?>
    <?php
}
add_action('admin_head', 'theme_addto_header');
add_action('wp_head', 'theme_addto_header');

/*
 * Method add ot_get_option
 */

if(!is_admin()):

    if ( ! function_exists( 'ot_get_option' ) ) {
        function ot_get_option( $option_id, $default = '' ) {
            /* get the saved options */
            $options = get_option( 'option_tree' );
            /* look for the saved value */
            if ( isset( $options[$option_id] ) && '' != $options[$option_id] ) {
                return $options[$option_id];
            }
            return $default;
        }
    }
    if(function_exists('ot_get_option')){

        /*===================================
         * Home settings
         ==================================*/



    }


endif;

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
    $content_width = 960;

/*
 * Adds JavaScript to pages with the comment form to support
 * sites with threaded comments (when in use).
 */
if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );

if (isset($googAnlytice) && $googAnlytice != '') {
    add_action('wp_footer', 'add_google_analytics_code');
}

function add_google_analytics_code() {
    echo '<script type="text/javascript">';
    echo ot_get_option('google_analytics');
    echo '</script>';
}

/*
 * This function is used to get people to check out the article
*/
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){ // If such views are not
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0"; // return value of 0
    }
    return $count; // Returns views
}
/*
 * This function is used to set and update the article views.
*/
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++; // Incremental view
        update_post_meta($postID, $count_key, $count); // update count
    }
}

/*
 * This function is used to category children
*/
function category_has_children() {
    global $wpdb;
    $term = get_queried_object();
    $category_children_check = $wpdb->get_results(" SELECT * FROM wp_term_taxonomy WHERE parent = '$term->term_id' ");
    if ($category_children_check) {
        return true;
    } else {
        return false;
    }
}

/*
 * Methor support author for portoflio
 */
add_filter('posts_where', 'include_for_author');
function include_for_author($where){
    if(is_author())
        $where = str_replace(".post_type = 'post'", ".post_type in ('post', 'portfolio')", $where);

    return $where;
}

/*
 * Method limit excerpt
 */
function limitexcerpt($lenght){
    $limitexcerpt = ot_get_option('porlimitexcerpt',25);;
    return $limitexcerpt ;
}
add_filter('excerpt_length','limitexcerpt');


function new_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

/*get_excerpt*/
function get_excerpt($count){
    global $post;
    $permalink    = get_permalink($post->ID);
    $excerpt      = get_the_content();
    $excerpt      = strip_tags($excerpt);
    $excerpt      = substr($excerpt, 0, $count);
    $excerpt      = $excerpt.'<a href="'.$permalink.'">...</a>';
    return $excerpt;
}

/*wpb_set_post_views*/
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/*wpb_track_post_views*/
function wpb_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    wpb_set_post_views($post_id);
}
add_action( 'wp_head', 'wpb_track_post_views');

/*wpb_get_post_views*/
function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}

/*
 * Menu Home
 */
if (function_exists('register_nav_menu')) {
    register_nav_menus( array(
        'main_nav'          => 'Menu Main',
        'main_footer'          => 'Menu Footer',
    ));
};

/*
 * Kommissar font
 */
function enqueue_kommissar_font() {
 wp_enqueue_style('kommissar-font', THEME_PATH . '/fonts/style.css', array(), '1.0.0');
}

add_action('wp_enqueue_scripts', 'enqueue_kommissar_font');

/*
* Pagefair JS.
*/
function enqueue_pagefair() {
  wp_register_script('pagefair', THEME_PATH . '/js/pagefair.js', array('jquery'), '1.0.0', false);
  wp_enqueue_script('pagefair');
}

add_action('wp_enqueue_scripts', 'enqueue_pagefair');


?>
