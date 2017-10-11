<?php
/**
 * Template Name: Premium Content
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
                  //var_dump($category_page);
                  $args = array(
                    'posts_per_page' => 20,
                    'category__in' => array( $category_page ),
                    'category' => $category_page,
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                          'taxonomy' => 'category',
                          'field' => 'id',
                          'terms' => array( 2135 ),
                          'operator' => 'AND'
                        )
                    ),
                    /*'meta_query' => array(
                         array(
                             'key' => 'lw_premium',
                             'value' => 'yes',
                             'compare' => '=',
                         )
                     )*/
                  );
                  $myposts = get_posts( $args );
                  foreach ( $myposts as $post ) : setup_postdata( $post );
                    //echo 'id'.$post->ID;
                    //$isPremium = get_post_meta($post->ID,'lw_premium');
                    //var_dump(get_post_meta($post->ID));
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
                      <div class="content-des <?php echo ((!is_user_logged_in())) ? 'contlocked':'';?>">
                        <p class="name-cat">
                          <?php
                            $category = get_the_category();
                            $terms = wp_get_post_terms( get_the_ID(), 'type');
                            $type = $terms[0]->name;
                          ?>
                            <a href="<?php echo get_category_link($category[0]->cat_ID);?>">
                              <?php if(!is_user_logged_in() ): ?>
                                  <img src="<?php echo THEME_PATH.'/images/assets/padlock-small.svg' ?>" />
                                <?php endif; ?>
                            <?php echo $category[0]->cat_name;?></a>
                            <?php if($type): ?>
                              <a href="<?php echo get_term_link($terms[0]->term_id);?>">
                                <?php if($category[0]->cat_name){
                                  echo ' | ';
                                }?>
                                <?php echo $type; ?>
                              </a>
                            <?php endif; ?>
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
                    if ($row_count % 2 == 0) echo '</div><div class="row row-eq-height">';
                  endforeach;
                  wp_reset_postdata();
                ?>
              </div>
            </div>
            <div class="list-category-ajax">
              <?php
                $category_page = get_post_meta($post->ID,'category_page', TRUE);
                  //var_dump($category_page);
                  $args = array(
                    'posts_per_page' => 5,
                    'offset' => 20,
                    'category' => $category_page,
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'meta_query' => array(
                         array(
                             'key' => 'lw_premium',
                             'value' => 'yes',
                             'compare' => '=',
                         )
                     )
                  );
                $myposts = get_posts( $args );
                foreach ( $myposts as $post ) : setup_postdata( $post );
                  get_template_part('template-parts/archive', 'post');
                endforeach;
                wp_reset_postdata();
              ?>
            </div>
            <a href="#" class="view-more hidden view-more-ajax" meta_key="lw_premium" meta_val="yes" page="2" offset="20" category="<?php echo $category_page;?>">View more</a>
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
