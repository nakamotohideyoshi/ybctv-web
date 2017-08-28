<?php
/*
 * The template for displaying Author archive pages
 */

get_header(); ?>

<?php get_header();?>
<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <div class="content-page">
            <div class="container">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="content-left">
                        <?php get_sidebar('left');?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="bread">
                        <?php if(function_exists('bcn_display'))
                        {
                            bcn_display();
                        }?>
                    </div>
                    <div class="list-content-page">

                        <div class="author-info">
                            <div class="author-avatar clearfix">
                                <?php echo get_avatar( get_the_author_meta('user_email'), $size = '80');  ?>
                                <h2 class="author-title"><?php echo get_the_author(); ?></h2>
                            </div>
                            <div class="author-description">
                                <p class="author-bio">
                                    <?php the_author_meta( 'description' ); ?>
                                </p>
                            </div>
                            <div class="like_button clearfix">
                                <!-- Email -->
                                <div class="Email">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </div>
                                <!-- Facebook Button -->
                                <div class="FacebookButton">
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                </div>
                                <!-- Twitter Button -->
                                <div class="TwitterButton">
                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                </div>
                                <!-- Intagram -->
                                <div class="In">
                                    <i class="fa fa-linkedin" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <?php $count=0;?>
                        <div class="list-category">
                            <div class="row">
                                <?php if(have_posts()): while(have_posts()): the_post(); $count++?>
                                <?php if ($count <= 2) { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="loop-list">
                                            <div class="content-image">
                                                <?php
                                                if ( has_post_thumbnail() ) {
                                                    the_post_thumbnail();
                                                }
                                                else { ?>
                                                    <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
                                                <?php }
                                                ?>
                                            </div>
                                            <div class="content-des">
                                                <p class="name-cat">
                                                <?php $category = get_the_category(); ?>
                                                <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                                                <span><?php the_time('d M y');?></span></p>
                                                <a href="<?php the_permalink(); ?>"><h3><?php the_title();?></h3></a>
                                                <p><?php echo get_excerpt(35); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>

                            <?php endwhile;endif;?>
                            </div>
                        </div>
                        <?php $count=0;?>
                        <div class="list-category-ajax">
                            <?php if(have_posts()): while(have_posts()): the_post(); $count++?>
                                <?php if ($count > 2) { ?>
                                    <div class="loop-list loop-list-load">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="content-image">
                                                <?php
                                                if ( has_post_thumbnail() ) {
                                                    the_post_thumbnail();
                                                }
                                                else { ?>
                                                    <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
                                                <?php }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <div class="content-des">
                                                <p class="name-cat">
                                                <?php $category = get_the_category(); ?>
                                                <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                                                <span><?php the_time('d M y');?></span></p>
                                                <a href="<?php the_permalink(); ?>"><h3><?php the_title();?></h3></a>
                                                <p><?php echo get_excerpt(100); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            <?php endwhile;endif;?>
                        </div>
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