<?php
/**
 * Template Name: Panel
 */
?>
<?php get_header();?>
<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <div class="content-page">
            <div class="container">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="content-left">
                        <?php get_sidebar('left');?>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="bread">
                        <?php if(function_exists('bcn_display'))
                        {
                            bcn_display();
                        }?>
                    </div>
                    <div class="image-feature">
                        <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail();
                        }?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="list-content-page">
                        <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
                            <div class="page-header">
                            	<h1 class="page-title" style="display: none;"><?php the_title();?></h1>
                            	<div class="page-description panel-template"><?php the_content();?></div>
                            </div><!-- .page-header -->
                        <?php endwhile;endif;?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-md-offset-1 col-sm-12 col-xs-12 right-side-wrap">
                    <?php get_sidebar('right');?>
                </div>
            </div>
        </div>

    </div><!-- #content -->
</section><!-- #primary -->
<?php get_footer();?>
