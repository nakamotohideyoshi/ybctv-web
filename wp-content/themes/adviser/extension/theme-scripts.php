<?php
add_action('init', 'register_theme_scripts');
function register_theme_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php') {

        if (is_admin()) {

            global $wp_scripts;

            wp_enqueue_style('_admin_custom_styles', THEME_PATH . '/extension/assets/css/admin-styles.css');
            wp_register_script('_admin_custom_scripts', THEME_PATH . '/extension/assets/js/admin-scripts.js', array(), '1.0', false);
            wp_enqueue_script('_admin_custom_scripts');

            // get registered script object for jquery-ui
            $ui = $wp_scripts->query('jquery-ui-core');

            // tell WordPress to load jQuery UI slider
            wp_enqueue_script('jquery-ui-slider');

            // tell WordPress to load jQuery UI sortable
            wp_enqueue_script('jquery-ui-sortable');

        } else {

            add_action('wp_enqueue_scripts', 'register_front_end_styles');
            add_action('wp_enqueue_scripts', 'register_front_end_scripts');

        }
    }
}

//Register Front-End Styles
function register_front_end_styles()
{
    wp_enqueue_style('bootstrap', THEME_PATH . '/css/bootstrap.css', false );

    wp_enqueue_style('font-awesome', THEME_PATH . '/css/font-awesome.css', false );

    wp_enqueue_style('owl.carousel', THEME_PATH . '/css/owl.carousel.css', false );

    wp_enqueue_style('jquery.bxslider', THEME_PATH . '/css/jquery.bxslider.css', false );

    wp_enqueue_style('flexslider', THEME_PATH . '/css/flexslider.css', false );

    wp_enqueue_style('superfish', THEME_PATH . '/css/superfish.css', false );

    wp_enqueue_style('style-theme', THEME_PATH . '/style.css', false );

}

//Register Front-End Scripts
function register_front_end_scripts()
{
    wp_enqueue_script('jquery');

    wp_enqueue_script('bootstrap.min', THEME_PATH . '/js/bootstrap.min.js', false, false, $in_footer=true);

    wp_enqueue_script('hoverIntent', THEME_PATH . '/js/hoverIntent.js', false, false, $in_footer=true);

    wp_enqueue_script('superfish.min', THEME_PATH . '/js/superfish.min.js', false, false, $in_footer=true);

    wp_enqueue_script('jquery.flexslider', THEME_PATH . '/js/jquery.flexslider.js', false, false, $in_footer=true);

    wp_enqueue_script('owl.carousel.min', THEME_PATH . '/js/owl.carousel.min.js', false, false, $in_footer=true);

    wp_enqueue_script('jquery.bxslider.min', THEME_PATH . '/js/jquery.bxslider.min.js', false, false, $in_footer=true);

    wp_enqueue_script('jquery.jscroll', THEME_PATH . '/js/jquery.jscroll.js', false, false, $in_footer=true);

    wp_enqueue_script('custom', THEME_PATH . '/js/custom.js', false, false, $in_footer=true);

    wp_localize_script('custom', 'ajaxviewmore', array('ajaxurl' => admin_url('admin-ajax.php')));

}

?>
