<?php
/**
 * Template Name: Magazine
 */
?>
<?php get_header();?>
<section id="primary" class="content-area">
  <div id="content" class="site-content" role="main">
    <div class="content-page">
      <div class="container">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <div class="content-left">
            <?php get_sidebar('left');?>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="bread">
            <?php
              if (function_exists('bcn_display')) {
                bcn_display();
              }
            ?>
          </div>
          <div class="list-content-page">
            <?php
              if ( have_posts() ) : while (have_posts()) : the_post();
            ?>
            <div class="page-header">
              <h1 class="page-title"><?php the_title();?></h1>
              <div class="page-description"><?php the_content();?></div>
            </div><!-- .page-header -->
            <?php endwhile;endif;?>
            <div class="list-magazines">
              <?php
                query_posts(array('showposts' => 1,'post_type' =>'magazine'));
                if (have_posts()) : while (have_posts()) : the_post();
              ?>
              <div class="loop-list">
                <div class="row">
                  <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="content-image">
                      <?php
                        if ( has_post_thumbnail() ) {
                          echo '<a href="' . get_the_permalink() . '">';
                            the_post_thumbnail();
                          echo '</a>';
                        }
                        else {
                      ?>
                      <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
                      <?php
                        }
                      ?>
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="content-des">
                      <p class="name-cat">Expert Investor Magazine</p>
                      <a href="<?php the_permalink();?>"><h2><?php echo get_the_title(); ?></h2></a>
                      <p><?php echo get_excerpt(100); ?></p>
                      <p class="date">Published <?php the_time('j M y');?></p>
                    </div>
                  </div>
                </div>
              </div>
              <?php
                endwhile;endif;
                wp_reset_query();
              ?>
            </div>
            <div class="list-magazines-ajax">
              <?php
                query_posts(array('offset'=>1,'post_type' =>'magazine'));

                if (have_posts()) : while (have_posts()) : the_post();
              ?>
              <div class="loop-list">
                <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="content-image">
                      <?php
                        if ( has_post_thumbnail() ) {
                          echo '<a href="' . get_the_permalink() . '">';
                          the_post_thumbnail();
                          echo '</a>';
                        }
                        else {
                      ?>
                      <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
                      <?php
                        }
                      ?>
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="content-des">
                      <p class="name-cat">Expert Investor Magazine</p>
                      <a href="<?php the_permalink();?>"><h3><?php echo get_the_title(); ?></h3></a>
                      <p><?php echo get_excerpt(100); ?></p>
                      <p class="date">Published <?php the_time('j M y');?></p>
                    </div>
                  </div>
                </div>
              </div>
              <?php
                endwhile;endif;
                wp_reset_query();
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <?php get_sidebar('right');?>
        </div>
      </div>
    </div>
  </div><!-- #content -->
</section><!-- #primary -->
<?php get_footer();?>
