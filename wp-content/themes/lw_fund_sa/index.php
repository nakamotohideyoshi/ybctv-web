<?php
/*
 * The main template file
 */

get_header(); ?>

<section id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <section class="all-new-analysis">
      <div class="container">
        <div class="row">
          <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="box-new">
              <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                  <div class="last-new">
                    <h2 class="title toptitle" style="visibility: hidden">Last New</h2>
                    <?php
                      $args = array( 'posts_per_page' => 1,'showposts' => 1, 'category' => 17 );
                      $myposts = get_posts( $args );
                      foreach ( $myposts as $post ) : setup_postdata( $post );
                    ?>
                      <div class="first-last-new clearfix">
                        <div class="content-image">
                          <?php
                            if ( has_post_thumbnail() ) {
                              the_post_thumbnail('homepage-latest-article');
                            }
                            else { ?>
                              <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
                          <?php
                            }
                          ?>
                          <span class="overlay"></span>
                        </div>
                        <div class="content-des">
                          <h2 class="title">TOP STORIES...</h2>
                          <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                          <p><?php the_excerpt(); ?></p>
                        </div>
                      </div>
                    <?php
                      endforeach;
                      wp_reset_postdata();
                    ?>
                    <div class="list-last-new">
                      <div class="row">
                      <?php
                        $count =0;
                        $args = array( 'posts_per_page' => 6,'offset' => 1,'showposts' => 6, 'category' => 17 );
                        $myposts = get_posts( $args );
                        foreach ( $myposts as $post ) : setup_postdata( $post ); $count++;
                          if ($count == 2) {
                        ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                          <div class="loop-list clearfix">
                            <?php lastWordAdUnit('top-news-ad'); ?>
                          </div>
                        </div>
                        <?php
                          } else {
                        ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                          <div class="loop-list clearfix">
                            <div class="content-image">
                            <?php
                              if ( has_post_thumbnail() ) {
                                the_post_thumbnail('thumbnail-article');
                              }
                              else {
                            ?>
                            <a href="<?php the_permalink();?>">
                              <img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" />
                            </a>
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
                            <a href="<?php the_permalink(); ?>">
                              <h3><?php echo get_the_title(); ?></h3>
                            </a>
                          </div>
                        </div>
                      </div>
                      <?php
                        }
                        endforeach;
                        wp_reset_postdata();
                      ?>
                    </div>
                    <a class="readmore readmore-new" href="<?php echo get_category_link( "17" ); ?>">Read more news <img src="<?php echo THEME_PATH.'/images/assets/Arrow-More-news.svg' ?>" alt="" /></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="most-viewed">
                  <h2 class="title">MOST VIEWED</h2>
                    <div class="list-most-viewed">
                    <?php
                      $args = array( 'posts_per_page' => 5,'showposts' => 5, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC' );
                      $myposts = get_posts( $args );
                      $popcounter = 1;
                      foreach ( $myposts as $post ) : setup_postdata( $post );
                    ?>
                      <div class="loop-list">
                        <div class="content-des">
                          <a href="<?php the_permalink(); ?>"><h4><span><?php echo $popcounter . ". "; ?></span><?php echo get_the_title(); ?></h4></a>
                          <hr>
                        </div>
                      </div>
                      <?php
                        $popcounter++;
                        endforeach;
                        wp_reset_postdata();
                      ?>
                    </div>
                </div>
                <div class="events-fsa">
                  <h2 class="title">EVENTS</h2>
                  <div class="list-events-fsa">
                    <?php
                      $today = date('Ymd');
                      $args = array(
                        'showposts' => 1,
                        'post_type' =>'event',
                        'meta_key' => 'lw_event_start_date',
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC',
                        'meta_query' => array(
                          array(
                            'key' => 'lw_event_start_date',
                            'compare' => '>=',
                            'value' => $today
                          )
                      ));
                      $myposts = get_posts( $args );
                      foreach ( $myposts as $post ) : setup_postdata( $post );
                      if ($post->lw_event_start_date) {
                        $event_start_date = new DateTime($post->lw_event_start_date);
                      }

                      if ($post->lw_event_end_date) {
                        $event_end_date = new DateTime($post->lw_event_end_date);
                      }
                    ?>
                      <div class="loop-list">
                        <div class="content-image">
                          <?php
                            if ( has_post_thumbnail() ) {
                              echo '<a' . ($post->lw_event_target_blank == 'yes' ? ' target="_blank"' : '') . ' href="' . $post->lw_event_link . '">';
                              the_post_thumbnail();
                              echo '</a>';
                            }
                            else {
                          ?>
                          <a<?php echo $post->lw_event_target_blank == 'yes' ? ' target="_blank"' : ''; ?> href="<?php $post->lw_event_link; ?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
                          <?php
                            }
                          ?>
                        </div>
                        <div class="content-des">
                          <a<?php echo $post->lw_event_target_blank == 'yes' ? ' target="_blank"' : ''; ?> href="<?php echo $post->lw_event_link; ?>"><h3><?php echo get_the_title(); ?></h3></a>
                          <p class="date">
                            <?php
                              echo date_format($event_start_date, 'l jS F');

                              if ($event_end_date != '') {
                                echo ' - ' . date_format($event_end_date, 'l jS F');
                              }
                            ?>
                          </p>
                          <p><?php echo $post->lw_event_location; ?></p>
                        </div>
                      </div>
                      <?php
                        endforeach;
                        wp_reset_postdata();
                      ?>
                    </div>
                  </div>
                  <a class="readmore readmore-new" href="/events">View More Events<img src="<?php echo THEME_PATH.'/images/assets/Arrow-More-news.svg' ?>" alt="" /></a>
                </div>
              </div>
            </div>
            <div id="box-analysis" class="box-analysis">
              <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <h2>ASSET CLASS</h2>
                  <h2 class="nocolor">IN FOCUS</h2>
                  <div class="ads-lhs-mpu LHS_Home_MPU_Ad">
                    <a href="https://placeholder.com"><img src="http://via.placeholder.com/300x250"></a>
                  </div>
                  <a href="<?php echo get_category_link( "14" ); ?>" class="view-more">View more</a>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                  <div class="row">
                    <div class="analysis-list">
                      <?php
                        $args = array( 'posts_per_page' => 2 ,'showposts' => 2, 'category' => 14 );
                        $myposts = get_posts( $args );
                        foreach ( $myposts as $post ) : setup_postdata( $post );
                      ?>
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="loop-list">
                          <div class="content-image">
                            <?php
                              if ( has_post_thumbnail() ) {
                                the_post_thumbnail('featured-article');
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
                            </p>
                            <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                          </div>
                        </div>
                      </div>
                      <?php
                        endforeach;
                        wp_reset_postdata();
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <?php get_sidebar('right');?>
          </div>
        </div>
      </div>
    </section>
    <?php $headtohead = get_option('toggle_headtohead');
          if ($headtohead == "1") { ?>
    <section class="multimedia headtohead">
      <div class="container">
        <div class="content-multimedia">
          <div class="row row-eq-height">
            <div class="col-lg-3 col-sm-12 col-xs-12">
              <div class="multimedia-title">
                <h2>Head to head</h2>
                <h2 class="nocolor">A COMPARATIVE ANALISYS<br/>OF 2 FUNDS</h2>
                  <a href="<?php echo get_category_link( "21" ); ?>" class="view-more">View more</a>
              </div>
            </div>
            <div class="col-lg-9 col-sm-12 col-xs-12" id="multimediaright">
              <div class="slider-multimedia">
                  <?php
                    $args = array( 'posts_per_page' => 1,'showposts' => 1, 'category' => 21 );
                    $myposts = get_posts( $args );
                    foreach ( $myposts as $post ) : setup_postdata( $post );
                      $lw_brightcove_video_id = get_post_meta($post->ID,'lw_brightcove_video_id', TRUE);
                  ?>
                    <div class="content-image col-md-5">
                      <?php
                              if ( has_post_thumbnail() ) {
                                the_post_thumbnail('featured-article');
                              }
                              else {
                            ?>
                            <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
                            <?php
                              }
                            ?>
                    </div>
                    <div class="content-des col-md-7">
                      <p class="name-cat">
                        <?php $category = get_the_category(); ?>
                        <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                      </p>
                      <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                      <p><?php echo the_excerpt(); ?></p>
                    </div>
                  <?php
                    endforeach;
                    wp_reset_postdata();
                  ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php  } ?>
    <?php $variable_news = get_option('toggle_variable');
          if ($variable_news == "1") { ?>
        <section id="variable-news" class="variable-news">
        <div class="container">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <?php $variable_category = get_option('variable_category'); ?>
                  <h2 class="title"><?php echo get_cat_name($variable_category);?></h2>
                </div>

                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                  <div class="analysis-list">
                      <?php
                        $args = array( 'posts_per_page' => 3 ,'showposts' => 3, 'category' => $variable_category );
                        $myposts = get_posts( $args );
                        foreach ( $myposts as $post ) : setup_postdata( $post );
                      ?>
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="loop-list">
                          <div class="content-image">
                            <?php
                              if ( has_post_thumbnail() ) {
                                the_post_thumbnail('featured-article');
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
                            </p>
                            <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                            <p><?php echo the_excerpt(); ?></p>
                          </div>
                        </div>
                      </div>
                      <?php
                        endforeach;
                        wp_reset_postdata();
                      ?>
                    </div>
                </div>
              </div>
    </section>
    <?php  } ?>
    <?php $portfolios = get_option('toggle_portfolios');
          if ($portfolios == "1") { ?>
    <section class="multimedia portfolios">
      <div class="container">
        <div class="content-multimedia">
            <div class="row">
              <div class="portfolios-title">
                <h2 class="title">PORTFOLIOS</h2>
              </div>
            </div>

            <div class="row">
                  <?php
                    $args = array( 'posts_per_page' => 2,'showposts' => 2, 'category' => 15 );
                    $myposts = get_posts( $args );
                    foreach ( $myposts as $post ) : setup_postdata( $post );
                  ?>

                  <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="content-image col-md-6 col-sm-6 col-xs-12">
                      <?php
                              if ( has_post_thumbnail() ) {
                                the_post_thumbnail('featured-article');
                              }
                              else {
                            ?>
                            <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
                            <?php
                              }
                            ?>
                    </div>
                    <div class="content-des col-md-6 col-sm-6 col-xs-12">
                      <p class="name-cat">
                        <?php $category = get_the_category(); ?>
                        <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                      </p>
                      <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                      <p><?php echo the_excerpt(); ?></p>
                    </div>
                  </div>
                  <?php
                    endforeach;
                    wp_reset_postdata();
                  ?>

            </div>
            </div>
          </div>

    </section>
    <?php  } ?>
    <section class="team-members">
      <div class="container">
          <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <h2 class="title">EDITORIAL BOARD</h2>
            <h2 class="title color">FUND SELECTOR ASIA</h2>

            <p>The Editorial Board is a premier group of fund selectors and fund influencers who have kindly agreed to give us feedback and advice on the editorial direction of Fund Selector Asia. We thank them for their ongoing contribution to FSA and for their interest in developing the financial industry in Asia.</p>

            <?php echo do_shortcode('[tmm name="editorial-board"]'); ?>

          </div>
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="content-right">
              <?php lastWordAdUnit('rhs-hpu-2'); ?>
            </div>
          </div>
        </div>
    </section>
  </main><!-- #content -->
</section><!-- #primary -->

<?php get_footer();?>
