<?php
/*
 * The Header for our theme.
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <title><?php
        /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;
        wp_title( '|', true, 'right' );
        // Add the blog name.
        bloginfo( 'name' );
        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            echo " | $site_description";
        // Add a page number if necessary:
        if ( $paged >= 2 || $page >= 2 )
            echo ' | ' . sprintf( __( 'Page %s', TEXT_DOMAIN ), max( $paged, $page ) );
        ?>
    </title>
    <link rel="stylesheet" type="text/css" href="https://cloud.typography.com/6660074/6822792/css/fonts.css" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <?php wp_head(); ?>
    <?php
    if (is_home()) {
      lastWordAdUnitInitialize('homepage');
    }
    ?>
</head>
<body id="bd" <?php body_class(); ?>>
<div id="page" class="hfeed site">
    <?php
      if (is_home()) {
        lastWordAdUnit('home-top-billboard');
      } else {
    ?>
      <div class="ads-home-top-billboard TOP_Ad_sticky_billboard">
        <a href="https://placeholder.com"><img src="http://via.placeholder.com/970x250"></a>
      </div>
    <?php
      }
    ?>
    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                    <div class="logo">
                        <?php
                        $logotype = ot_get_option('logotype',1);
                        if(isset($logotype) && $logotype==1){
                            $logo = ot_get_option('logo');
                            if( $logo ){
                                ?>
                                <a class="" href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>">
                                    <img src="<?php echo $logo; ?>" alt="" />
                                </a>
                                <?php
                            } else {
                                ?>
                                <a class="" href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>">
                                    <img src="<?php echo THEME_PATH.'/images/Portfolio-Advisor-logo.svg' ?>" alt="" />
                                </a>
                            <?php }
                        }else{
                            $logotext   =   ot_get_option('logoText','logo');
                            ?>
                            <a class="" href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php echo $logotext; ?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
                    <div class="header-content">
                        <div class="header-top clearfix">
                            <div class="btn-sp">
                                <button><span></span></button>
                            </div>
                            <?php
                              if (is_home()) {
                                lastWordAdUnit('home-top-search');
                              } else {
                            ?>
                              <div class="ads-home-top-search Search_Ad">
                                  <a href="https://placeholder.com"><img src="http://via.placeholder.com/320x50"></a>
                              </div>
                            <?php
                              }
                            ?>
                            <div class="user-login">
                                <ul>
                                    <li>
                                        <a href="<?php echo home_url();?>/contact">
                                            <img style="visibility: hidden" src="<?php echo THEME_PATH.'/images/svg/Register-icon-grey.svg' ?>" alt="" /> Contact
                                        </a>
                                    </li>
                                    <?php
                                    if ( is_user_logged_in() ) { ?>
                                        <li>
                                            <a href="#">
                                                <img src="<?php echo THEME_PATH.'/images/svg/Sign-in-icon-grey.svg' ?>" alt="" /> My account
                                            </a>
                                        </li>
                                    <?php } else { ?>
                                        <li>
                                            <a href="<?php echo home_url();?>/register">
                                                <img src="<?php echo THEME_PATH.'/images/svg/Register-icon-grey.svg' ?>" alt="" /> Register
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#myModal">
                                                <img src="<?php echo THEME_PATH.'/images/svg/Sign-in-icon-grey.svg' ?>" alt="" /> Sign in
                                            </a>
                                        </li>
                                        <!-- Modal -->
                                        <div id="myModal" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                            <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h3 class="modal-title">SIGN IN</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo do_shortcode('[login-with-ajax]');?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                            </div>
                                            </div>
                                        </div>
                                    <?php }
                                    ?>
                                </ul>
                            </div>
                            <div class="social">
                                <?php if ( function_exists('cn_social_icon') ) echo cn_social_icon(); ?>
                            </div>

                        </div>

                        <nav id="primary-navigation" class="site-navigation" role="navigation">
                            <a class="home-url" href="<?php echo get_home_url(); ?>"></a>
                            <div class="primary-navigation">
                                <?php wp_nav_menu( array( 'theme_location' => 'main_nav', 'menu_class' => 'sf-menu sf-navbar' ) ); ?>
                            </div>
                             <div class="search-box">
                                 <?php get_search_form(); ?>
                             </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->

    <div id="main" class="site-main">
