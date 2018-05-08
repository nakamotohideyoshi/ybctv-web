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
 wp_enqueue_style('kommissar-font', THEME_PATH . '/fonts/style.min.css', array(), '1.0.0');
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

/*
* Search filter applied to only return posts (articles)
*/
function search_filter($query) {
  if ($query->is_search && !is_admin()) {
    $query->set('post_type', 'post');
  }
  return $query;
}

add_filter('pre_get_posts', 'search_filter');

function ajax_view_more() {
  $page = (int)$_POST['page'];
  $posts_per_page = 5;
  $offset = (int)$_POST['offset'];
  $category_id = (int)$_POST['category'];
  $term_id = (int)$_POST['term_id'];
  $type = $_POST['type'];
  $author = (int)$_POST['author'];

  //Archive template name
  $template_name = 'post';

  if(!empty($type)){
    //Query by post type (e.g. magazine)
    $template_name = $type;
    $args = array(
      'posts_per_page' => 5,
      'offset' => $page * $offset,
      'post_type' => $type,
      'orderby' => 'date',
      'order' => 'DESC'
    );
  }else{
    if(!empty($term_id)){
      //Query by term id  (e.g. video)
      $args = array(
        'posts_per_page' => 5,
        'offset' => ($page * $posts_per_page) + $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => array(
          array(
            'taxonomy' => 'type',
            'field' => 'term_id',
            'terms' => $term_id
            )
        )
      );
    }else{
      //Query by category id
      $args = array(
        'posts_per_page' => 5,
        'offset' => ($page * $posts_per_page) + $offset,
        'cat' => $category_id,
        'orderby' => 'date',
        'order' => 'DESC',
        'author' => $author
      );
    }
  }

  $posts = new WP_Query($args);

  if ($posts->have_posts()) {
    while($posts->have_posts()) {
      $posts->the_post();
      get_template_part('template-parts/archive', $template_name);
    }
  }
  wp_reset_postdata();
  die();
}

add_action('wp_ajax_nopriv_ajax_view_more', 'ajax_view_more');
add_action('wp_ajax_ajax_view_more', 'ajax_view_more');

//Search more
function ajax_search_more() {
  $page = (int)$_POST['page'];
  $offset = (int)$_POST['offset'];
  $posts_per_page = 5;
  $query = $_POST['query'];

  $args = array(
    'posts_per_page' => 5,
    'offset' => $offset * $page,
    'post_type' => 'post',
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    's' => $query
  );

  $posts = new WP_Query($args);

  if ($posts->have_posts()) {
    while($posts->have_posts()) {
      $posts->the_post();
      get_template_part('template-parts/archive', 'search');
    }
  }
  wp_reset_postdata();
  die();
}

add_action('wp_ajax_nopriv_ajax_search_more', 'ajax_search_more');
add_action('wp_ajax_ajax_search_more', 'ajax_search_more');

function change_wp_search_size($queryVars) {
  if ( isset($_REQUEST['s']) ) {// Make sure it is a search page
    if (is_admin () ) {
      $queryVars['posts_per_page'] = 20;
    } else {
      $queryVars['posts_per_page'] = 5;
    }
    $queryVars['orderby'] = 'date';
    $queryVars['order'] = 'DESC';
  }
  return $queryVars; // Return our modified query variables
}
add_filter('request', 'change_wp_search_size'); // Hook our custom function onto the request filter

/*
* Sticky JS.
*/
// function enqueue_sticky() {
//   wp_register_script('sticky', THEME_PATH . '/js/sticky.js', array('jquery'), '1.1.0', true);
//   wp_enqueue_script('sticky');
// }
//
// add_action('wp_enqueue_scripts', 'enqueue_sticky');

/*
* Remove and reorganize Dashboard Widgets for everyone except admins
*/
function remove_dashboard_widgets() {
  if (!current_user_can('manage_options')) {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['normal']['high']['ualp_dashboard_widget']);
    unset($wp_meta_boxes['dashboard']['normal']['high']['wp_ualp_dashboard_widget']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['wpe_dify_news_feed']);

    // Move Activity meta box to sidebars
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    add_meta_box('dashboard_activity', 'Activity', 'wp_dashboard_site_activity', 'dashboard', 'side', 'core');
  }
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets', 999);

/*
* Remove post edit Meta Boxes for authors
*/
function remove_post_edit_meta_boxes() {
  if (!current_user_can('manage_options')) {
    remove_meta_box('wpcrmShortcodeWizardContainer', 'post', 'normal');
    remove_meta_box('wordpresscrm_databinding_meta', 'post', 'side');
    remove_meta_box('formatdiv', 'post', 'side');
    remove_meta_box('lw_cross_post', 'post', 'side');
    remove_meta_box('tagsdiv-collection', 'post', 'side');
  }
}

