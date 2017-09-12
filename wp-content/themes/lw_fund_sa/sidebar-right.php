<div class="content-right">
    <h2 class="title" style="visibility: hidden">Ads</h2>
    <?php lastWordAdUnit('rhs-hpu-1'); ?>
    <div class="box-sponsored">
        <div class="flexslider-spon">
            <ul class="slides">

                <?php
                $args = array( 'posts_per_page' => 4,'showposts' => 4, 'category' => 15 );
                $myposts = get_posts( $args );
                foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
                    <li>
                        <div class="loop-list">
                            <div class="content-image">
                                <?php
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail('featured-article');
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
                                <a href="<?php the_permalink(); ?>"><h3><?php the_title();?></h3></a>
                            </div>
                        </div>
                    </li>
                <?php endforeach;
                wp_reset_postdata();?>

            </ul>
        </div>
    </div>
</div>
