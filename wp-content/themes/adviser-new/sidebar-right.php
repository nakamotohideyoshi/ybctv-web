<div class="newsletter-wrapper">
  <hr class="border-n"></hr>
  <h2 class="no-border">NEWSLETTER</h2>
  <p><b>Sign Up for Portfolio<br> Adviser Daily Newsletter</b></p>
  <a href="/subscribe" class="btn btn-newsletter">Subscribe</a>
</div>
<?php
  if (!is_front_page()) {
    echo '<div class="sidebar-content-wrapper">'; // Wrapper div to help sticky ads
    echo '<div class="sidebar-content-container">'; // Container div to help sticky ads
    echo '<div class="sidebar-content-top">'; // Container around slider and RHS HPU 1
    lastWordAdUnit2('rhs-hpu-1');
  }
?>
<div class="content-right">
  <?php

          $sponsored_post_1_pre = get_option('sponsored_box_article_1', 0);
          $sponsored_post_2_pre = get_option('sponsored_box_article_2', 0);
          $sponsored_post_3_pre = get_option('sponsored_box_article_3', 0);
          $sponsored_post_4_pre = get_option('sponsored_box_article_4', 0);
          $sponsored_post_5_pre = get_option('sponsored_box_article_5', 0);

          $sponsored_posts_pre = Array(
            $sponsored_post_1_pre, $sponsored_post_2_pre, $sponsored_post_3_pre, $sponsored_post_4_pre, $sponsored_post_5_pre
          );

          $sponsored_posts = Array();
          $counter = 0;
          foreach ($sponsored_posts_pre as $sponsored_post) {
            if ($sponsored_post != 0) {
              $sponsored_posts[$counter] = $sponsored_post;
              $counter++;
            }
          }
  ?>
  <div class="box-sponsored">
    <div class="flexslider-spon">
      <ul class="slides">
        <?php

        foreach ($sponsored_posts as $spon_id) {
        $args = array( 'posts_per_page' => 1,'showposts' => 1, 'p' => $spon_id );
        $myposts = get_posts( $args );
        foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
          <li>
            <div class="loop-list">
              <div class="content-image">
                <?php
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail('featured-article');
                }
                else {
                ?>
                <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
                <?php
                  }
                ?>
                <span class="overlay"></span>
              </div>
              <div class="content-des">
                <p class="name-cat">
                  <?php $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE); ?>
                  <a>SPONSORED BY <?php echo $lw_sponsored;?></a>
                </p>
                <a href="<?php the_permalink(); ?>"><h3><?php the_title();?></h3></a>
              </div>
            </div>
          </li>
        <?php
          endforeach;
          wp_reset_postdata();
        }
        ?>
      </ul>
    </div>
  </div>
</div>
<?php
  if (is_front_page()) {
    echo '<div class="home-sidebar-content-wrapper">'; // Wrapper div to help sticky ads
    echo '<div class="home-sidebar-content-container">'; // Container div to help sticky ads
    lastWordAdUnit2('rhs-hpu-1');
    lastWordAdUnit2('rhs-mpu');
    lastWordAdUnit2('rhs-hpu-2');
    echo '</div>'; // End Wrapper div to help sticky ads
    echo '</div>'; // End Container div to help sticky ads
  }
  else {
    echo '</div>'; // End Container around slider and RHS HPU 1
    echo '<div class="sidebar-content-bottom">'; // Container around RHS HPU 2 and media
    lastWordAdUnit2('rhs-hpu-2');
    ?>
    <h2>Media</h2>
    <div class="col-xl-7 col-lg-12 col-md-12 media-side">
    <?php
      $args = array(  'posts_per_page' => 2,
        'showposts' => 2,
        'offset' => 1,
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
              if($isVideo == 'video') {
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
          <span class="article-overlay"></span>
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
    <?php
      echo '</div>'; // End Container around RHS HPU 2 and media
      echo '</div>'; // End Container div to help sticky ads
      echo '</div>'; // End Wrapper div to help sticky ads
  }
?>
