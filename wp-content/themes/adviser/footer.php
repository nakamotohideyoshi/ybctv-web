<?php
/*
 * The template for displaying the footer
 */
?>

</div><!-- #main -->

<?php
  if (is_home()) {
    lastWordAdUnit('home-bottom-billboard');
  } else {
?>
  <div class="ads-home-bottom-billboard">
      <a href="https://placeholder.com"><img src="http://via.placeholder.com/970x250"></a>
  </div>
<?php
  }
?>
<section class="other-stories">
    <div class="container">
        <h2>OTHER STORIES FROM LAST WORD...</h2>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="content-image">
                    <img src="<?php echo THEME_PATH.'/images/assets/expertinvestor.png' ?>" alt="" />
                </div>
                <div class="content-des">
                    <p><a href="http://www.expertinvestoreurope.com/gallery/1037738/-term-economic-trends-ignore" target="_blank" title="Six long-term economic trends you should not ignore">Six long-term economic trends you...</a></p>
                    <p><a href="http://www.expertinvestoreurope.com/news/1037687/inflows-stall-emerging-market-funds-2017" target="_blank" title="Inflows stall across emerging market funds in first for 2017">Inflows stall across emerging market...</a></p>
                    <p><a href="http://www.expertinvestoreurope.com/news/1037723/strong-em-passive-fund-inflows-pressure-active-fees" target="_blank" title="Strong EM passive fund inflows pressure active fees">Strong EM passive fund inflows pressure...</a></p>
                    <p class="more_from"><a href="http://www.expertinvestoreurope.com" target="_blank">More News From EI</a></p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="content-image">
                    <img src="<?php echo THEME_PATH.'/images/assets/funselectorasia.png' ?>" alt="" />
                </div>
                <div class="content-des">
                    <p><a href="http://www.fundselectorasia.com/gallery/1037736/head-head-vs-partners" target="_blank" title="HEAD-TO-HEAD: First State vs Partners Group">HEAD-TO-HEAD: First State vs Partners...</a></p>
                    <p><a href="http://www.fundselectorasia.com/news/1037737/missed" target="_blank" title="In case you missed it...">In case you missed it...</a></p>
                    <p><a href="http://www.fundselectorasia.com/news/1037735/report-hnwis-stand-em-investors" target="_blank" title="Report: HNWIs stand out as EM investors">Report: HNWIs stand out as EM investors...</a></p>
                    <p class="more_from"><a href="http://www.fundselectorasia.com" target="_blank">More News From FSA</a></p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="content-image">
                    <img src="<?php echo THEME_PATH.'/images/assets/intrnational.png' ?>" alt="" />
                </div>
                <div class="content-des">
                    <p><a href="http://www.international-adviser.com/news/1037747/people-moves-jersey-finance-rowe-price-street" target="_blank" title="PEOPLE MOVES: Jersey Finance, T. Rowe Price, State Street">PEOPLE MOVES: Jersey Finance, T....</a></p>
                    <p><a href="http://www.international-adviser.com/news/1037743/hmrc-wins-bulk-tax-avoidance-challenges-loses-iht" target="_blank" title="HMRC wins bulk of tax avoidance challenges but loses IHT case">HMRC wins bulk of tax avoidance challenges...</a></p>
                    <p><a href="http://www.international-adviser.com/news/1037742/aviva-sells-stake-italian-insurance-business" target="_blank" title="Aviva sells 50% stake of Italian insurance business">Aviva sells 50% stake of Italian...</a></p>
                    <p class="more_from"><a href="http://international-adviser.com/" target="_blank">More News From IA</a></p>
                </div>
            </div>
        </div>
    </div>
</section>


<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container">
	    <div class="content-footer">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <div class="menu-footer clearfix">
                        <?php wp_nav_menu( array( 'theme_location' => 'main_footer', 'menu_class' => '' ) ); ?>
                    </div>
                    <div class="social clearfix">
                        <?php if ( function_exists('cn_social_icon') ) echo cn_social_icon(); ?>
                    </div>
                    <div class="footer_connect">
                    <h2>Portfolio Adviser</h2>
                    <p>Published by Last Word Media (UK) Limited, Fleet House, 1st Floor, 59-61 Clerkenwell Road, London, EC1M 5LA. Copyright (c) 2016. All rights reserved. Company Reg. No. 05573633. VAT. No. 872 411 728.&nbsp;ISSN 2397-284X</p>
                    <p>Portfolio Adviser is a monthly news magazine and daily news web site aimed at wealth managers , investment IFAs and other professional fund pickers and asset allocators in the UK and Channel Islands. No news, articles or content may be reproduced in part or in full without express permission of Portfolio Adviser.</p>
                    <!---->
                </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="logo-footer">
                        <img src="<?php echo THEME_PATH.'/images/assets/last-word.png' ?>" alt="" />
                    </div>
                </div>
            </div>
	    </div>
    </div>
</footer><!-- #colophon -->

<div id="back-to-top"></div>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
