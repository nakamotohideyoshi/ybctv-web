<div class="sidebar-content-wrapper">
  <div class="sidebar-content-container">
    <?php lastWordAdUnit2('rhs-hpu-1'); ?>
    <div class="empty-box1" id="addsblock-sidebar2"></div>
    <h2>Media</h2>
   <div class="col-md-7 media-side">
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
    <div class="empty-box1" id="addsblock-sidebar1"></div>

    <?php lastWordAdUnit2('rhs-hpu-2'); ?>

  </div>
</div>
