<?php
/**
* Template Name: Homepage
 */

get_header(); ?>
<section id="primary" class="content-area">
  <div id="content" class="site-content" role="main">
    <div class="col-md-12" id="content">
      <div class="row">
        <div class="col-md-9" id="home-content">
          <h2 class="title">TOP STORIES</h2>
          <?php
            $args = array( 'posts_per_page' => 1,'showposts' => 1, 'meta_key' => 'lw_top_story', 'meta_value' => 'yes' );
            $myposts = get_posts( $args );
            foreach ( $myposts as $post ) : setup_postdata( $post );
              $current_permalink = get_permalink();
              $current_title = get_the_title();
          ?>
          <div class="row">
            <div class="col-md-6 top-left">
              <?php
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail('homepage-latest-article');
                }
                else {
              ?>
                <a href="<?php echo $current_permalink; ?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( $current_title, 0, 50, '...' ); ?>" /></a>
              <?php
                }
              ?>
            </div>
            <div class="col-md-6 top-right">
              <a href="<?php echo $current_permalink; ?>"><h3><?php echo $current_title; ?></h3></a>
              <span class="date">By <?php echo get_the_author(); ?>,  <?php echo get_the_date(); ?> </span>
              <?php
                $excerpt = the_excerpt(20);
                //if (strlen($excerpt) > 100) {
                //echo substr($excerpt, 0, 100) . '...';
                //}
                //else {
                echo $excerpt;
                //}
                endforeach;
                wp_reset_postdata();
              ?>
            </div>
          </div><!--END OF TOP STORIES ROW-->
          <div class="row other-latest">
            <?php
              $args = array( 'posts_per_page' => 3,'offset' => 1,'showposts' => 3, 'meta_key' => 'lw_top_story', 'meta_value' => 'yes' );
              $myposts = get_posts( $args );
              foreach ( $myposts as $post ) : setup_postdata( $post );
                $current_permalink = get_permalink();
                $current_title = get_the_title();
            ?>
              <div class="col-md-4">
                <p class="name-cat">
                  <?php
                    $category = get_the_category();
                    $useCatLink = true;
                    // If post has a category assigned.
                    if ($category) {
                      $category_display = '';
                      $category_link = '';
                      if ( class_exists('WPSEO_Primary_Term') ) {
                        // Show the post's 'Primary' category, if this Yoast feature is available, & one is set
                        $wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
                        $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
                        $term = get_term( $wpseo_primary_term );
                        if (is_wp_error($term)) {
                          // Default to first category (not Yoast) if an error is returned
                          $category_display = $category[0]->name;
                          $category_link = get_category_link( $category[0]->term_id );
                        } else {
                          // Yoast Primary category
                          $category_display = $term->name;
                          $category_link = get_category_link( $term->term_id );
                        }
                      }
                      else {
                        // Default, display the first category in WP's list of assigned categories
                        $category_display = $category[0]->name;
                        $category_link = get_category_link( $category[0]->term_id );
                      }
                    }
                  ?>
                  <a href="<?php echo $category_link; ?>"><?php echo $category_display; ?></a>
                </p>
                <a href="<?php echo $current_permalink; ?>"><h3 class="story-title"><?php echo $current_title; ?></h3></a>
                <?php
                  $excerpt = the_excerpt(30);
                  //if (strlen($excerpt) > 100) {
                  //echo substr($excerpt, 0, 100) . '...';
                  //}
                  //else {
                  echo $excerpt;
                  //}
                ?>
              </div>
            <?php
              endforeach;
              wp_reset_postdata();
            ?>
          </div><!--END OF OTHER TOP STORIES ROW-->
          <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8" id="most-popular">
              <h2 class="title">MOST POPULAR</h2>
              <div class="row">
                <?php
                  $args = array( 'posts_per_page' => 4, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC' );
                  $myposts = get_posts( $args );
                  foreach ( $myposts as $post ) : setup_postdata( $post );
                    $current_permalink = get_permalink();
                    $current_title = get_the_title();
                  ?>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="row">
                      <div class="col-xl-4 col-lg-12 col-md-12">
                        <?php echo the_post_thumbnail(); ?>
                      </div>
                      <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12">
                        <?php
                          $category = get_the_category();
                          $useCatLink = true;
                          // If post has a category assigned.
                          if ($category) {
                            $category_display = '';
                            $category_link = '';
                            if ( class_exists('WPSEO_Primary_Term') ) {
                              // Show the post's 'Primary' category, if this Yoast feature is available, & one is set
                              $wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
                              $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
                              $term = get_term( $wpseo_primary_term );
                              if (is_wp_error($term)) {
                                // Default to first category (not Yoast) if an error is returned
                                $category_display = $category[0]->name;
                                $category_link = get_category_link( $category[0]->term_id );
                              } else {
                                // Yoast Primary category
                                $category_display = $term->name;
                                $category_link = get_category_link( $term->term_id );
                              }
                            }
                            else {
                              // Default, display the first category in WP's list of assigned categories
                              $category_display = $category[0]->name;
                              $category_link = get_category_link( $category[0]->term_id );
                            }
                          }
                        ?>
                        <p class="name-cat"><a href="<?php echo $category_link; ?>"><?php echo $category_display; ?></a></p>
                        <a href="<?php echo $current_permalink; ?>"><h3 class="story-title-2"><?php echo $current_title; ?></h3></a>
                      </div>
                    </div>
                  </div>
                  <?php
                    endforeach;
                    wp_reset_postdata();
                  ?>
              </div>
            </div>
            <div class="col-md-4">
              <h2 class="col-xl-6 col-lg-12 col-md-12 float-left">EVENTS</h2>
              <p class="col-xl-6 col-lg-12 col-md-12 float-right">
                <button type="button" class="btn btn-calendar" data-toggle="modal" data-target="#exampleModal">view calendar</button>
              </p>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h2 class="modal-title" id="exampleModalLabel">Event Calendar</h2>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">Close &times;</span>
                      </button>
                    </div>
                    <div class="row modal-body">
                      <div class="col-md-6">
                        <div id="events-calendar"></div>
                      </div>
                      <div class="col-md-6" id="event-right">
                        <div post-template-cont></div>
                        <div class="target" style="display:none;">
                          <h2 class="no-date">THERE IS NO ACTIVE EVENTS ON THIS DATE!</h2>
                        </div>
                      </div>
                      <div post-template style="display: none">
                        <div class="event-start-date"></div>
                        <div class="event-date-location">
                          <span class="date date-event date-eventX"></span>-<span class="date date-event date-event end"></span>
                          <span class="location locationX date"><?php echo $post->lw_event_location; ?></span>
                        </div>
                        <div class="event-title"></div>
                        <div class="event-body">
                          <?php get_the_excerpt(); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
                  $current_permalink = get_the_permalink();
                  $current_title = get_the_title();

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
                      the_post_thumbnail('medium');
                      echo '</a>';
                    }
                    else {
                  ?>
                  <a<?php echo $post->lw_event_target_blank == 'yes' ? ' target="_blank"' : ''; ?> href="<?php $post->lw_event_link; ?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( $current_title, 0, 50, '...' ); ?>" /></a>
                  <?php
                    }
                  ?>
                </div>
                <div class="content-des">
                  <a<?php echo $post->lw_event_target_blank == 'yes' ? ' target="_blank"' : ''; ?> href="<?php echo $post->lw_event_link; ?>"><h3><?php echo $current_title; ?></h3></a>
                  <span class="date date-event">
                    <?php
                      echo date_format($event_start_date, 'l jS F');
                      if ($event_end_date != '') {
                        echo ' - ' . date_format($event_end_date, 'l jS F');
                      }
                    ?>
                  </span>
                  <span class="location date"><?php echo $post->lw_event_location; ?></span>
                </div>
              </div>
              <?php
                endwhile;endif;
                wp_reset_query();
              ?>
            </div>
          </div><!--END OF MOST POPULAR/EVENTS ROW-->
          <div class="row">
            <div class="col-md-12">
              <?php sponsoredContentBanner(); ?>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <?php lastWordAdUnit2('mid-billboard'); ?>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 no-top">
              <h2 class="title" id="l-stories">LATEST STORIES</h2>
    	        <?php
                $args = array( 'posts_per_page' => 3,'offset' => 0 ,'showposts' => 3, 'orderby' => 'post_date','order' => 'DESC', );
                $myposts = get_posts( $args );
                foreach ( $myposts as $post ) : setup_postdata( $post );
                  $current_permalink = get_the_permalink();
                  $current_title = get_the_title();
              ?>
    	        <div class="story">
    	          <p class="name-cat">
                  <?php $category = get_the_category(); ?>
                  <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                </p>
                <a href="<?php echo $current_permalink; ?>"><h3><?php echo $current_title; ?></h3></a>
              </div>
              <?php
                endforeach;
                wp_reset_postdata();
              ?>
            </div><!--END OF LATEST STORIES-->
            <div class="col-md-4 no-top">
              <h2 class="title" id="l-stories">ANALYSIS</h2>

              <?php

                $args = array( 'posts_per_page' => 3,'offset' => 2 ,'showposts' => 3, 'category' => 40 );
                $myposts = get_posts( $args );
                foreach ( $myposts as $post ) : setup_postdata( $post );
                  $current_permalink = get_the_permalink();
                  $current_title = get_the_title();
              ?>
              <div class="story">
    	          <p class="name-cat">
                  <?php $category = get_the_category(); ?>
                  <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                </p>
                <a href="<?php echo $current_permalink; ?>"><h3><?php echo $current_title; ?></h3></a>
              </div>
              <?php
                endforeach;
                wp_reset_postdata();
              ?>
            </div><!--END OF ANALYSIS-->
            <div class="col-md-4 no-top">
              <h2 class="title" id="l-stories">OPINION</h2>

              <?php

                $args = array( 'posts_per_page' => 3,'offset' => 2 ,'showposts' => 3, 'category' => 40 );
                $myposts = get_posts( $args );
                foreach ( $myposts as $post ) : setup_postdata( $post );
                  $current_permalink = get_the_permalink();
                  $current_title = get_the_title();
              ?>
              <div class="story">
    	          <p class="name-cat">
                  <?php $category = get_the_category(); ?>
                  <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                </p>
                <a href="<?php echo $current_permalink; ?>"><h3><?php echo $current_title; ?></h3></a>
              </div>
              <?php
                endforeach;
                wp_reset_postdata();
              ?>
            </div><!--END OF OPINION-->
          </div><!--END OF LATEST/ANALYSIS/OPINION ROW-->
          <div class="row media-row">
            <div class="col-md-12">
              <h2>MEDIA</h2>
              <div class="row">
                <div class="col-xl-10 col-lg-8 col-md-8 media-left">
                  <?php
                    $postsarray = array();
                    for ($i = 1; $i <= 4; $i++) {
                      $postsarray[$i] = get_option('multimedia_section_article_'.$i, 0);
                    }

                    $args = array(  'posts_per_page' => 1,
                      'showposts' => 1,
                      'post__in' => $postsarray,
                      'orderby' => 'post__in'
                    );

                    $myposts = get_posts( $args );
                      foreach ( $myposts as $post ) : setup_postdata( $post );
                        $current_permalink = get_permalink();
                        $current_title = get_the_title();
                        $primary_medium = get_post_meta($post->ID,'lw_primary_medium')[0];
                        $lw_brightcove_video_id = get_post_meta($post->ID,'lw_brightcove_video_id', TRUE);
                  ?>
                  <div class="content-image" id="big-image">
                    <?php
                      if ($primary_medium == "video") {
                        brightcove2_video($lw_brightcove_video_id, false);
                      } else {
                        the_post_thumbnail('large');
                      }
                    ?>
                    <span class="overlay"></span>
                  </div>
                  <div class="content-des col-md-8">
                    <p class="name-cat">
                      <?php $category = get_the_category(); ?>
                      <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                    </p>
                    <a href="<?php echo $current_permalink; ?>"><h3><?php echo $current_title; ?></h3></a>
                    <p><?php echo the_excerpt(20); ?></p>
                    <a href="/media" class="btn btn-newsletter">view all media</a>
                  </div>
                  <?php
                    endforeach;
                    wp_reset_postdata();
                  ?>
                </div>
                <div class="col-xl-2 col-lg4 col-md-4 media-side">
                  <?php
                    $args = array(  'posts_per_page' => 3,
                      'showposts' => 3,
                      'post__in' => $postsarray,
                      'orderby' => 'post__in'
                    );
                    $myposts = get_posts( $args );
                    foreach ( $myposts as $post ) : setup_postdata( $post );
                      $current_permalink = get_the_permalink();
                      $current_title = get_the_title();

                      $isVideo = get_post_meta($post->ID,'lw_primary_medium')[0];
                  ?>
                  <div class="content-image <?php echo ($isVideo == 'video' ? 'has-video': '');?> col-md-12">
                    <?php
                      if ( has_post_thumbnail() ) {
                        if($isVideo == 'video'){
                          echo '<a href="'. $current_permalink .'">';
                        }
                        the_post_thumbnail('homepage-latest-article');
                        echo ($isVideo == 'video' ? '<div class="voverlay"></div>': '');
                        if($isVideo == 'video'){
                          echo '</a>';
                        }
                      } else {
                    ?>
                    <a href="<?php echo $current_permalink;?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( $current_title, 0, 50, '...' ); ?>" /></a>
                    <?php
                      }
                    ?>
                    <span class="overlay"></span>
                  </div>
                  <div class="content-des col-md-12">
                    <p class="name-cat">
                      <?php $category = get_the_category(); ?>
                      <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                    </p>
                    <a href="<?php echo $current_permalink; ?>"><h3><?php echo $current_title; ?></h3></a>
                  </div>
                  <?php
                    endforeach;
                    wp_reset_postdata();
                  ?>
                </div>
              </div>
            </div>
          </div><!--END OF MEDIA ROW-->
          <div class="row magazines-row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-8">
                  <h2 class="title">MAGAZINES</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8" id="magazines">
                  <?php
                    $args = array('showposts' => 1, 'post_type' => 'magazine');
                    $myposts = get_posts($args);
                    foreach ($myposts as $post) : setup_postdata($post);
                      $current_permalink = get_the_permalink();
                      $current_title = get_the_title();
                  ?>
                  <div class="row mag-first">
                    <div class="col-md-4 top-left top-left-mag">
                      <?php
                        if ( has_post_thumbnail() ) {
                          echo '<a href="' . $current_permalink . '">';
                          the_post_thumbnail('medium');
                          echo '</a>';
                        }
                        else {
                      ?>
                      <a href="<?php echo $current_permalink;?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( $current_title, 0, 50, '...' ); ?>" /></a>
                      <?php
                        }
                      ?>
                    </div>
                    <div class="col-md-8 top-right-mag top-mag">
                      <a href="<?php echo $current_permalink; ?>"><h3><?php echo $current_title; ?></h3></a>
                      <span class="date magazine-date">Published <?php echo get_the_date(); ?></span>
                      <p>
                        <?php
                          //if (strlen($excerpt) > 100) {
                          //echo substr($excerpt, 0, 100) . '...';
                          //}
                          //else {
                          echo get_excerpt(100);
                          //}
                        ?>
                      </p>
                      <?php
                        endforeach;
                        wp_reset_postdata();
                      ?>
                    </div>
                  </div><!--END OF MAGAZINES FIRST BLOCK-->
                  <div class="row">
                    <?php
                      $i = 0;
                      $args = array( 'posts_per_page' => 3, 'offset' => 1, 'showposts' => 3, 'post_type' => 'magazine' );
                      $myposts = get_posts( $args );
                      foreach ( $myposts as $post ) : setup_postdata( $post );
                        $current_permalink = get_the_permalink();
                        $current_title = get_the_title();
                    ?>
                    <div class="col-md-4 mag-other">
                      <div class="magazine">
                        <div class="content-image col-md-6 mag-image">
                          <?php
                            if ( has_post_thumbnail() ) {
                              echo '<a href="' . $current_permalink . '">';
                              the_post_thumbnail('medium');
                              echo '</a>';
                              }
                            else {
                          ?>
                          <a href="<?php echo $current_permalink; ?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( $current_title, 0, 50, '...' ); ?>" /></a>
                          <?php
                            }
                          ?>
                        </div>
                        <div class="content-des mag-des">
                          <a href="<?php echo $current_permalink; ?>">
                            Portfolio Adviser<br />
                            <?php echo $current_title; ?>
                          </a>
                        </div>
                      </div>
                    </div>
                    <?php
                      endforeach;
                      wp_reset_postdata();
                    ?>
                    <div class="col-md-12">
                      <a href="/magazines" class="btn btn-newsletter btn-magazines">view more</a>
                    </div>
                  </div><!--END OF MAGAZINES LAST BLOCK-->
                </div><!--END OF MAGAZINES COL-->
                <div class="col-md-4">
                  <?php lastWordAdUnit2('esg-clarity'); ?>
                </div>
              </div>
            </div>
          </div><!--END OF MAGAZINES ROW-->
        </div><!--END OF HOME CONTENT COL-->
        <div class="col-md-3" id="sidebar">
          <hr class="border-n"></hr>
          <h2 class="no-border">NEWSLETTER</h2>
          <p><b>Sign Up for Portfolio<br> Adviser Daily Newsletter</b></p>
          <a href="/subscribe" class="btn btn-newsletter">Subscribe</a>

          <div class="home-sidebar-content-container">
            <?php
              get_sidebar('right');
              lastWordAdUnit2('rhs-hpu-1');
              lastWordAdUnit2('rhs-mpu');
              lastWordAdUnit2('rhs-hpu-2');
            ?>
          </div>
        </div>
      </div>
    </div>
  </div><!--END OF CONTENT-->
</section>
<?php
get_footer();
