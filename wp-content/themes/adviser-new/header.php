<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
     <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">
	 <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,600,700" rel="stylesheet">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="stylesheet" type="text/css" href="https://cloud.typography.com/6660074/7138392/css/fonts.css" />
<?php
  lastWordAdUnitInitialize(is_front_page() ? 0 : get_the_ID());
  wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>
    <?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
	<header id="masthead" class="site-header fixed-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
        <div class="container">
			<div class="row">
			<div class="col-md-2 col-sm-4 col-xs-5">
			<div class="navbar-brand">

                        <a href="<?php echo esc_url( home_url( '/' )); ?>">
                            <img class="logo"src="<?php bloginfo('template_url'); ?>/inc/assets/img/logo.svg" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        </a>


                </div>
			</div>
				<div class="col-md-10">
				<div class="row">
				<div class="top-bar col-md-12 float-right">

				<div class="social-col">
				 <div class="social">
                  <a target="_blank" href="https://www.facebook.com/LastWordMedia">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 31 31">
                      <style type="text/css">
                       .st0{fill:none;stroke:#1D1D1B;stroke-miterlimit:10;}
                      </style>
                      <path d="M13.4 15.2h-1.6v-2.2h1.6v-1.5c0-0.7 0-1.7 0.5-2.3C14.4 8.5 15.1 8 16.3 8c2 0 2.8 0.3 2.8 0.3l-0.4 2.3c0 0-0.6-0.2-1.2-0.2s-1.1 0.2-1.1 0.8v1.8h2.5v0l-0.2 2.2h-2.3v7.8h-2.9"/><path class="st0" d="M15.5 0.5c-8.3 0-15 6.7-15 15s6.7 15 15 15 15-6.7 15-15C30.5 7.2 23.8 0.5 15.5 0.5z"/>
                    </svg>
                  </a>
                  <a target="_blank" href="https://www.linkedin.com/company/portfolio-adviser">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 31 31">
                      <style type="text/css">
                         .st0{fill:none;stroke:#1D1D1B;stroke-miterlimit:10;}
                      </style>
                      <polygon points="11.3 21.4 8.4 21.4 8.4 12 11.3 12 11.3 21.4 "/>
                      <path d="M9.8 10.8H9.7c-1.1 0-1.7-0.7-1.7-1.6 0-0.9 0.7-1.6 1.8-1.6 1.1 0 1.7 0.7 1.8 1.6C11.5 10.1 10.9 10.8 9.8 10.8z"/>
                      <path d="M23 21.4h-3.3v-4.8c0-1.3-0.5-2.1-1.7-2.1 -0.9 0-1.4 0.6-1.6 1.1 -0.1 0.2-0.1 0.5-0.1 0.8v5.1h-3.3c0 0 0-8.6 0-9.4h3.3v1.5c0.2-0.6 1.2-1.6 2.9-1.6 2.1 0 3.7 1.3 3.7 4.2v5.2H23z"/>
                      <path class="st0" d="M15.5 0.5c-8.3 0-15 6.7-15 15s6.7 15 15 15 15-6.7 15-15C30.5 7.2 23.8 0.5 15.5 0.5z"/>
                    </svg>
                  </a>
                  <a target="_blank" href="https://twitter.com/PortfAdviser">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 31 31">
                      <style type="text/css">
                       .st0{fill:none;stroke:#1D1D1B;stroke-miterlimit:10;}
                       .st1{fill:#1D1D1B;}
                      </style>
                      <path class="st0" d="M15.5 0.5c-8.3 0-15 6.7-15 15s6.7 15 15 15 15-6.7 15-15C30.5 7.2 23.8 0.5 15.5 0.5z"/>
                      <path class="st1" d="M21.5 13.2c0 0.1 0 0.3 0 0.4 0 4.1-3.1 8.8-8.8 8.8 -1.7 0-3.4-0.5-4.7-1.4 0.2 0 0.5 0 0.7 0 1.4 0 2.8-0.5 3.8-1.3 -1.3 0-2.5-0.9-2.9-2.1 0.2 0 0.4 0.1 0.6 0.1 0.3 0 0.6 0 0.8-0.1 -1.4-0.3-2.5-1.5-2.5-3v0C9 14.7 9.5 14.8 10 14.8c-0.8-0.6-1.4-1.5-1.4-2.6 0-0.6 0.2-1.1 0.4-1.6 1.5 1.9 3.8 3.1 6.4 3.2 -0.1-0.2-0.1-0.5-0.1-0.7 0-1.7 1.4-3.1 3.1-3.1 0.9 0 1.7 0.4 2.3 1 0.7-0.1 1.4-0.4 2-0.7 -0.2 0.7-0.7 1.3-1.4 1.7 0.6-0.1 1.2-0.2 1.8-0.5C22.6 12.2 22.1 12.7 21.5 13.2z"/>
                    </svg>
                  </a>

                  <?php lastWordAdUnit2('top-search'); ?>
                </div></div>
				<div class="user-login">
                  <ul>
                    <li class="user-login-contact">
                      <a href="<?php echo home_url();?>/contact">
                        Contact
                      </a>
                    </li>
                    <?php
                      if (is_user_logged_in()) {
                    ?>
                    <li class="user-login-profile">
                      <a href="<?php echo site_url( '/your-profile/' ) ?>">
                        My account
                      </a>
                    </li>
                    <?php
                      } else {
                    ?>
                    <li class="user-login-register">
                      <a href="<?php echo home_url();?>/register">
                        Register
                      </a>
                    </li>
                    <li class="user-login-profile">
                      <a href="#" data-toggle="modal" data-target="#myModal">
                        Sign in
                      </a>
                    </li>

                    <?php
                      }
                    ?>
                  </ul>
                </div>
				</div></div>
            <nav class="navbar navbar-expand-xl p-0">


                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <?php
                wp_nav_menu(array(
                'theme_location'    => 'primary',
                'container'       => 'div',
                'container_id'    => 'main-nav',
                'container_class' => 'collapse navbar-collapse justify-content-end',
                'menu_id'         => false,
                'menu_class'      => 'navbar-nav',
                'depth'           => 3,
                'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
                'walker'          => new wp_bootstrap_navwalker()
                ));
                ?>
<img class="img-responsive search-icon" src="<?php bloginfo('template_directory'); ?>/inc/assets/img/search.svg" />
            </nav></div></div>
        </div>
	</header><!-- #masthead -->
    <?php if(is_front_page() && !get_theme_mod( 'header_banner_visibility' )): ?>
        <div id="page-sub-header" <?php if(has_header_image()) { ?>style="background-image: url('<?php header_image(); ?>');" <?php } ?>>
            <div class="container">
                <h1>
                    <?php
                    if(get_theme_mod( 'header_banner_title_setting' )){
                        echo get_theme_mod( 'header_banner_title_setting' );
                    }else{
                        echo 'Wordpress + Bootstrap';
                    }
                    ?>
                </h1>
                <p>
                    <?php
                    if(get_theme_mod( 'header_banner_tagline_setting' )){
                        echo get_theme_mod( 'header_banner_tagline_setting' );
                }else{
                        echo esc_html__('To customize the contents of this header banner and other elements of your site, go to Dashboard > Appearance > Customize','wp-bootstrap-starter');
                    }
                    ?>
                </p>
                <a href="#content" class="page-scroller"><i class="fa fa-fw fa-angle-down"></i></a>
            </div>
        </div>
    <?php endif; ?>
	<div id="content" class="site-content">
    <div class="ads-side-panels">
      <div class="container">
        <div class="side-panel-left-container">
          <div class="side-panel-left">
            <?php lastWordAdUnit2('oop-lskin'); ?>
          </div>
        </div>
        <div class="side-panel-right-container">
          <div class="side-panel-right">
            <?php lastWordAdUnit2('oop-rskin'); ?>
          </div>
        </div>
      </div>
    </div>
  	<div class="ads-top-billboard-container">
       <?php lastWordAdUnit2('top-billboard'); ?>
    </div>
    <div class="container">
	<!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">


                            <h3 class="modal-title">SIGN IN PORTFOLIO ADVISER</h3>
                          </div>
                          <div class="modal-body">
                            <p>Access full content on the Portfolio Adviser site, access your saved articles, control email preferences and amend your account details</p>
                            <?php echo do_shortcode('[login-with-ajax]');?>
                            <hr>
                            <a class="modal-link" href="/register">Not Registered?</a>
                          </div>
                        </div>
                      </div>
                    </div>
      <div class="row">
        <?php endif; ?>
