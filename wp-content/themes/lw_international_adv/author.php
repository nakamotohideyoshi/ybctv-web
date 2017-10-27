<?php
/*
 * The template for displaying Author archive pages
 */

get_header(); ?>

<?php get_header();?>
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
            <?php if(function_exists('bcn_display'))
              {
                bcn_display();
              }
            ?>
          </div>
        <div class="list-content-page">
          <div class="author-info">
            <div class="author-avatar clearfix">
              <?php echo get_avatar( get_the_author_meta('user_email'), $size = '80');  ?>
              <h2 class="author-title"><?php echo get_the_author(); ?></h2>
              <p class="author-job-title"><?php echo get_the_author_meta('lw_title'); ?></p>
            </div>
          <div class="author-description">
            <p class="author-bio">
              <?php the_author_meta( 'description' ); ?>
            </p>
          </div>
          <div class="like_button clearfix">
            <?php
              $email = get_the_author_meta('user_email');
              if ($email) {
              ?>
                <div class="Email">
                  <a href="mailto:<?php echo $email; ?>"<i class="fa fa-envelope" aria-hidden="true"></i></a>
                </div>
              <?php
              }

              $twitter = get_the_author_meta('lw_twitter_username');
              if ($twitter) {
              ?>
                <div class="TwitterButton">
                  <a target="_blank" href="https://twitter.com/<?php echo $twitter; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </div>
              <?php
              }

              $linkedin = get_the_author_meta('lw_linkedin_url');
              if ($linkedin) {
              ?>
                <div class="In">
                  <a target="_blank" href="<?php echo $linkedin; ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </div>
              <?php
              }
            ?>
          </div>
        </div>
        <?php $count = 0; ?>
        <div class="list-category">
          <div class="row">
            <?php 
              $authorID = get_the_author_meta('ID');
              query_posts('orderby=date&order=DESC&posts_per_page=2&author=$authorID'); 
              if(have_posts()): while(have_posts()): the_post(); $count++;
                //if ($count <= 2) {
            ?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="loop-list">
                    <div class="content-image">
                      <?php
                        if ( has_post_thumbnail() ) {
                          the_post_thumbnail();
                        }
                        else {
                      ?>
                      <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
                      <?php
                        }
                      ?>
                    </div>
                    <div class="content-des">
                      <p class="name-cat">
                        <?php $category = get_the_category(); ?>
                        <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                        <span><?php the_time('j M y');?></span>
                      </p>
                      <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                      <p><?php echo the_excerpt(); ?></p>
                    </div>
                  </div>
                </div>
                <?php
                  //}

                  endwhile;endif;
                  wp_reset_query();
                ?>
              </div>
            </div>
            <?php $count = 0; ?>
            <div class="list-category-ajax">
              <?php

                query_posts('offset=2&orderby=date&order=DESC&posts_per_page=3&author=$authorID'); 
                if(have_posts()): while(have_posts()): the_post(); $count++;
                  //if ($count > 2) {
                    include(locate_template('template-parts/archive-author.php'));
                //}
                endwhile;endif;
               wp_reset_query();
              ?>
            </div>
            <a href="#" class="view-more view-more-ajax author-ajax" page="0" offset="5" author_id="<?php echo $authorID;?>">View more</a>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-md-offset-1 col-sm-12 col-xs-12 right-side-wrap">
          <?php get_sidebar('right');?>
        </div>
      </div>
    </div>
  </div><!-- #content -->
</section><!-- #primary -->

<?php get_footer();?>
