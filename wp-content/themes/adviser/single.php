<?php
/*
 * The Template for displaying all single posts
 */

get_header(); ?>

<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <div class="content-page">
            <div class="container">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="content-left">
                        <div class="most-popular most-popular-new">
                            <h2>Most Popular News</h2>
                            <?php lastWordAdUnit('top-news-ad'); ?>
                            <div class="list-most-popular">
                                <?php
                                $popularpost = new WP_Query( array( 'posts_per_page' => 3, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );
                                while ( $popularpost->have_posts() ) : $popularpost->the_post();
                                ?>
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
                                <?php endwhile;wp_reset_postdata(); ?>

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
                        <?php if(have_posts()): while(have_posts()): the_post();
                            setReadCount(get_the_ID());
                            $lw_primary_medium = get_post_meta($post->ID,'lw_primary_medium', TRUE);
                            $lw_brightcove_video_id = get_post_meta($post->ID,'lw_brightcove_video_id', TRUE);
                        ?>
                            <div class="spost-head">
                                <?php if (is_singular('post')) { ?>
                                <p class="name-cat">
                                    <?php $category = get_the_category(); ?>
                                    <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                                </p>
                                <?php }?>
                                <h1 class="title-single"><?php the_title();?></h1>
                                <?php
                                  $tag_list = get_the_tag_list('<p class="tag-post">Tags: ', ' | ', '</p>');
                                  if ($tag_list) {
                                    echo $tag_list;
                                  }
                                ?>
                                </span></p>
                                <p><b>By <?php coauthors_posts_links(', '); ?>,</b> <?php the_time('j M y');?></p>
                                <div class="like_button clearfix">
                                    <?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) {
                                        ADDTOANY_SHARE_SAVE_KIT( array(
                                            'buttons' => array( 'email','facebook', 'twitter', 'linkedin' ),
                                        ) );
                                    } ?>
                                    <?php //echo do_shortcode('[ngfb buttons="email, facebook, linkedin, twitter"]');?>
                                </div>
                            </div>

                            <div class="content-post">
                              <div class="description-single">
                                  <?php the_excerpt(); ?>
                              </div>
                              <div class="thump-single">
                                <?php
                                  if ($lw_primary_medium == 'gallery') {
                                    // Only show gallery, no featured image or content
                                    last_word_gallery();
                                  }
                                  else {
                                    // All other primary mediums show content
                                    if ($lw_primary_medium == 'video') {
                                      // Don't show featured image
                                      if (isset($lw_brightcove_video_id) && $lw_brightcove_video_id != '') {
                                        brightcove_video($lw_brightcove_video_id);
                                      }
                                    }
                                    else {
                                      // All others show feature image
                                      if ( has_post_thumbnail() ) {
                                          the_post_thumbnail();
                                      }
                                    }

                                    echo '<div class="text-content">';

                                    global $page;
                                    if ($post->lw_pull_quote != '' && $page == 1) {

                                      $pullquote_after_paragraph = 5;

                                      $content = apply_filters('the_content', get_the_content());

                                      if (substr_count($content, '<p>') > $pullquote_after_paragraph) {
                                        $paragraphs = explode('</p>', $content);
                                        $paragraph_count = 1;

                                        foreach ($paragraphs as $paragraph) {
                                          echo $paragraph;

                                          echo '</p>';

                                          if ($paragraph_count == $pullquote_after_paragraph) {
                                            echo '<p class="pull-quote">' . $post->lw_pull_quote . '</p>';
                                          }

                                          $paragraph_count ++;
                                        }
                                      }
                                      else {
                                        echo $content;
                                        echo '<p class="pull-quote">' . $post->lw_pull_quote . '</p>';
                                      }
                                    }
                                    else {
                                      the_content();
                                    }

                                    wp_link_pages(array(
                                      'before'      => '<div class="page-links"><span class="page-links-title">Pages:</span>',
                                      'after'       => '</div>',
                                      'link_before' => '<span>',
                                      'link_after'  => '</span>',
                                      'pagelink'    => '<span class="screen-reader-text">Page </span>%',
                                      'separator'   => '<span class="screen-reader-text">, </span>',
                                    ));

                                    echo '</div>';
                                  }
                                ?>
                              </div>
                            </div>
                            <div class="comment-post">
                                <?php if ( comments_open() || get_comments_number() ) :
                                    comments_template();
                                endif;?>
                            </div>
                        <?php endwhile;endif;?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 right-side-wrap">
                    <?php get_sidebar('right');?>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="related-post clearfix">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <h2>Related</br>Content</h2>
                                <div id="bx-pager">
                                    <a data-slide-index="0" href=""><i class="fa fa-circle" aria-hidden="true"></i></a>
                                    <a data-slide-index="1" href=""><i class="fa fa-circle" aria-hidden="true"></i></a>
                                    <a data-slide-index="2" href=""><i class="fa fa-circle" aria-hidden="true"></i></a>
                                </div>
                                <a href="/register/" class="register">Sign up to our newsletter</a>
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
                                                        <a href="<?php the_permalink(); ?>"><h3><?php the_title();?></h3></a>
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
                </div>
            </div>
        </div>

    </div><!-- #content -->
</section><!-- #primary -->

<?php get_footer();?>
