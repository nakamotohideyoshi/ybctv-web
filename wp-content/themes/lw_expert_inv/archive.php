<?php
/*
 * The template for displaying Archive pages
 */

get_header(); ?>

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
                    <div class="content-category">
                        <?php if ( have_posts() ) : ?>
                            <div class="page-header">
                                <h1 class="page-title"><?php printf( __( '%s', TEXT_DOMAIN ), single_cat_title('',false )); ?></h1>
                                <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
                                <div class="cat-sponsor-logo">
                                    <img src="<?php echo THEME_PATH.'/images/T-Rowe-Price-logo.png' ?>" />
                                </div>
                            </div><!-- .page-header -->
                        <?php endif; ?>

                        <div class="list-category-ajax">
                            <?php if(have_posts()): while(have_posts()): the_post(); ?>
                                <div class="loop-list loop-list-load">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                          <?php
                                            $isVideo = get_post_meta($post->ID,'lw_primary_medium')[0];
                                          ?>
                                          <div class="content-image <?php echo ($isVideo == 'video' ? 'has-video': '');?>">
                                            <?php
                                              if ( has_post_thumbnail() ) {
                                                echo '<a href="' . get_the_permalink() . '">';
                                                the_post_thumbnail('listing-article');
                                                echo ($isVideo == 'video' ? '<div class="voverlay"></div>': '');
                                                echo '</a>';
                                              }
                                              else {
                                            ?>
                                            <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" />
                                            <?php echo ($isVideo == 'video' ? '<div class="voverlay"></div>': ''); ?>
                                            </a>
                                            <?php
                                              }
                                            ?>
                                          </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-12"> 

                                <?php //$locked = get_term_meta( $term->term_id, 'locked', true );
                                        $post_categories = get_the_category(get_the_ID()); 
                                        $term = get_option( "taxonomy_" . $post_categories[0]->term_id );
                                         
                                        $locked = $term['locked'];

                                        if($locked == '1') {
                                                
                                            if( !is_user_logged_in() ) { ?>

                                            <div class="content-des contlocked">
                                                <p class="name-cat">
                                                <a href="#"><img src="<?php echo THEME_PATH.'/images/assets/padlock-small.svg' ?>" /> SIGN IN TO ACCESS</a>
                                                <!-- <a href="<?php the_permalink(); ?>"><h3><?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?></h3></a> -->
                                                <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                                                <p><?php echo the_excerpt(); ?></p>
                                            </div>

                                            <?php } else { ?>

                                            <div class="content-des">
                                                <!-- <a href="<?php the_permalink(); ?>"><h3><?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?></h3></a> -->
                                                <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                                                <p><?php echo the_excerpt(); ?></p>
                                            </div>

                                            <?php }} 

                                            else { ?>

                                            <div class="content-des">
                                                <!-- <a href="<?php the_permalink(); ?>"><h3><?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?></h3></a> -->
                                                <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                                                <p><?php echo the_excerpt(); ?></p>
                                            </div>

                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
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

<?php get_footer(); ?>
