<?php
/**
 * This is 404 page
 */
get_header();

?>

<div id="main-content" class="main-content">

    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <div class="content-page">
                <div class="container">
                    <div id="error-header"><?php echo ot_get_option('404_page_content'); ?></div>
                    <header class="page-header">
                        <h1 class="page-title"><?php _e( 'Not Found', TEXT_DOMAIN ); ?></h1>
                    </header>

                    <div class="page-content">
                        <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', TEXT_DOMAIN ); ?></p>

                        <?php get_search_form(); ?>

                        <a href="<?php echo home_url(); ?>" title="<?php echo __('Go to the Home Page', TEXT_DOMAIN); ?>"><?php echo __('Go to the Home Page', TEXT_DOMAIN); ?></a>
                    </div><!-- .page-content -->
                </div>
            </div>
        </div><!-- #content -->
    </div><!-- #primary -->
</div><!-- #main-content -->

<?php get_footer();?>

</body>
</html>