add_action('add_meta_boxes', 'remove_post_edit_meta_boxes', 999);


/*
* Remove Menu items from Author admins
*/
function remove_menu_pages() {
  if (!current_user_can('manage_options')) {
    remove_menu_page('edit.php?post_type=lw_ad_unit');
    remove_menu_page('edit.php?post_type=tmm');
  }
}

add_action('admin_init', 'remove_menu_pages');

/*
* Allow Authors to edit other Authors post
*/

function add_theme_capabilities() {
  $role = get_role('author');
  $role->add_cap('edit_others_posts');
  $role->add_cap('edit_pages');
  $role->add_cap('edit_others_pages');
  $role->add_cap('edit_published_pages');
}

add_action('admin_init', 'add_theme_capabilities');

/*
* Stop reordering of categories on post edit page
*/

function disable_category_reordering($args) {
  $args['checked_ontop'] = false;
  return $args;
}

add_filter('wp_terms_checklist_args', 'disable_category_reordering');

/*
* Show Hidden Post Edit meta fields by default
*/

function show_hidden_meta_fields($hidden, $screen) {
  if ($screen->base == 'post') {
    foreach($hidden as $key => $value) {
      if ($value == 'postexcerpt' || $value == 'commentsdiv' || $value == 'commentstatusdiv') {
        unset($hidden[$key]);
        break;
      }
    }
  }
  return $hidden;
}

add_filter('default_hidden_meta_boxes', 'show_hidden_meta_fields', 10, 2);

/*
* Add Page break button to TinyMCE
*/
function add_page_break_button($buttons, $id) {
	if ('content' != $id) {
		return $buttons;
	}

	array_splice($buttons, 13, 0, 'wp_page');

	return $buttons;
}

add_filter('mce_buttons', 'add_page_break_button', 1, 2);

/*
* Teads JS.
*/
function enqueue_teads() {
  $show_ad_units_status = get_option('show_ad_units');

  if ($show_ad_units_status && $show_ad_units_status == 'yes') {
    if (wp_is_mobile()) {
      wp_register_script('teads', '//a.teads.tv/page/52801/tag', array(), '1.0.0', true);
    }
    else {
      wp_register_script('teads', '//a.teads.tv/page/52800/tag', array(), '1.0.0', true);
    }
    wp_enqueue_script('teads');
  }
}

add_action('wp_enqueue_scripts', 'enqueue_teads');

/*
* Add async attribute to Teads JS
*/
function add_async_js_attribute($tag, $handle, $src) {
  if ($handle == 'teads') {
    $tag = '<script type="text/javascript" src="' . esc_url($src) . '" async="true"></script>';
  }

  return $tag;
}

add_filter('script_loader_tag', 'add_async_js_attribute', 10, 3);

/*
* Co Authors Plus config
*/
function coauthors_parent_page() {
    return 'tools.php';
}

if (!current_user_can('manage_options')) {
  add_filter('coauthors_guest_author_parent_page', 'coauthors_parent_page');
}

function coauthors_capability() {
  return 'edit_posts';
}

add_filter('coauthors_guest_author_manage_cap', 'coauthors_capability');


// Change Error texts

remove_filter( 'authenticate', 'wp_authenticate_username_password' );
add_filter( 'authenticate', 'wpse_115539_authenticate_username_password', 20, 3 );
/**
 * Remove Wordpress filer and write our own with changed error text.
 */
function wpse_115539_authenticate_username_password( $user, $username, $password ) {
    if ( is_a($user, 'WP_User') )
        return $user;

    if ( empty( $username ) || empty( $password ) ) {
        if ( is_wp_error( $user ) )
            return $user;

        $error = new WP_Error();

        if ( empty( $username ) )
            $error->add( 'empty_username', __('<strong>Incorrect username</strong>: The username field is empty.' ) );

        if ( empty( $password ) )
            $error->add( 'empty_password', __( '<strong>Incorrect password</strong>: The password field is empty.' ) );

        return $error;
    }

    $user = get_user_by( 'login', $username );

    if ( !$user )
        return new WP_Error( 'invalid_username', sprintf( __( '<strong>Incorrect username</strong>: We do not have a user with those details, please register or contact our customer services team for any queries.' ), wp_lostpassword_url() ) );

    $user = apply_filters( 'wp_authenticate_user', $user, $password );
    if ( is_wp_error( $user ) )
        return $user;

    if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) )
        return new WP_Error( 'incorrect_password', sprintf( __( '<strong>Incorrect password</strong>: Your password is incorrect. Use the Forgot password function to reset your password.' ),
        $username, wp_lostpassword_url() ) );

    return $user;
}

