<?php
/**
 * Template Name: Test
 */
?>
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

                        <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
                            <div class="page-header">
                                <h1 class="page-title"><?php the_title();?></h1>
                                <div class="page-description"><?php the_content();?></div>
                            </div><!-- .page-header -->
                        <?php endwhile;endif;?>

                        <div class="list-category">
                            <h2><?php the_title();?> Sportlight</h2>
                            <div class="row">
                                <?php
                                $category_page    =   get_post_meta($post->ID,'category_page', TRUE);
                                $args = array( 'posts_per_page' => 4,'showposts' => 4, 'category' => $category_page );
                                $myposts = get_posts( $args );
                                foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
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
                            <?php endforeach;
                            wp_reset_postdata();?>
                            </div>
                        </div>
                        
                        <div class="list-category-ajax sunset-posts-container">
                            <?php
                            $category_page    =   get_post_meta($post->ID,'category_page', TRUE);
                            $args = array( 'offset'=>4, 'category' => $category_page );
                            $myposts = get_posts( $args );
                            foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
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
                            <?php endforeach;
                            wp_reset_postdata();?>
                        </div>

                        <a class="btn btn-lg btn-default sunset-load-more" data-page="1" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
                            <span class="sunset-icon sunset-loading"></span> Load More
                        </a>
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