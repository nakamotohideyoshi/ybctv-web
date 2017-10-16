 <div class="related-post clearfix">
    <div class="row">
       <div class="col-md-4 col-sm-12 col-xs-12">
          <h2>Related</br>Content</h2>
          <div id="bx-pager">
             <a data-slide-index="0" href=""><i class="fa fa-circle" aria-hidden="true"></i></a>
             <a data-slide-index="1" href=""><i class="fa fa-circle" aria-hidden="true"></i></a>
             <a data-slide-index="2" href=""><i class="fa fa-circle" aria-hidden="true"></i></a>
          </div>
          <a href="/register" class="view-more">Sign up to our newsletter</a>
       </div>
       <div class="col-md-8 col-sm-12 col-xs-12">
          <ul class="bxslider-related">
             <?php
                $count = 0;
                $args = array(
                    'posts_per_page' => 6, // How many items to display
                    'post__not_in'   => array( get_the_ID() ), // Exclude current post
                    'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
                );
                $cats = wp_get_post_terms( get_the_ID(), 'category' );
                $cats_ids = array();
                foreach( $cats as $wpex_related_cat ) {
                    $cats_ids[] = $wpex_related_cat->term_id;
                }
                if ( ! empty( $cats_ids ) ) {
                    $args['category__in'] = $cats_ids;
                }
                $wpex_query = new wp_query( $args );
                ?>
             <li>
                <div class="row">
                   <?php
                      foreach( $wpex_query->posts as $post ) : setup_postdata( $post ); $count++; ?>
                   <div class="col-md-6 col-sm-6 col-xs-6">
                      <div class="loop-list">
                         <div class="content-image">
                            <?php
                               if ( has_post_thumbnail() ) {
                                   the_post_thumbnail('section-article');
                               }
                               else { ?>
                            <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
                            <?php }
                               ?>
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
                   </div>
                   <?php if ($count % 2 == 0 && $count != 6) echo '</div></li><li><div class="row banana">'; ?>
                   <?php
                      endforeach;
                      wp_reset_postdata(); ?>
                </div>
             </li>
          </ul>
       </div>
    </div>
 </div>