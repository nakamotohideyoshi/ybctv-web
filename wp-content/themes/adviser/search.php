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
              <?php 
              //query_posts(array('posts_per_page' => 5));
              if(have_posts()): while(have_posts()): the_post();

                get_template_part('template-parts/archive', 'search');

              endwhile;endif;?>
            </div>
            <?php 
              $queryStringPre = $_GET['s'];
              $queryString = stripslashes(str_replace( '"', '', $queryStringPre ));
            ?>
            <?php the_posts_navigation(); ?>
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
