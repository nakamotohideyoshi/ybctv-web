<?php
/*
 * The Template for displaying all single posts
 */

get_header(); ?>

<section id="primary" class="content-area">
  <div id="content" class="site-content" role="main">
    <div class="content-page">
      <div class="container">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <div class="content-left">
            <div class="most-popular most-popular-new">
              <h2>Most Popular News</h2>
              <?php lastWordAdUnit('top-news-ad'); ?>
              <div class="list-most-popular">
                <?php
                  $popularpost = new WP_Query( array( 'posts_per_page' => 3, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );
                  while ( $popularpost->have_posts() ) : $popularpost->the_post();
                ?>
                <div class="loop-list">
                  <div class="content-image">
                    <?php
                      if ( has_post_thumbnail() ) {
                        the_post_thumbnail('popular-article');
                      }
                      else {
                    ?>
                    <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
                    <?php
                      }
                    ?>
                    <span class="overlay"></span>
                  </div>
                  <div class="content-des">
                    <p class="name-cat">
                      <?php $category = get_the_category(); ?>
                      <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                    </p>
                    <a href="<?php the_permalink(); ?>"><h3><?php the_title();?></h3></a>
                  </div>
                </div>
                <?php
                  endwhile;
                  wp_reset_postdata();
                ?>
              </div>
            </div>
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
          <div class="content-magazine content-single">
            <?php if(have_posts()): while(have_posts()): the_post(); ?>
            <p class="name-cat">Portfolio Adviser Magazine</p>
            <h1 class="title-single"><?php the_title();?></h1>
            <div class="content-post">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="thump-single">
                    <?php
                      if ( has_post_thumbnail() ) {
                        the_post_thumbnail();
                      }
                      else {
                    ?>
                    <img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" />
                    <?php
                      }
                    ?>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <strong>In the latest edition:</strong>
                  <?php the_content();?>
                  <a target="_blank" class="readmore readmore-new" href="<?php echo $post->lw_magazine_link; ?>">View digital edition <img src="https://pa.cms-lastwordmedia.com/wp-content/themes/adviser/images/assets/Arrow-More-news.svg" alt="" id="exifviewer-img-2" exifid="-614362903" oldsrc="https://pa.cms-lastwordmedia.com/wp-content/themes/adviser/images/assets/Arrow-More-news.svg"></a>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="magazine-optimum">For optimum viewing experience, please use the following browsers: Chrome, Firefox or Safari.</div>
                </div>
              </div>
            </div>
            <a href="/magazines" class="view-more-btn">View all magazines</a>
            <div class="comment-post">
              <?php
                if ( comments_open() || get_comments_number() ) :
                  comments_template();
                endif;
              ?>
            </div>
            <?php
              endwhile;endif;
            ?>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 right-side-wrap">
          <?php get_sidebar('right');?>
        </div>
      </div>
    </div>
  </div><!-- #content -->
</section><!-- #primary -->

<?php get_footer();?>