/*
* 404 page
*/
// Ensures this function is only called after the theme is setup
// You could bind to the "init" event if "after_setup_theme" doesn't work well for you.
add_action('after_setup_theme', 'create_404_page');

// Insert a privately published page we can query for our 404 page
function create_404_page() {

  // Check if the 404 page exists
  $page_exists = get_page_by_title( '404' );

  if (!isset($page_exists->ID)) {

    // Page array
    $page = array(
      'post_author' => 1,
      'post_content' => '',
      'post_name' =>  '404',
      'post_status' => 'private',
      'post_title' => '404',
      'post_type' => 'page',
      'post_parent' => 0,
      'menu_order' => 0,
      'to_ping' =>  '',
      'pinged' => '',
    );

    $insert = wp_insert_post($page);

    // The insert was successful
    if ($insert) {
      // Store the value of our 404 page
      update_option( '404pageid', (int) $insert );
    }
  }
}

//Custom feed function
function customFeed($object){
  $html = '';
  $maxitems = 0;

  if ( ! is_wp_error( $rssEi ) ) :
    $maxitems = $object->get_item_quantity( 3 );
    $rss_items = $object->get_items( 0, $maxitems );
  endif;

  if ( $maxitems == 0 ){
      $html .= '<p>'. _e( 'No items', 'my-text-domain' ) .'</p>';
  } else {
    foreach ( $rss_items as $item ){
      $html .= '<p>';
      $html .= '<a href="'. esc_url( $item->get_permalink() ) .'" target="_blank" title="'. esc_html( $item->get_title() ).'">';
      $html .= mb_strimwidth( esc_html( $item->get_title() ), 0, 35, '...' );
      $html .= '</a></p>';
    }
  }
  return $html;
}

// armin Limit Excerpt Length by number of Words
function excerpt( $limit ) {
$excerpt = explode(' ', get_the_excerpt(), $limit);
if (count($excerpt)>=$limit) {
array_pop($excerpt);
$excerpt = implode(" ",$excerpt).'...';
} else {
$excerpt = implode(" ",$excerpt);
}
$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
return $excerpt;
}
function content($limit) {
$content = explode(' ', get_the_content(), $limit);
if (count($content)>=$limit) {
array_pop($content);
$content = implode(" ",$content).'...';
} else {
$content = implode(" ",$content);
}
$content = preg_replace('/[.+]/','', $content);
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
return $content;
}

//Set custom logo on login/l
function custom_loginlogo() {
echo '<style type="text/css">
h1 a {width: 150px !important;background-size: contain !important;background-image: url('.get_bloginfo('template_directory').'/images/Portfolio-Advisor-logo.svg) !important; }
</style>';
}
add_action('login_head', 'custom_loginlogo');

// fixes "Lost Password?" URLs on login page
add_filter("lostpassword_url", function ($url, $redirect) {

  $args = array( 'action' => 'lostpassword' );
  if ( !empty($redirect) )
    $args['redirect_to'] = $redirect;
  return add_query_arg( $args, site_url('wp-login.php') );
}, 10, 2);

// fixes other password reset related urls
add_filter( 'network_site_url', function($url, $path, $scheme) {

    if (stripos($url, "action=lostpassword") !== false)
    return site_url('wp-login.php?action=lostpassword', $scheme);

    if (stripos($url, "action=resetpass") !== false)
    return site_url('wp-login.php?action=resetpass', $scheme);

  return $url;
}, 10, 3 );

// fixes URLs in email that goes out.
add_filter("retrieve_password_message", function ($message, $key) {
    return str_replace(get_site_url(1), get_site_url(), $message);
}, 10, 2);

// fixes email title
add_filter("retrieve_password_title", function($title) {
  return "[" . wp_specialchars_decode(get_option('blogname'), ENT_QUOTES) . "] Password Reset";
});

/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */

