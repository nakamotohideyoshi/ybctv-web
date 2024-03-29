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
                      $args = array( 'posts_per_page' => 1,'showposts' => 1, 'category' => 2681);
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
                          <h2 class="title">TOP STORY...</h2>
                          <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                          <p>
                            <?php
                              $excerpt = excerpt(20);
                              //if (strlen($excerpt) > 100) {
                                //echo substr($excerpt, 0, 100) . '...';
                              //}
                              //else {
                                echo $excerpt;
                              //}
                            ?>
                          </p>
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
                        $args = array( 'posts_per_page' => 5,'offset' => 1,'showposts' => 5 );
                        $myposts = get_posts( $args );
                        foreach ( $myposts as $post ) : setup_postdata( $post ); $count++;
                          if ($count == 1) {
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
                    <a class="readmore readmore-new" href="<?php echo get_category_link( "20" ); ?>">Read more news <img src="<?php echo THEME_PATH.'/images/assets/Arrow-More-news.svg' ?>" alt="" /></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="most-viewed">
                  <h2 class="title">MOST VIEWED</h2>
                    <div class="list-most-viewed">
                    <?php
                      $no_of_days = (int)get_option('most_read_days');
                      $start_date = date('Y-m-d', strtotime('-' . $no_of_days . ' days'));
                      $args = array(
                        'posts_per_page' => 5,
                        'showposts' => 5,
                        'date_query' => array(
                          'after' => $start_date
                        ),
                        'meta_key' => 'lw_read_count',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC'
                      );
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
                  <a class="readmore readmore-new" href="/events">View more events<img src="<?php echo THEME_PATH.'/images/assets/Arrow-More-news.svg' ?>" alt="" /></a>
                </div>
              </div>
            </div>
            <div id="box-analysis" class="box-analysis">
              <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <h2>ASSET CLASS</h2>
                  <h2 class="nocolor">IN FOCUS</h2>
                  <a href="<?php echo get_category_link( "14" ); ?>" class="view-more">View more</a>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                  <div class="row">
                    <div class="analysis-list">

                      <?php
                        $args = array( 'numberposts' => 1, 'posts_per_page' => 1, 'p' => get_option('featured_left_box_article', 0));
                        $myposts = get_posts( $args );
                        foreach ( $myposts as $post ) : setup_postdata( $post );
                        $postctype = wp_get_post_terms( $post->ID, 'type');
                        $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE);
                        $chkspnsrd = $postctype[0]->slug;
                      ?>
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="loop-list" <?php if ($chkspnsrd == 'sponsored' || $lw_sponsored != '') { echo 'style="background: #d8d8d8;"'; }?>>
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
                          <div class="content-des" style="padding-left: 10px; padding-right: 10px;">              
                              <?php 
                              
                              if($chkspnsrd == 'sponsored' || $lw_sponsored != '') { 
                              ?>
                                <p class="name-cat">Sponsored by <?php echo $lw_sponsored;?></p>
                              <?php } else { ?>
                                <p class="name-cat">
                                <?php $category = get_the_category(); ?>
                                  <a href="<?php echo get_category_link($category[0]->cat_ID);?>">
                                    <?php echo $category[0]->cat_name;?>
                                  </a>
                                </p>
                              <?php } ?>
                            <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                          </div>
                        </div>
                      </div>
                      <?php
                        endforeach;
                        wp_reset_postdata();
                      ?>

                      <?php
                        $args = array( 'numberposts' => 1, 'posts_per_page' => 1, 'p' => get_option('featured_right_box_article', 0));
                        $myposts = get_posts( $args );
                        foreach ( $myposts as $post ) : setup_postdata( $post );
                        $postctype = wp_get_post_terms( $post->ID, 'type');
                        $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE);
                        $chkspnsrd = $postctype[0]->slug;
                      ?>
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="loop-list" <?php if ($chkspnsrd == 'sponsored' || $lw_sponsored != '') { echo 'style="background: #d8d8d8;"'; }?>>
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
                          <div class="content-des" style="padding-left: 10px; padding-right: 10px;">
                            <?php 
                            if($chkspnsrd == 'sponsored' || $lw_sponsored != '') { ?>
                                <p class="name-cat">Sponsored by <?php echo $lw_sponsored;?></p>
                              <?php } else { ?>
                                <p class="name-cat">
                                <?php $category = get_the_category(); ?>
                                  <a href="<?php echo get_category_link($category[0]->cat_ID);?>">
                                    <?php echo $category[0]->cat_name;?>
                                  </a>
                                </p>
                              <?php } ?>
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
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 right-side-wrap">
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
                <h2 class="nocolor">A COMPARATIVE ANALYSIS<br/>OF 2 FUNDS</h2>
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
          if ($variable_news == "1") { //remove hidden class from section?>
        <section id="variable-news" class="variable-news hidden">
        <div class="container">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <?php $variable_category = get_option('variable_category'); ?>
                  <h2 class="title"><?php echo get_cat_name($variable_category);?></h2>
                  <a href="/category/fsa-analysis/" class="view-more">View more</a>
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
                    $args = array( 'posts_per_page' => 2,'showposts' => 2, 'category' => 2682 );
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
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 right-side-wrap">
            <div class="content-right">
              <?php lastWordAdUnit('rhs-hpu-2'); ?>
              <?php lastWordAdUnit('rhs-hpu-3'); ?>
            </div>
          </div>
        </div>
    </section>
  </main><!-- #content -->
</section><!-- #primary -->

<?php get_footer();?>
