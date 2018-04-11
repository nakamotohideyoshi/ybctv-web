<?php
add_shortcode( 'lw_register', 'lw_register_func' );

function lw_register_func($atts){
	global $source;
	
	$atts = shortcode_atts(
		array(
			'source' => '',
		), $atts, 'crm_source' );
	
	$source = $atts['source'];
	
	ob_start();
	include "templates/html-register.php";
	return ob_get_clean();
}

add_shortcode( 'lw_registration', 'lw_register_func' );

function lw_registration_func($atts){
	global $source;
	
	$atts = shortcode_atts(
		array(
			'source' => '',
		), $atts, 'crm_source' );
	
	$source = $atts['source'];
	
	ob_start();
	include "templates/html-registration.php";
	return ob_get_clean();
}

add_shortcode( 'lw_activate', 'lw_activate_func' );

function lw_activate_func($atts){
	global $source;
	
	$atts = shortcode_atts(
		array(
			'source' => '',
		), $atts, 'crm_source' );
	
	$source = $atts['source'];
	
	ob_start();
	include "templates/html-activate.php";
	return ob_get_clean();
}

add_shortcode( 'lw_req_magazine', 'req_magazine_func' );

function req_magazine_func($atts){
	global $source;
	
	$atts = shortcode_atts(
		array(
			'source' => '',
		), $atts, 'crm_source' );
	
	$source = $atts['source'];
	
	ob_start();
	include "templates/html-magazine.php";
	return ob_get_clean();
}

add_shortcode( 'lw_email_alert', 'email_alert_func' );

function email_alert_func($atts){
	global $source;
	
	$atts = shortcode_atts(
		array(
			'source' => '',
		), $atts, 'crm_source' );
	
	$source = $atts['source'];
	
	ob_start();
	include "templates/html-email-alert.php";
	return ob_get_clean();
}

add_shortcode( 'lw_your_profile', 'lw_your_profile_func' );

function lw_your_profile_func(){
	ob_start();
	include "templates/html-your-profile.php";
	return ob_get_clean();
}

add_shortcode( 'lw_getblogid', 'lw_blogid_func' );

function lw_blogid_func($atts){	
	$blogid = get_current_blog_id();
	return $blogid;
}

add_shortcode( 'lw_subscribe', 'lw_subscribe_func' );

function lw_subscribe_func(){
	ob_start();
	include "templates/html-subscribe.php";
	return ob_get_clean();
}

add_action( 'wp_enqueue_scripts', 'cg_scripts' );

function cg_scripts(){
	wp_enqueue_script( 'validate', plugins_url( '/js/jquery.validate.min.js', __FILE__ ) ); 
	wp_enqueue_script( 'jquery-steps', plugins_url( '/js/jquery.steps.min.js', __FILE__ ) ); 
	wp_enqueue_script( 'jquery', plugins_url( '/js/jquery.js', __FILE__ ) ); 
	// wp_enqueue_script( 'jquery-angular', plugins_url( '/js/angular.min.js', __FILE__ ) ); 
}
?>