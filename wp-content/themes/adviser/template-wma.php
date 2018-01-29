<?php
/*
 * Template name: WM Awards
 */

get_header(); ?>
<style>
  .ngg-pro-masonry {
    margin-left: 0;
  }
</style>
<section id="primary" class="content-area">
  <div id="content" class="site-content wma" role="main">
    <div class="content-page">
      <div class="container">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
          <div class="bread">
            <?php
              if(function_exists('bcn_display')) {
                bcn_display();
              }
            ?>
          </div>
          <?php
            if ( have_posts() ) : while (have_posts()) : the_post();
          ?>
          <div class="page-header">
            <div class="page-content"><?php the_content();?></div>
            <div class="galleryhead col-md-12">
                <div class="col-md-4 col-xs-12 col-sm-4 heading">
                  <h2>WINNERS</h2>
                </div>
                <div class="col-md-8 col-xs-12 col-sm-8 filterout">
                  <div class="filter">
                    <a class="links active" id="all">All</a>
                    <a class="links" id="gold">Gold</a>
                    <a class="links" id="marketing">Media Marketing</a>
                    <a class="links" id="platinum">Platinum</a> 
                  </div>
                </div>
              </div>
            <div class="gallery col-md-12 col-xs-12">
            <?php
              $args = array(
                'sort_order' => 'asc',
                'sort_column' => 'post_title',
                'post_parent' => 17088,
                'post_type' => 'page',
                'post_status' => 'publish'
              );

              $awardpages = get_posts($args);
            ?>

            <div class="card-columns">
                <?php 
                  foreach ($awardpages as $awardpage) { 
                  $thumb = get_the_post_thumbnail_url($awardpage->ID, 'medium');
                  $name_cat = get_field('award_category', $awardpage->ID);
                ?>
                <div class="card <?php echo $name_cat; ?>">
                    <a href="<?php echo get_permalink($awardpage->ID); ?>"><img src="<?php echo $thumb; ?>" width="100%" height="auto"></a>
                </div>
                <?php } ?>
              </div>
            </div>
          </div><!-- .page-header -->
          <?php
            endwhile;endif;
          ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 right-side-wrap">
          <?php get_sidebar('right');?>
        </div>
      </div>
    </div>
  </div><!-- #content -->
</section><!-- #primary -->



<script>
jQuery(document).ready( function ($) { 
  $( "#all" ).click(function() {
    $('.card').show("slow");
    $('.links').removeClass('active');
    $(this).addClass('active');
  });

  $( "#gold" ).click(function() {
    $('.platinum').hide("slow");
    $('.marketing').hide("slow");
    $('.gold').show("slow");
    $('.links').removeClass('active');
    $(this).addClass('active');
  });

  $( "#platinum" ).click(function() {
    $('.gold').hide("slow");
    $('.marketing').hide("slow");
    $('.platinum').show("slow");
    $('.links').removeClass('active');
    $(this).addClass('active');
  });
  
  $( "#marketing" ).click(function() {
    $('.gold').hide("slow");
    $('.platinum').hide("slow");
    $('.marketing').show("slow");
    $('.links').removeClass('active');
    $(this).addClass('active');
  });
});
</script>

<?php get_footer();?>