<?php
/*
 * The template for displaying Archive pages
 */

get_header(); ?>

<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <div class="content-page">
            <div class="container">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
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
                    <div class="content-category">
                        <?php if ( have_posts() ) : ?>
                            <div class="page-header">
                                <h1 class="page-title"><?php printf( __( '%s', TEXT_DOMAIN ), single_cat_title('',false )); ?></h1>
                                <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
                                <?php
                                    $cat_id = get_queried_object_id();

                                    $child = get_category($cat_id);
                                    $parent_ID = $child->parent;

                                    //Show only on countries and strategies
                                    if($cat_id == 26 || $cat_id == 21 ): //?>
                                    <div class="cat-sponsor-logo">
                                        <img src="<?php echo THEME_PATH.'/images/T-Rowe-Price-logo.png' ?>" />
                                    </div>
                                <?php endif; ?>

                            </div><!-- .page-header -->
                        <?php endif; ?>
                        <div class="list-category-ajax">
                          <?php
                            if(have_posts()): while(have_posts()): the_post();
                              include(locate_template('template-parts/archive-post.php'));
                            endwhile;endif;
                            ?>
                        </div>

<?php the_posts_navigation(); ?>
                        

                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 right-side-wrap">
                    <?php get_sidebar('right');?>
                </div>
            </div>
        </div>

    </div><!-- #content -->
</section><!-- #primary -->

<?php get_footer(); ?>
