<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
<?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
<?php // Get RSS Feed(s)
            include_once( ABSPATH . WPINC . '/feed.php' );
            $rssFsa = fetch_feed( 'https://fsa.cms-lastwordmedia.com/feed/' );
            $rssEi = fetch_feed( 'https://ei.cms-lastwordmedia.com/feed/' );
            $rssIa = fetch_feed( 'https://ia.cms-lastwordmedia.com/feed/' );
        ?>
<?php lastWordAdUnit2('bottom-billboard'); ?>        
<div class="col-md-12 footer-other">
<h2>OTHER STORIES FROM LAST WORD...</h2>
</div>
<div class="col-md-9">
 <div class="row foot">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="content-image">
                    <img src="<?php bloginfo('template_directory'); ?>/inc/assets/img/expertinvestor.png" alt="" />
                </div>
                <div class="content-des">
                    <?php echo customFeed($rssEi); ?>

					<button type="button" class="btn btn-newsletter btn-foot">
					<a href="http://international-adviser.com/" target="_blank"><a href="http://www.expertinvestoreurope.com" target="_blank">More news from EI</a></a>
					</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="content-image">
                    <img src="<?php bloginfo('template_directory'); ?>/inc/assets/img/funselectorasia.png" alt="" />
                </div>
                <div class="content-des">
                    <?php echo customFeed($rssFsa); ?>

					<button type="button" class="btn btn-newsletter btn-foot">
					<a href="http://www.fundselectorasia.com" target="_blank">More news from FSA</a>
					</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="content-image">
                    <img src="<?php bloginfo('template_directory'); ?>/inc/assets/img/intrnational.png" alt="" />
                </div>
                <div class="content-des">
                    <?php echo customFeed($rssIa); ?>
					<button type="button" class="btn btn-newsletter btn-foot">
					<a href="http://international-adviser.com/" target="_blank">More news from IA</a>
					</button>

                </div>
            </div>
        </div></div>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #content -->
    <?php get_template_part( 'footer-widget' ); ?>
	<footer id="colophon" class="site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
		<div class="container pt-3 pb-3">
            <div class="content-footer">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <div class="menu-footer clearfix">
                       <?php wp_nav_menu( array( 'theme_location' => 'main_footer' ) ); ?>
                    </div>

                    <div class="footer_connect">
                    <h2>Portfolio<br> Adviser</h2>
                    <p>Published by Last Word Media (UK) Limited, Fleet House, 1st Floor, 59-61 Clerkenwell Road, London, EC1M 5LA. Copyright (c) <?php echo date('Y'); ?>. All rights reserved. Company Reg. No. 05573633. VAT. No. 872 411 728.&nbsp;ISSN 2397-284X</p>
                    <p>Portfolio Adviser is a monthly news magazine and daily news web site aimed at wealth managers , investment IFAs and other professional fund pickers and asset allocators in the UK and Channel Islands. No news, articles or content may be reproduced in part or in full without express permission of Portfolio Adviser.</p>
                    <!---->
                </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<div class="social clearfix">
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
                </div></div>
                    </div>
                    <div class="logo-footer">
                        <a href="https://lastwordmedia.com" target="_blank" title="Last Word">
                            <img src="<?php bloginfo('template_directory'); ?>/inc/assets/img/last-word.png" alt="" />
                        </a>
                    </div>
                </div>
            </div>
	    </div><!-- close footer-info -->
		</div>
	</footer><!-- #colophon -->
<?php endif; ?>
</div><!-- #page -->
<?php echo brightcove2_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>
