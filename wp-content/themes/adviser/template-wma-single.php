<?php
/*
 * Template name: WM Awards Single
 */

get_header(); ?>
<section id="primary" class="content-area">
  <div id="content" class="site-content" role="main">
    <div class="content-page wmasingle">
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
            <?php 

              $args = array(
                'sort_order' => 'asc',
                'sort_column' => 'post_title',
                'child_of' => 17088,
                'post_type' => 'page',
                'post_status' => 'publish'
              );

              $awardpages = get_pages($args);
              $awpagesarray = array();
              foreach ($awardpages as $awardpage) {
                array_push($awpagesarray, $awardpage->ID);
              }

              $curid = get_the_ID();
              $curkey = array_search($curid, $awpagesarray);
              
              $prevkey = $curkey - 1;
              $nextkey = $curkey + 1;

              $previous = $awpagesarray[$prevkey];
              $next = $awpagesarray[$nextkey];

              $awardscount = count($awpagesarray) - 1;

            ?> 
            <div class="featured-image col-md-12">
              <?php the_post_thumbnail(); ?>
              <div class="description">
              <div class="col-md-12 page-title"><h2><?php the_title();?><h2></div>
              <div class="col-md-12 page-content"><?php the_content();?></div>
            </div>

            </div>
            <div class="nextprev">
            <?php if ($prevkey >= 0) { ?>
              <div class="col-md-6 col-xs-6 pull-left awnav prev"><a href="<?php echo get_permalink($previous); ?>"><i class="fa fa-chevron-left"></i> PREVIOUS</a></div>
            <?php } ?>

            <?php if ($nextkey <= $awardscount) { ?>
              <div class="col-md-6 col-xs-6 pull-right awnav next"><a href="<?php echo get_permalink($next); ?>">NEXT <i class="fa fa-chevron-right"></i></a></div>
            <?php } ?>
            </div>
            <div class="awnavigation">             
              <div class="col-md-12 col-xs-0 items">
                <?php 
                  foreach ($awardpages as $awardpage) { 
                  $thumb = get_the_post_thumbnail_url($awardpage->ID, 'thumbnail');
                ?>
                    <a href="<?php echo get_permalink($awardpage->ID); ?>"><img src="<?php echo $thumb; ?>" width="75px" height="75px"></a>
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

<?php get_footer();?>