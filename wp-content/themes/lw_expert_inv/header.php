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

  <link rel="shortcut icon" href="<?php echo THEME_PATH.'/images/favicon/favicon.ico' ?>" type="image/x-icon">
  <link rel="icon" href="<?php echo THEME_PATH.'/images/favicon/EI_16x16.ico' ?>" sizes="16x16">
  <link rel="icon" href="<?php echo THEME_PATH.'/images/favicon/EI_32x32.ico' ?>" sizes="32x32">
  <link rel="icon" href="<?php echo THEME_PATH.'/images/favicon/EI_152x152.png' ?>" sizes="152x152">

  <title>
    <?php
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
  <!--stickadd scripts-->
    <script type='text/javascript' src='https://pa.cms-lastwordmedia.com/wp-content/themes/adviser/js/sticky.js?ver=1.0.0'></script>
  <?php
    wp_head();
    lastWordAdUnitInitialize(is_home() ? 0 : get_the_ID());
  ?>
</head>
<body id="bd" <?php body_class(); ?>>
  <?php lazyLoadStatus(); ?>
  <div id="page" class="hfeed site">
    <section class="ads-side-panels">
      <div class="container">
        <div class="side-panel-left-container">
          <div class="side-panel-left">
            <?php lastWordAdUnit('oop-lskin'); ?>
          </div>
        </div>
        <div class="side-panel-right-container">
          <div class="side-panel-right">
            <?php lastWordAdUnit('oop-rskin'); ?>
          </div>
        </div>
      </div>
    </section>
    <?php lastWordAdUnit('top-billboard'); ?>
    <header id="masthead" class="site-header" role="banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
            <div class="logo">
              <?php
                $logotype = ot_get_option('logotype',1);
                if(isset($logotype) && $logotype == 1) {
                  $logo = ot_get_option('logo');
                  if ($logo) {
              ?>
              <a class="" href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>">
                <img src="<?php echo $logo; ?>" alt="" />
              </a>
              <?php
                  } else {
              ?>
              <a class="" href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>">
                <img src="<?php echo THEME_PATH.'/images/Expert-investor-logo.svg' ?>" alt="" />
              </a>
              <?php
                  }
                } else {
                  $logotext = ot_get_option('logoText','logo');
              ?>
              <a class="" href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php echo $logotext; ?></a>
              <?php
                }
              ?>
            </div>
          </div>
          <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
            <div class="header-content">
              <div class="header-top clearfix">
                <div class="btn-sp">
                  <button id="togglemenu"><span></span></button>
                </div>
                <?php lastWordAdUnit('top-search'); ?>
                <div class="user-login">
                  <ul>
                    <li>
                      <a href="<?php echo home_url();?>/contact">
                        <img style="visibility: hidden" src="<?php echo THEME_PATH.'/images/svg/Register-icon-grey.svg' ?>" alt="" /> Contact
                      </a>
                    </li>
                    <?php
                      if (is_user_logged_in()) {
                    ?>
                    <li>
                      <a href="#">
                        <img src="<?php echo THEME_PATH.'/images/svg/Sign-in-icon-grey.svg' ?>" alt="" /> My account
                      </a>
                    </li>
                    <?php
                      } else {
                    ?>
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
                            <h2 class="modal-logo">EXPERT INVESTOR</h2>
                            <h3 class="modal-title">SIGN IN</h3>
                          </div>
                          <div class="modal-body">
                            <p>Access full content on the Expert Investor site, access your saved articles, control email preferences and amend your account details</p>
                            <?php echo do_shortcode('[login-with-ajax]');?>
                            <hr>
                            <a class="modal-link" href="/register">Not Registered?</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                      }
                    ?>
                  </ul>
                </div>
                <div class="social">
                  <a target="_blank" href="https://www.facebook.com/LastWordMedia">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 31 31">
                      <style type="text/css">
                       .st0{fill:none;stroke:#1D1D1B;stroke-miterlimit:10;}
                      </style>
                      <path d="M13.4 15.2h-1.6v-2.2h1.6v-1.5c0-0.7 0-1.7 0.5-2.3C14.4 8.5 15.1 8 16.3 8c2 0 2.8 0.3 2.8 0.3l-0.4 2.3c0 0-0.6-0.2-1.2-0.2s-1.1 0.2-1.1 0.8v1.8h2.5v0l-0.2 2.2h-2.3v7.8h-2.9"/><path class="st0" d="M15.5 0.5c-8.3 0-15 6.7-15 15s6.7 15 15 15 15-6.7 15-15C30.5 7.2 23.8 0.5 15.5 0.5z"/>
                    </svg>
                  </a>
                  <a target="_blank" href="https://www.linkedin.com/company/expert-investor-europe">
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
                  <a target="_blank" href="https://twitter.com/Expert_Investor">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 31 31">
                      <style type="text/css">
                       .st0{fill:none;stroke:#1D1D1B;stroke-miterlimit:10;}
                       .st1{fill:#1D1D1B;}
                      </style>
                      <path class="st0" d="M15.5 0.5c-8.3 0-15 6.7-15 15s6.7 15 15 15 15-6.7 15-15C30.5 7.2 23.8 0.5 15.5 0.5z"/>
                      <path class="st1" d="M21.5 13.2c0 0.1 0 0.3 0 0.4 0 4.1-3.1 8.8-8.8 8.8 -1.7 0-3.4-0.5-4.7-1.4 0.2 0 0.5 0 0.7 0 1.4 0 2.8-0.5 3.8-1.3 -1.3 0-2.5-0.9-2.9-2.1 0.2 0 0.4 0.1 0.6 0.1 0.3 0 0.6 0 0.8-0.1 -1.4-0.3-2.5-1.5-2.5-3v0C9 14.7 9.5 14.8 10 14.8c-0.8-0.6-1.4-1.5-1.4-2.6 0-0.6 0.2-1.1 0.4-1.6 1.5 1.9 3.8 3.1 6.4 3.2 -0.1-0.2-0.1-0.5-0.1-0.7 0-1.7 1.4-3.1 3.1-3.1 0.9 0 1.7 0.4 2.3 1 0.7-0.1 1.4-0.4 2-0.7 -0.2 0.7-0.7 1.3-1.4 1.7 0.6-0.1 1.2-0.2 1.8-0.5C22.6 12.2 22.1 12.7 21.5 13.2z"/>
                    </svg>
                  </a>
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
          <?php if(wp_is_mobile()) : ?>
               <nav id="primary-navigation" class="site-navigation mobnavigation col-xs-12 col-sm-12" role="navigation">
                <a class="home-url" href="<?php echo get_home_url(); ?>"></a>
                <div class="primary-navigation">
                  <?php wp_nav_menu( array( 'theme_location' => 'main_nav', 'menu_class' => 'sf-menu sf-navbar' ) ); ?>
                </div>
                <div class="search-box">
                  <?php get_search_form(); ?>
                </div>
                </nav>
            <?php endif; ?>
        </div>
      </div>
    </header><!-- #masthead -->
    <div id="main" class="site-main">
