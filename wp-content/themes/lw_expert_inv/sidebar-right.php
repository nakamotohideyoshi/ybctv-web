<div class="content-right">
  <h2 class="title" style="visibility: hidden">Ads</h2>
  <?php lastWordAdUnit('rhs-hpu-1'); ?>
  <div class="box-sponsored">
    <div class="flexslider-spon">
      <ul class="slides">
        <?php
         $args = array(
                    'posts_per_page' => 4,
                    'showposts' => 4,
                    'tax_query' => array(
                        array(
                          'taxonomy' => 'type',
                          'field' => 'id',
                          'terms' => array( 2436 ),
                          'operator' => 'AND'
                        )));
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
                  <a href="/type/sponsored/">SPONSORED</a>
                </p>
                <a href="<?php the_permalink(); ?>"><h3><?php the_title();?></h3></a>
              </div>
            </div>
          </li>
        <?php
          endforeach;
          wp_reset_postdata();
        ?>
      </ul>
    </div>
  </div>
  <?php
    if (is_single()) {
  ?>
  <div class="feature-sponsored">
      <?php
      $args = array( 'posts_per_page' => 1,'showposts' => 1, 'category' => 15 );
      $myposts = get_posts( $args );
      foreach ( $myposts as $post ) : setup_postdata( $post );
      $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE);
      ?>
          <div class="content-image">
              <?php
              if ( has_post_thumbnail() ) {
                  the_post_thumbnail('featured-article');
              }
              else { ?>
                  <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
              <?php }
              ?>
              <p class="readmore button-feature">Featured  <img src="<?php echo THEME_PATH.'/images/assets/Arrow-More-news.svg' ?>" alt="" /></p>
          </div>
          <div class="content-des">
              <p class="name-cat">Sponsored by <?php echo $lw_sponsored;?></p>
              <a href="<?php the_permalink(); ?>"><h3><?php the_title();?></h3></a>
              <p><?php echo get_excerpt(100); ?></p>
              <a href="<?php the_permalink(); ?>" class="view-more">View more</a>
          </div>
      <?php endforeach;
      wp_reset_postdata();?>
  </div>
  <?php
    }
    if (!is_home()) {
      lastWordAdUnit('rhs-hpu-2');
    }
  ?>
</div>
