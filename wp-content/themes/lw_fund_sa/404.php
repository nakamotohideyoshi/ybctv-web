<?php
/**
 * This is 404 page
 */
get_header();

$the_page    = null;
$errorpageid = get_option( '404pageid', 0 ); 
if ($errorpageid !== 0) {
    // Typecast to an integer
    $errorpageid = (int) $errorpageid;
    // Get our page
    $the_page = get_page($errorpageid);
}
?>
<section id="primary" class="content-area">
  <div id="content" class="site-content" role="main">
    <div class="content-page">
      <div class="container">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <div class="content-left">
            <?php get_sidebar('left');?>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="bread">
            <?php
              if(function_exists('bcn_display')) {
                bcn_display();
              }
            ?>
          </div>
            <div class="page-content">
                <div id="error-header">
                    <?php if ($the_page == NULL || isset($the_page->post_content) && trim($the_page->post_content == '')): ?>
                    <?php echo ot_get_option('404_page_content'); ?>
                    <?php else: ?>
                    <?php echo apply_filters( 'the_content', $the_page->post_content ); ?>
                    <?php endif; ?>
                </div>
                <div class="four-o-four-search-form">
                     <?php get_search_form(); ?>
                </div>
                <a href="<?php echo home_url(); ?>" title="<?php echo __('Go to the Home Page', TEXT_DOMAIN); ?>"><?php echo __('Go to the Home Page', TEXT_DOMAIN); ?></a>
            </div><!-- .page-content -->
        </div>
        <div class="col-lg-3 col-md-3 col-md-offset-1 col-sm-12 col-xs-12 right-side-wrap">
          <?php get_sidebar('right');?>
        </div>
      </div>
    </div>
  </div><!-- #content -->
</section><!-- #primary -->


<?php get_footer();?>

</body>
</html>