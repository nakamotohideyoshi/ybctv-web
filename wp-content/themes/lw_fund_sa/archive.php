<?php
/*
 * The template for displaying Archive pages
 */

get_header(); ?>

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
          <div class="content-category">
            <?php
              $cat_obj = get_queried_object();
              $cat_id = $cat_obj->term_id;
              $cat_title = single_cat_title('',false );
              $category = get_the_category();
              $category_id = $category[0]->cat_ID;
              if ( have_posts() ) :
            ?>
            <div class="page-header">
              <h1 class="page-title"><?php printf( __( '%s', TEXT_DOMAIN ), single_cat_title('',false )); ?></h1>
              <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
            </div><!-- .page-header -->
            <?php
              endif;
            ?>
            <div class="list-category-ajax">
              <?php
                if(have_posts()): while(have_posts()): the_post();
                  include(locate_template('template-parts/archive-post.php'));
                endwhile;endif;
                ?>
            </div>
            <?php if(empty($category_id)){
                            $category_id = get_the_category()[0]->term_id;
                        };?>
            <?php 
            $post_type = get_queried_object();
            if($post_type && $post_type->term_id == 2440 || $post_type->term_id == 2438): //type video and gallery
               $term_id = $post_type->term_id; ?>
               <a href="#" class="view-more view-more-ajax" term_id="<?php echo $term_id; ?>" page="2" offset="0" category="<?php echo $category_id; ?>">View more</a>  
            <?php else: ?>
              <a href="#" class="view-more view-more-ajax" page="2" offset="0" category="<?php echo $category_id; ?>">View more</a>
            <?php endif; ?> 
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-md-offset-1 col-sm-12 col-xs-12 right-side-wrap">
          <?php get_sidebar('right');?>
        </div>
      </div>
    </div>
  </div><!-- #content -->
</section><!-- #primary -->

<?php get_footer(); ?>
