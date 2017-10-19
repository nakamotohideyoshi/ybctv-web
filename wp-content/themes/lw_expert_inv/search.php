<?php
/*
 * The template for displaying Search Results pages
 */

get_header(); ?>

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
              if(function_exists('bcn_display')) {
                bcn_display();
              }
            ?>
          </div>
          <div class="content-category">
            <?php if ( have_posts() ) : ?>
              <div class="page-header">
                <h1 class="page-title"><?php printf( __( 'Search Results: %s', TEXT_DOMAIN ), get_search_query() ); ?></h1>
              </div><!-- .page-header -->
            <?php endif; ?>
            <div class="list-category-ajax">
              <?php if(have_posts()): while(have_posts()): the_post(); ?>
              <div class="loop-list loop-list-load">
                <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="content-image">
                      <?php
                        if ( has_post_thumbnail() ) {
                          the_post_thumbnail('listing-article');
                        }
                        else {
                      ?>
                      <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
                      <?php
                        }
                      ?>
                      <span class="overlay"></span>
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="content-des">
                      <p class="name-cat">
                        <?php $category = get_the_category(); ?>
                        <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                        <span><?php the_time('j M y');?></span>
                      </p>
                      <a href="<?php the_permalink(); ?>"><h3><?php the_title();?></h3></a>
                      <p><?php echo the_excerpt(); ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <?php endwhile;endif;?>
              <a href="#" class="view-more">View more</a>
            </div>
            <div class="page-navi">
            </div>
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
