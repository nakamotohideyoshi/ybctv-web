<?php
/*
 * The template for displaying the footer
 */
?>

</div><!-- #main -->

<?php lastWordAdUnit('bottom-billboard'); ?>
<section class="other-stories">
    <div class="container">
        <?php // Get RSS Feed(s)
            include_once( ABSPATH . WPINC . '/feed.php' );
            $rssFsa = fetch_feed( 'https://fsa.cms-lastwordmedia.com/feed/' );
            $rssEi = fetch_feed( 'https://ei.cms-lastwordmedia.com/feed/' );
            $rssIa = fetch_feed( 'https://ia.cms-lastwordmedia.com/feed/' );
        ?>

        <h2>OTHER STORIES FROM LAST WORD...</h2>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="content-image">
                    <img src="<?php echo THEME_PATH.'/images/assets/expertinvestor.png' ?>" alt="" />
                </div>
                <div class="content-des">
                    <?php echo customFeed($rssEi); ?>
                    <p class="more_from"><a href="http://www.expertinvestoreurope.com" target="_blank">More news from EI</a></p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="content-image">
                    <img src="<?php echo THEME_PATH.'/images/assets/funselectorasia.png' ?>" alt="" />
                </div>
                <div class="content-des">
                    <?php echo customFeed($rssFsa); ?>
                    <p class="more_from"><a href="http://www.fundselectorasia.com" target="_blank">More news from FSA</a></p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="content-image">
                    <img src="<?php echo THEME_PATH.'/images/assets/intrnational.png' ?>" alt="" />
                </div>
                <div class="content-des">
                    <?php echo customFeed($rssIa); ?>
                    <p class="more_from"><a href="http://international-adviser.com/" target="_blank">More news from IA</a></p>
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
                    <h2>Portfolio Adviser</h2>
                    <p>Published by Last Word Media (UK) Limited, Fleet House, 1st Floor, 59-61 Clerkenwell Road, London, EC1M 5LA. Copyright (c) <?php echo date('Y'); ?>. All rights reserved. Company Reg. No. 05573633. VAT. No. 872 411 728.&nbsp;ISSN 2397-284X</p>
                    <p>Portfolio Adviser is a monthly news magazine and daily news web site aimed at wealth managers , investment IFAs and other professional fund pickers and asset allocators in the UK and Channel Islands. No news, articles or content may be reproduced in part or in full without express permission of Portfolio Adviser.</p>
                    <!---->
                </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="logo-footer">
                        <a href="https://lastwordmedia.com" target="_blank" title="Last Word">
                            <img src="<?php echo THEME_PATH.'/images/assets/last-word.png' ?>" alt="" />
                        </a>
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

<?php brightcove2_footer(); ?>

<?php wp_footer(); ?>
</body>
</html>
