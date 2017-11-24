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
                      $args = array( 'posts_per_page' => 1,'showposts' => 1, 'category' => 2277);
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
                          <p>
                            <?php
                              $excerpt = get_the_excerpt();
                              if (strlen($excerpt) > 100) {
                                echo substr($excerpt, 0, 100) . '...';
                              }
                              else {
                                echo $excerpt;
                              }
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
                        $args = array( 'posts_per_page' => 6,'offset' => 1,'showposts' => 6);
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
                              <h3><?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?></h3>
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
                    <a class="readmore readmore-new" href="/type/news/">Read more news <img src="<?php echo THEME_PATH.'/images/assets/Arrow-More-news.svg' ?>" alt="more news" /></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="new-analysis">
                  <h2 class="title" style="visibility: hidden;">INTERVIEWS</h2>
                    <div class="list-new-analysis">
                    <?php
                      $args = array(
                        'posts_per_page' => 2,
                        'showposts' => 2,
                        'tax_query' => array(
                          array(
                            'taxonomy' => 'type',
                            'field' => 'term_id',
                            'terms' => '1944'
                          )
                        )
                      );
                      $myposts = get_posts( $args );
                      foreach ( $myposts as $post ) : setup_postdata( $post );
                    ?>
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
                          <span class="overlay"></span>
                        </div>
                        <div class="content-des">
                          <p class="name-cat">
                            <?php $category = get_the_category(); ?>
                            <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                          </p>
                          <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                        </div>
                      </div>
                      <?php
                        endforeach;
                        wp_reset_postdata();
                      ?>
                    </div>
                  </div>
                  <button id="scroll-more" class="readmore">Scroll to more Interviews <img src="<?php echo THEME_PATH.'/images/assets/Arrow-Analysis-scroll.svg' ?>" alt="arrow" /></button>
                </div>
              </div>
            </div>
            <div id="box-analysis" class="box-analysis">
              <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <h2>Interviews</h2>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                  <div class="row">
                    <div class="analysis-list">
                      <?php
                        $args = array(
                          'posts_per_page' => 4,
                          'offset' => 2,
                          'showposts' => 2,
                          'tax_query' => array(
                            array(
                              'taxonomy' => 'type',
                              'field' => 'term_id',
                              'terms' => '1944'
                            )
                          )
                        );
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
                            <span class="overlay"></span>
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
              <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <?php lastWordAdUnit('lhs-mpu'); ?>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                  <div class="row">
                    <div class="analysis-list">
                      <?php
                        $args = array(
                          'posts_per_page' => 4,
                          'offset' => 4,
                          'showposts' => 2,
                          'tax_query' => array(
                            array(
                              'taxonomy' => 'type',
                              'field' => 'term_id',
                              'terms' => '1944'
                            )
                          )
                        );
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
                            <span class="overlay"></span>
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
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <a href="<?php echo get_term_link(1944); ?>" class="view-more">View more</a>
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
    <section class="multimedia">
      <div class="container">
        <div class="content-multimedia">
          <div class="row row-eq-height">
            <div class="col-lg-3 col-sm-12 col-xs-12">
              <div class="multimedia-title">
                <h2>Multimedia</h2>
                <div id="bx-pager">
                  <a data-slide-index="0" href=""><i class="fa fa-circle" aria-hidden="true"></i></a>
                  <a data-slide-index="1" href=""><i class="fa fa-circle" aria-hidden="true"></i></a>
                  <a data-slide-index="2" href=""><i class="fa fa-circle" aria-hidden="true"></i></a>
                </div>
                <a href="/media" class="view-more">View more</a>
              </div>
            </div>
            <div class="col-lg-9 col-sm-12 col-xs-12" id="multimediaright">
              <div id="slider-multimedia" class="flexslider slider-multimedia">
                <ul class="slides bxslider">
                  <?php
                    $args = array( 'posts_per_page' => 3,'showposts' => 3, 'category' => 49 );
                    $myposts = get_posts( $args );
                    foreach ( $myposts as $post ) : setup_postdata( $post );
                      $lw_brightcove_video_id = get_post_meta($post->ID,'lw_brightcove_video_id', TRUE);
                  ?>
                  <li>
                    <?php
                     $isVideo = get_post_meta($post->ID,'lw_primary_medium')[0];
                    ?>
                    <div class="content-image <?php echo ($isVideo == 'video' ? 'has-video': '');?>">
                  <?php

                    if ( has_post_thumbnail() ) {
                      if($isVideo == 'video'){
                        echo '<a href="'. get_the_permalink() .'">';
                      }
                      the_post_thumbnail();
                      echo ($isVideo == 'video' ? '<div class="voverlay"></div>': '');
                      if($isVideo == 'video'){
                        echo '</a>';
                      }
                    }else {
                  ?>
                  <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
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
                      <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                      <p><?php echo the_excerpt(); ?></p>
                    </div>
                  </li>
                  <?php
                    endforeach;
                    wp_reset_postdata();
                  ?>
                </ul>

              </div>
            </div>
          </div>
          <div id="carousel-multimedia" class="flexslider carousel-multimedia">
            <ul class="slides">
              <?php
                $args = array( 'posts_per_page' => 3,'showposts' => 3, 'category' => 49 );
                $myposts = get_posts( $args );
                foreach ( $myposts as $post ) : setup_postdata( $post );
              ?>
              <li>
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
                  <span class="overlay"></span>
                </div>
                <div class="content-des">
                  <p class="name-cat">
                    <?php $category = get_the_category(); ?>
                    <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                  </p>
                  <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                </div>
              </li>
              <?php
                endforeach;
                wp_reset_postdata();
              ?>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <section class="feature-sponsored">
      <div class="container">
        <div id="feature-sponsored-item" class="owl-carousel owl-theme">
          <?php
            $args = array( 'posts_per_page' => 2,'showposts' => 2, 'category' => 15 );
            $myposts = get_posts( $args );
            foreach ( $myposts as $post ) : setup_postdata( $post );
              $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE);
          ?>
          <div class="item">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                  <a href="<?php the_permalink();?>">
                  <p class="readmore button-feature">Featured  <img src="<?php echo THEME_PATH.'/images/assets/Arrow-More-news.svg' ?>" alt="more news" /></p>
                </a>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="content-des">
                  <?php if($lw_sponsored != '') { ?><p class="name-cat">Sponsored by <?php echo $lw_sponsored;?></p><?php } ?>
                  <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                  <p><?php echo get_excerpt(100); ?></p>
                  <a href="<?php the_permalink(); ?>" class="view-more">View more</a>
                </div>
              </div>
            </div>
          </div>
          <?php
            endforeach;
            wp_reset_postdata();
          ?>
        </div>
      </div>
    </section>
    <section class="popular-porfolio">
      <div class="container">
        <div class="row">
          <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <?php get_sidebar('left');?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
              <div class="home-magazine">
                <div class="latest-issue">
                  <?php
                  $args = array('showposts' => 1, 'post_type' => 'magazine');
                  $myposts = get_posts($args);
                  foreach ($myposts as $post) : setup_postdata($post);
                  ?>
                  <div class="content-image">
                    <?php
                      echo '<a href="' . get_the_permalink() . '">';
                      if ( has_post_thumbnail() ) {
                        the_post_thumbnail();
                      }
                      else {
                    ?>
                    <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
                    <?php
                      }
                      echo '</a>';
                    ?>
                  </div>
                  <div class="content-des">
                    <p class="name-cat"><a href="<?php the_permalink();?>">Magazine</a></p>
                    <a href="<?php the_permalink(); ?>">
                      <h3>Expert Investor <span>-</span></h3>
                      <span class="date"><?php echo get_the_title(); ?></span>
                    </a>
                    <?php echo the_excerpt(); ?>
                  </div>
                  <?php
                    endforeach;
                    wp_reset_postdata();
                  ?>
                </div>
                <div id="carousel-portfolio" class="flexslider carousel-portfolio">
                  <ul class="slides">
                    <li>
                      <?php
                        $i = 0;
                        $args = array( 'posts_per_page' => 16, 'offset' => 1, 'showposts' => 16, 'post_type' => 'magazine' );
                        $myposts = get_posts( $args );
                        foreach ( $myposts as $post ) : setup_postdata( $post );
                      ?>
                      <div class="magazine">
                        <div class="content-image">
                          <?php
                            if ( has_post_thumbnail() ) {
                              echo '<a href="' . get_the_permalink() . '">';
                              the_post_thumbnail();
                              echo '</a>';
                            }
                            else {
                          ?>
                          <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
                          <?php
                            }
                          ?>
                        </div>
                        <div class="content-des">
                          <a href="<?php the_permalink();?>">
                            Expert Investor<br />
                            <?php echo get_the_title(); ?>
                          </a>
                        </div>
                      </div>
                      <?php
                        $i++;
                        if ($i % 4 == 0 && $i !== count($myposts)) {
                          echo '</li><li>';
                        }
                        endforeach;
                        wp_reset_postdata();
                      ?>
                    </li>
                  </ul>
                </div>
                <a href="/magazines" class="view-more">View more</a>
              </div>
            </div>
            <?php if(!wp_is_mobile()) : { ?>
                            <div class="clearfix">
              <div class="event">
                <h2>Events</h2>
                <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <?php
                      $today = date('Ymd');
                      query_posts(array(
                        'showposts' => 1,
                        'post_type' => 'event',
                        'meta_key' => 'lw_event_start_date',
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC',
                        'meta_query' => array(
                          array(
                            'key' => 'lw_event_start_date',
                            'compare' => '>=',
                            'value' => $today
                          )
                        )
                      ));
                      if (have_posts()) : while (have_posts()) : the_post();
                        if ($post->lw_event_start_date) {
                          $event_start_date = new DateTime($post->lw_event_start_date);
                        }

                        if ($post->lw_event_end_date) {
                          $event_end_date = new DateTime($post->lw_event_end_date);
                        }
                    ?>
                    <div class="first-event">
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
                      endwhile;endif;
                    ?>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="last-event">
                      <div class="row">
                        <?php
                          query_posts(array(
                            'showposts' => 3,
                            'offset' => 1,
                            'post_type' => 'event',
                            'meta_key' => 'lw_event_start_date',
                            'orderby' => 'meta_value_num',
                            'order' => 'ASC',
                            'meta_query' => array(
                              array(
                                'key' => 'lw_event_start_date',
                                'compare' => '>=',
                                'value' => $today
                              )
                            )
                          ));
                          if(have_posts()): while(have_posts()): the_post();
                            if ($post->lw_event_start_date) {
                              $event_start_date = new DateTime($post->lw_event_start_date);
                            }
                            else {
                              $event_start_date = '';
                            }

                            if ($post->lw_event_end_date) {
                              $event_end_date = new DateTime($post->lw_event_end_date);
                            }
                            else {
                              $event_end_date = '';
                            }
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
                        </div>
                        <?php
                          endwhile;endif;
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <a href="<?php echo home_url();?>/events" class="view-more">View more</a>
              </div>
            </div>
            <?php  } endif; ?>
          </div>
                      <?php if(wp_is_mobile()) : { ?>
                            <div class="clearfix">
              <div class="event">
                <h2>Events</h2>
                <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <?php
                      query_posts(array(
                        'showposts' => 1,
                        'post_type' => 'event',
                        'meta_key' => 'lw_event_start_date',
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC',
                        'meta_query' => array(
                          array(
                            'key' => 'lw_event_start_date',
                            'compare' => '>=',
                            'value' => $today
                          )
                        )
                      ));
                      if (have_posts()) : while (have_posts()) : the_post();
                        if ($post->lw_event_start_date) {
                          $event_start_date = new DateTime($post->lw_event_start_date);
                        }
                        else {
                          $event_start_date = '';
                        }

                        if ($post->lw_event_end_date) {
                          $event_end_date = new DateTime($post->lw_event_end_date);
                        }
                        else {
                          $event_end_date = '';
                        }
                    ?>
                    <div class="first-event">
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
                      endwhile;endif;
                    ?>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="last-event">
                      <div class="row">
                        <?php
                          query_posts(array(
                            'showposts' => 6,
                            'offset' => 1,
                            'post_type' => 'event',
                            'meta_key' => 'lw_event_start_date',
                            'orderby' => 'meta_value_num',
                            'order' => 'ASC',
                            'meta_query' => array(
                              array(
                                'key' => 'lw_event_start_date',
                                'compare' => '>=',
                                'value' => $today
                              )
                            )
                          ));
                          if(have_posts()): while(have_posts()): the_post();
                            if ($post->lw_event_start_date) {
                              $event_start_date = new DateTime($post->lw_event_start_date);
                            }
                            else {
                              $event_start_date = '';
                            }

                            if ($post->lw_event_end_date) {
                              $event_end_date = new DateTime($post->lw_event_end_date);
                            }
                            else {
                              $event_end_date = '';
                            }
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
                        </div>
                        <?php
                          endwhile;endif;
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <a href="<?php echo home_url();?>/events" class="view-more">View more</a>
              </div>
            </div>
            <?php  } endif; ?>
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="content-right">
              <?php lastWordAdUnit('rhs-hpu-2'); ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main><!-- #content -->
</section><!-- #primary -->

<?php get_footer();?>
