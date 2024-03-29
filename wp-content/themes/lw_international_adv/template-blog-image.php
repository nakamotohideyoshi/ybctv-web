<?php
/**
 * Template Name: Blog Feature Image
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
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
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
                            	<div class="page-description"><?php the_content();?></div>
                            </div><!-- .page-header -->
                        <?php endwhile;endif;?>

                        <div class="list-category">
                        	<h2><?php the_title();?> Spotlight</h2>
                        	<div class="row">
                                <?php
                                $category_page    =   get_post_meta($post->ID,'category_page', TRUE);
                                $args = array( 'posts_per_page' => 2,'showposts' => 2, 'category' => $category_page );
                                $myposts = get_posts( $args );
                                foreach ( $myposts as $post ) : setup_postdata( $post );
                                $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE);
                                ?>
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
                                                <span><?php the_time('j M y');?></span></p>
		                                        <!-- <a href="<?php the_permalink(); ?>"><h3><?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?></h3></a> -->
		                                        <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
		                                        <p><?php echo get_excerpt(35); ?></p>
                                                <span class="spon">Sponsored by</span><?php echo $lw_sponsored;?>
		                                    </div>
										</div>
									</div>
                            <?php endforeach;
                            wp_reset_postdata();?>
                        	</div>
                        </div>

                        <div class="list-category-ajax">
                            <?php
                            $category_page    =   get_post_meta($post->ID,'category_page', TRUE);
                            $args = array( 'offset'=>2, 'category' => $category_page );
                            $myposts = get_posts( $args );
                            foreach ( $myposts as $post ) : setup_postdata( $post );
                            $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE);
                            ?>
                                <div class="loop-list loop-list-load">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <?php
                                                $isVideo = get_post_meta($post->ID,'lw_primary_medium')[0];
                                            ?>
                                            <div class="content-image<?php echo ($isVideo == 'video' ? 'has-video': '');?>">
                                                <?php
                                                if ( has_post_thumbnail() ) {
                                                    echo '<a href="' . get_the_permalink() . '">';
                                                    the_post_thumbnail();
                                                    echo ($isVideo == 'video' ? '<div class="voverlay"></div>': '');
                                                    echo '</a>';
                                                }
                                                else { ?>
                                                    <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" />
                                                        <?php echo ($isVideo == 'video' ? '<div class="voverlay"></div>': ''); ?>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <div class="content-des">
                                                <p class="name-cat">
                                                <?php $category = get_the_category(); ?>
                                                <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                                                <span><?php the_time('j M y');?></span></p>
                                                <!-- <a href="<?php the_permalink(); ?>"><h3><?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?></h3></a> -->
                                                <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                                                <p><?php echo get_excerpt(100); ?></p>
                                                <span class="spon">Sponsored by</span><?php echo $lw_sponsored;?>
                                            </div>
                                        </div>
                                    </div>
								</div>
                            <?php endforeach;
                            wp_reset_postdata();?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 right-side-wrap">
                    <?php get_sidebar('right');?>
                </div>
            </div>
        </div>

    </div><!-- #content -->
</section><!-- #primary -->
<?php get_footer();?>
