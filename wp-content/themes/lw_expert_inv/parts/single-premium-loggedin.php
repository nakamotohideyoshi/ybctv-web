<div class="content-category content-single">
   <?php if(have_posts()): while(have_posts()): the_post();
      setReadCount(get_the_ID());
      $lw_primary_medium = get_post_meta($post->ID,'lw_primary_medium', TRUE);
      $lw_brightcove_video_id = get_post_meta($post->ID,'lw_brightcove_video_id', TRUE);
      ?>
       <div class="spost-head">
          <?php if (is_singular('post')): ?>
            <p class="name-cat">
               <?php $category = get_the_category(); ?>
               <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
            </p>
          <?php endif; ?>
          <h1 class="title-single"><?php the_title();?></h1>
          <?php
             $tag_list = get_the_tag_list('<p class="tag-post">Tags: ', ' | ', '</p>');
             if ($tag_list) {
               echo $tag_list;
             }
          ?>
          </span></p>
          <p><b>By <?php coauthors_posts_links(', '); ?>,</b> <?php the_time('j M y');?></p>
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
                    the_post_thumbnail('main-article');
                }
              }

              if ($lw_primary_medium == 'text') {
                ?>
                <div class="feat-sponsor-logo">
                   <img src="<?php echo THEME_PATH.'/images/T-Rowe-Price-logo-overimage.png' ?>" alt="T. Rowe Price"/>
                </div>
                <?php
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
            if (wp_is_mobile()) {
              echo '<div style="max-width: 300px; margin: 30px auto 0 auto">';
              lastWordAdUnit('lhs-mpu');
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
