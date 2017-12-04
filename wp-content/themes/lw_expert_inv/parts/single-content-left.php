 <div class="content-left">
    <div class="most-popular most-popular-new">
       <h2>Most Popular News</h2>
       <?php lastWordAdUnit('top-news-ad'); ?>
       <div class="list-most-popular">
          <?php
            $no_of_days = (int)get_option('most_read_days');
            $start_date = date('Y-m-d', strtotime('-' . $no_of_days . ' days'));

            $popularpost = new WP_Query( array( 
                'posts_per_page' => 3,
                'showposts' => 3,
                'date_query' => array(
                  'after' => $start_date
                ),
                'meta_key' => 'lw_read_count',
                'orderby' => 'meta_value_num',
                'ignore_sticky_posts' => 1,
                'order' => 'DESC'
                )
            );        
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