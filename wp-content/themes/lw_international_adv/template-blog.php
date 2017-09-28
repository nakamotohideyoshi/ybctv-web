<?php
/**
 * Template Name: Blog
 */
?>
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
            <?php
              if (function_exists('bcn_display')) {
                bcn_display();
              }
            ?>
          </div>
          <div class="list-content-page">
            <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
            <div class="page-header">
              <h1 class="page-title"><?php the_title();?></h1>
              <div class="page-description"><?php the_content();?></div>
            </div><!-- .page-header -->
            <?php endwhile;endif;?>
            <div class="list-category">
              <h2><?php the_title();?> Spotlight</h2>
              <?php
                $row_count = 0;
              ?>
              <div class="row row-eq-height">
                <?php
                  $category_page = get_post_meta($post->ID,'category_page', TRUE);
                  $args = array(
                    'posts_per_page' => 4,
                    'category' => $category_page,
                    'orderby' => 'date',
                    'order' => 'DESC'
                  );
                  $myposts = get_posts( $args );
                  foreach ( $myposts as $post ) : setup_postdata( $post );
                ?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="loop-list">
                    <div class="loop-list-content-wrapper">
                      <?php
                       $isVideo = get_post_meta($post->ID,'lw_primary_medium')[0];
                      ?>
                      <div class="content-image <?php echo ($isVideo == 'video' ? 'has-video': '');?>">
                        <?php
                          if ( has_post_thumbnail() ) {
                            echo '<a href="' . get_the_permalink() . '">';
                            the_post_thumbnail('section-article');
                            echo ($isVideo == 'video' ? '<div class="voverlay"></div>': '');
                            echo '</a>';
                          }
                          else {
                        ?>
                        <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" />
                          <?php echo ($isVideo == 'video' ? '<div class="voverlay"></div>': ''); ?>
                        </a>
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
                        <p><?php the_excerpt(); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                    $row_count ++;
                    if ($row_count % 2 == 0  && $row_count != 4) echo '</div><div class="row row-eq-height">';
                  endforeach;
                  wp_reset_postdata();
                ?>
              </div>
            </div>
            <div class="list-category-ajax">
              <?php
                $category_page = get_post_meta($post->ID,'category_page', TRUE);
                $args = array(
                  'offset' => 4,
                  'category' => $category_page,
                  'posts_per_page' => 5
                );
                $myposts = get_posts( $args );
                foreach ( $myposts as $post ) : setup_postdata( $post );
                  get_template_part('template-parts/archive', 'post');
                endforeach;
                wp_reset_postdata();
              ?>
            </div>
            <a href="#" class="view-more view-more-ajax" page="2" offset="4" category="<?php echo $category_page; ?>">View more</a>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-md-offset-1 col-sm-12 col-xs-12">
          <?php get_sidebar('right');?>
        </div>
      </div>
    </div>
  </div><!-- #content -->
</section><!-- #primary -->
<?php get_footer();?>
