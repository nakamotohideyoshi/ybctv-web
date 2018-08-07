<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="bread">
                        <?php if ( function_exists('yoast_breadcrumb') )
                        {
                          yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                        } ?>
                    </div>
<div class="spost-head">
                                <?php if (is_singular('post')) { ?>

                                <?php }?>
                                <h1 class="title-single"><?php echo the_title();?></h1>
								<p class="article-date">By <?php coauthors_posts_links(', '); ?>, <?php the_time('j M y');?></p>
                                <?php
                                  $tag_list = get_the_tag_list('<p class="tag-post">Tags: ', ' | ', '</p>');
                                  if ($tag_list) {
                                    echo $tag_list;
                                  }
                                ?>
                                </span></p>

                                <div class="like_button clearfix">
                                    <?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) {
                                        ADDTOANY_SHARE_SAVE_KIT( array(
                                            'buttons' => array( 'email','facebook', 'twitter', 'linkedin', 'print' ),
                                        ) );
                                    } ?>



                                    <?php
                                      if( is_user_logged_in() ) {
                                        $websiteId = get_current_blog_id();
                                        $user_id = get_current_user_id();
                                        $savedarr = get_user_meta($user_id, 'saved_posts');
                                        $savedposts = $savedarr[0];
                                        if (!$savedarr) {
                                          $savedinit = Array();
                                          add_user_meta($user_id, 'saved_posts', $savedinit);
                                        }

                                        $post_id = get_the_ID();

                                          if (isset($_POST['savepost'])) {
                                            $chkfrm = $_POST['savepost'];
                                            if (!in_array($post_id, $savedposts)) {
                                              array_push($savedposts, $post_id);
                                              $savedposts = update_user_meta($user_id, 'saved_posts', $savedposts);
                                            }
                                          } else {
                                            //
                                          }

                                        if ( !in_array($post_id, $savedposts) ) {
                                          if (!$chkfrm) {
                                        ?>

                                      <form method="post" id="savepostform">

                                        <input type="hidden" name="savepost" value="1">
                                        <button type="submit" id="savepost"><i class="fa fa-bookmark"></i></button>
                                      </form>

                                      <?php }

                                      else { ?>
                                        <p class="saved">Saved to your posts!</p>
                                      <?php }}} ?>
                                </div>
                            </div>
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
                                          the_post_thumbnail('main-article');
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
									  echo '<p class="article-date-bottom">By ';
									coauthors_posts_links(', '); ?>, <?php the_time('j M y');
									echo '</p>';
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
                                  if (wp_is_mobile()) {
                                    echo '<div style="max-width: 300px; margin: 30px auto 0 auto">';
                                    lastWordAdUnit2('lhs-mpu');
                                    echo '</div>';
                                  }
                                ?>
                              </div>



	<div class="related-post clearfix">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h2>Related Content</h2>

                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <ul class="related">
                                    <?php
                                    $count = 0;
                                    $args = array(
                                        'posts_per_page' => 4, // How many items to display
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
                                    foreach( $wpex_query->posts as $post ) : setup_postdata( $post ); $count++;
                                        $current_permalink = get_the_permalink();
                                        $current_title = get_the_title();

                                        ?>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="loop-list row">
                                                    <div class="content-image related-image col-md-5">
                                                      <?php
                                                      if ( has_post_thumbnail() ) {
                                                          the_post_thumbnail('section-article');
                                                      }
                                                      else { ?>
                                                          <a href="<?php echo $current_permalink; ?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo $current_title;?>" /></a>
                                                      <?php }
                                                      ?>
                                                        <span class="overlay"></span>
                                                    </div>
                                                    <div class="content-des col-md-7">
                                                        <p class="name-cat">
                                                            <?php $category = get_the_category(); ?>
                                                            <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
                                                        </p>
                                                        <a href="<?php echo $current_permalink; ?>"><h3 class="related-title"><?php echo $current_title;?></h3></a>
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
                                <?php
                                  if(wp_is_mobile()) {
                                    ?>
                                    <div style="width: 300px; margin: 0 auto;">
                                    <?php
                                    lastWordAdUnit2('native-content-mobile');
                                    ?>
                                    </div>
                                    <?php
                                  }
                                  else {
                                    lastWordAdUnit2('native-content-desktop');
                                  }
                                ?>
                            </div>
                        </div>
                    </div>
</article><!-- #post-## -->
