<?php
/*
 * The template for displaying the footer
 */
?>

</div><!-- #main -->

<?php lastWordAdUnit('bottom-billboard'); ?>
<section class="other-stories">
    <div class="container">
        <h2>OTHER STORIES FROM LAST WORD...</h2>
        <div class="row">
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
                    <img src="<?php echo THEME_PATH.'/images/assets/portfolio.png' ?>" alt="" />
                </div>
                <div class="content-des">
                    <p><a href="http://www.portfolio-adviser.com/news/1037929/woodford-apologises-incredibly-painful-underperformance" target="_blank" title="Woodford apologises for 'incredibly painful' underperformance">Woodford apologises for 'incredibly painful' un...</a></p>
                    <p><a href="http://www.portfolio-adviser.com/analysis/1037926/pa-analysis-hey-fund-selectors-wheres-value-add" target="_blank" title="PA ANALYSIS: Hey, fund selectors - where's the value add?">PA ANALYSIS: Hey, fund selectors...</a></p>
                    <p><a href="http://www.portfolio-adviser.com/news/1037924/jupiter-expands-gem-range-short-duration-bond-fund" target="_blank" title="Jupiter expands GEM range with short-duration bond fund">Jupiter expands GEM range...</a></p>
                    <p class="more_from"><a href="http://portfolio-adviser.com/" target="_blank">More News From PA</a></p>
                </div>
            </div>
        </div>
    </div>
</section>


<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container">
        <div class="content-footer">
            <div class="row row-eq-height">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <div class="menu-footer clearfix">
                        <?php wp_nav_menu( array( 'theme_location' => 'main_footer', 'menu_class' => '' ) ); ?>
                    </div>
                    <div class="social clearfix">
                        <?php if ( function_exists('cn_social_icon') ) echo cn_social_icon(); ?>
                    </div>
                    <div class="footer_connect">
                    <h2>Fund Selector Asia</h2>
                    <p>Published by Last Word Media (HK) Ltd, Suite 2003, 20/F Capitol Centre 1, 5-19 Jardine's Bazaar, Causeway Bay, Hong Kong, SAR. Copyright (c) 2016. All rights reserved. Company Reg. No. 2127095.</p>

                    <p>Fund Selector Asia provides up-to-the minute news, tools and professional resources for fund selectors, fund analysts, fund influencers, wealth management heads, investment councillors, heads of sales and client-facing wealth advisers throughout English-speaking Asia. No news, articles or content may be reproduced in part or in full without express permission of Fund Selector Asia.</p>
                    <p>Nothing in this publication amounts to a personal recommendation or endorsement. The material contained in this publication is intended for information only and does not constitute the provision of advice. Neither the writer nor the publisher accepts any responsibility for any loss or damage caused by any use of or reliance on the opinions or views expressed in the publication Fund Selector Asia</p>
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
<?php /*
<script>

    var form = jQuery("#example-advanced-form").show();
 
    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex)
            {
                return true;
            }
            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && Number(jQuery("#age-2").val()) < 18)
            {
                return false;
            }
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex)
            {
                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex)
        {
            // Used to skip the "Warning" step if the user is old enough.
            if (currentIndex === 2 && Number(jQuery("#age-2").val()) >= 18)
            {
                form.steps("next");
            }
            // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
            if (currentIndex === 2 && priorIndex === 3)
            {
                form.steps("previous");
            }
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            alert("Submitted!");
        }
    });

</script>
*/ ?>
<?php wp_footer(); ?>
</body>
</html>
