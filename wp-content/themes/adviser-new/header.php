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
  do_action('tagManagerHeadScript');
  wp_head();
?>
</head>

<body <?php body_class(); ?>>
<?php
  do_action('tagManagerBodyScript');
  lastWordAdUnit2('oop-teads');
  lastWordAdUnit2('oop-overlay');
?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>
    <?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
	<header id="masthead" class="site-header fixed-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
        <div class="container">
			<div class="row">
			<div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
			<div class="navbar-brand">

                        <a href="<?php echo esc_url( home_url( '/' )); ?>">
                            <img class="logo"src="<?php bloginfo('template_url'); ?>/inc/assets/img/logo.svg" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        </a>


                </div>
			</div>

				<div class="col-xl-10 col-lg-9 col-md-9 col-sm-8 col-6">
				<div class="row">
				<div class="top-bar col-md-12 float-right">

				<div class="social-col">
				 <div class="social">
                <a target="_blank" href="https://www.facebook.com/LastWordMedia">
                    <i class="face"></i>
                  </a>
                  <a target="_blank" href="https://www.linkedin.com/company/portfolio-adviser">
                    <i class="linkedin"></i>
                  </a>
                  <a target="_blank" href="https://twitter.com/PortfAdviser">
                    <i class="twit"></i>
                  </a>

                  <div class="reklama">
				  <?php lastWordAdUnit2('top-search'); ?></div>
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
                      <a href="#" data-toggle="modal" data-target="#signinmodal">
                        Sign in
                      </a>
                    </li>

                    <?php
                      }
                    ?>
                  </ul>
                </div>
				</div>
			  </div>
            </div>

			<div class="col-12">
			<nav class="navbar navbar-expand-xl">


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
<a href="#" data-toggle="modal" data-target="#searchmodal"><img class="img-responsive search-icon" src="<?php bloginfo('template_directory'); ?>/inc/assets/img/search.svg" /></a>
            </nav>
			</div>

			</div>
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
      <?php if(wp_is_mobile()) : ?>
        <div style="padding-top: 20px; max-width: 320px; margin: 0 auto">
          <?php lastWordAdUnit2('adh-banner'); ?>
        </div>
      <?php endif; ?>
	<!-- Modal -->
                    <div id="signinmodal" class="modal fade" role="dialog">
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
		<div class="search-outer">
<div id="searchmodal" class="modal fade" role="dialog">
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <!-- Modal content-->
                        <div class="modal-content">

                          <div class="modal-body">
                            <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
  <div class="input-group">
    <input type="text" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Start typing...', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" aria-describedby="search-form">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-default" id="search-form"><?php echo esc_attr_x( 'Search', 'submit button' ) ?>
        </button>
      </span>
  </div>
</form>
                          </div>
                        </div>
                      </div>
                    </div>
					</div>
      <div class="rowx">
        <?php endif; ?>
