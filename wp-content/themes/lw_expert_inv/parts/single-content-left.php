 <div class="content-left">
    <div class="most-popular most-popular-new">
       <h2>Most Popular News</h2>
       <?php lastWordAdUnit('top-news-ad'); ?>
       <div class="list-most-popular">
          <?php
             $popularpost = new WP_Query( array( 'posts_per_page' => 3, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'category__not_in' => array( 26, 21 ) ) );
             while ( $popularpost->have_posts() ) : $popularpost->the_post();
             ?>
          <div class="loop-list">
             <div class="content-image">
                <?php
                   if ( has_post_thumbnail() ):
                       the_post_thumbnail('popular-article');
                   else: ?>
                     <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
                <?php endif; ?>
                <span class="overlay"></span>
             </div>
             <div class="content-des">
                <p class="name-cat">
                   <?php $category = get_the_category(); ?>
                   <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                </p>
                <a href="<?php the_permalink(); ?>">
                   <h3><?php the_title();?></h3>
                </a>
             </div>
          </div>
          <?php endwhile;wp_reset_postdata(); ?>
       </div>
    </div>
 </div>