function my_login_redirect( $redirect_to, $request, $user ) {
  //is there a user to check?
  if ( isset( $user->roles ) && is_array( $user->roles ) ) {
    //check for admins, editor or authors
    if ( in_array( 'administrator', $user->roles ) || in_array( 'author', $user->roles ) || in_array( 'editor', $user->roles )) {
      // redirect them to the default place
      return $redirect_to;
    } else {
      return home_url();
    }
  } else {
    return $redirect_to;
  }
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

/**
 * Redirect subscribers to home page from admin page
 *
 * This function is attached to the 'admin_init' action hook.
 */
// function redirect_non_admin_users() {
//   $user = wp_get_current_user();
//   if ( isset( $user->roles ) && is_array( $user->roles ) ) {
//     //check for subscriber
//     if ( in_array( 'subscriber', $user->roles ) ) {
//         wp_redirect( home_url() );
//         exit;
//     }
//   }
// }
// add_action( 'admin_init', 'redirect_non_admin_users' );

/*
 * Force URLs in srcset attributes into HTTPS scheme.
*/

function ssl_srcset( $sources ) {
  foreach ( $sources as &$source ) {
    $source['url'] = set_url_scheme( $source['url'], 'https' );
  }

  return $sources;
}
add_filter( 'wp_calculate_image_srcset', 'ssl_srcset' );

/* Articles Control */
add_action('admin_menu', 'add_featured_box_menu_item');
function add_featured_box_menu_item() {
  add_options_page(
    'Featured boxes',
    'Featured boxes',
    'edit_posts',
    'featured_box_settings',
    'add_featured_box_settings_page'
  );
}

function add_featured_box_settings_page() {
  $posts = get_posts( array( 'posts_per_page' => 100 ) );

  if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['featured_left_box_article']) && isset($_POST['featured_right_box_article']) )
  {
    update_option('featured_left_box_article', $_POST['featured_left_box_article'] );
    update_option('featured_right_box_article', $_POST['featured_right_box_article'] );
  }

  $featured_left_box_article = get_option('featured_left_box_article', 0);
  $featured_right_box_article = get_option('featured_right_box_article', 0);

  ?>
  <div class="most-read-settings wrap">
    <h2>Featured boxes</h2>
    <form action="" method="post">
      <table class="form-table">
        <tr>
          <th scope="row">Sponsored Box (left hand)</th>
          <td>
            <div>
              Please either select the article from the drop down option or add the Wordpress article ID in the box.
              To find the Wordpress article ID please use the instructions from this
              <a href="https://www.youtube.com/watch?v=fLg2T1AvmFE" target="_blank">video</a>.
            </div>

            <br/>

            <select name="featured_left_box_article" id="featured_left_box_article_combo" onchange="document.getElementById('featured_left_box_article_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$featured_left_box_article == $post->ID ? 'selected="selected"' : ''; ?>>
                  <?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="featured_left_box_article_field" name="featured_left_box_article" value="<?php echo $featured_left_box_article; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>

        <tr>
          <th scope="row">Editorial Box (right hand)</th>
          <td>
            <div>
              Please either select the article from the drop down option or add the Wordpress article ID in the box.
              To find the Wordpress article ID please use the instructions from this
              <a href="https://www.youtube.com/watch?v=fLg2T1AvmFE" target="_blank">video</a>.
            </div>

            <br/>

            <select name="featured_right_box_article" id="featured_right_box_article_combo" onchange="document.getElementById('featured_right_box_article_field').value = this.value;">
              <option value="">-</option>
              <?php foreach( $posts as $post ): ?>
                <option value="<?php echo $post->ID; ?>" <?php echo (int)$featured_right_box_article == $post->ID ? 'selected="selected"' : ''; ?>><?php echo $post->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td>
            <input type="text" id="featured_right_box_article_field" name="featured_right_box_article" value="<?php echo $featured_right_box_article; ?>" />

            <span>(Wordpress article ID)</span>
          </td>
        </tr>

        <tr>
          <th colspan="2">
            <?php submit_button(); ?>
          </th>
      </table>
    </form>
  </div>
  <?
}
/* End Articles Control */
/* Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );


		function ea_primary_menu_extras( $menu, $args ) {
    if( 'primary' == $args->theme_location )
      $menu .= '<li class="menu-item search"><a href="#" class="search-toggle"><i class="icon-search"></i></a>' . get_search_form( false ) . '</li>';
    return $menu;
}
add_filter( 'wp_nav_menu_items', 'ea_primary_menu_extras', 10, 2 );

add_filter( 'lw_title_args', 'lw_title_args_yoastb', 10, 1 );
function lw_title_args_yoastb( $args ) {
  $args['breadcrumb'] = false;
  ob_start();
  yoast_breadcrumb();
  $yoastb = ob_get_clean();
  $args['additions'] = '<div class="breadcrumb breadcrumbs avia-breadcrumbs">'.$yoastb.'</div>';
  return $args;
}
