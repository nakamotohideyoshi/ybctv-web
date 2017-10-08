<?php
/*
 * The Template for displaying all single posts
 */

get_header(); ?>

<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <div class="content-page">
            <div class="container">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="content-left">
                        <div class="most-popular most-popular-new">
                            <h2>Most Popular News</h2>
                            <p class="architas">architas</p>
                            <div class="list-most-popular">
                                <?php
                                $popularpost = new WP_Query( array( 'posts_per_page' => 3, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );
                                while ( $popularpost->have_posts() ) : $popularpost->the_post(); ?>
                                    <div class="loop-list">
                                        <div class="content-image">
                                            <?php
                                            if ( has_post_thumbnail() ) {
                                                the_post_thumbnail('popular-article');
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
                                <?php endwhile;wp_reset_postdata();
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="bread">
                        <?php if(function_exists('bcn_display'))
                        {
                            bcn_display();
                        }?>
                    </div>
                    <div class="content-category content-single">
                        <?php if(have_posts()): while(have_posts()): the_post(); ?>
                            <p class="name-cat">Portfolio Adviser Magazine</p>
                            <h1 class="title-single"><?php the_title();?></h1>

                            <div class="content-post>">
                                <div class="description-single">
                                    <?php $lw_description    =   get_post_meta($post->ID,'lw_description', TRUE);?>
                                    <?php echo $lw_description;?>
                                </div>
                                <div class="thump-single">
                                    <?php
                                        if ( has_post_thumbnail() ) {
                                            the_post_thumbnail();
                                        }
                                        else { ?>
                                            <img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" />
                                        <?php }
                                    ?>
                                </div>
                                <?php the_content();?>
                            </div>
                            <div class="comment-post">
                                <?php if ( comments_open() || get_comments_number() ) :
                                    comments_template();
                                endif;?>
                            </div>
                        <?php endwhile;endif;?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-md-offset-1 col-sm-12 col-xs-12">
                    <?php get_sidebar('right');?>
                </div>
            </div>
        </div>

    </div><!-- #content -->
</section><!-- #primary -->

<?php get_footer();?>
