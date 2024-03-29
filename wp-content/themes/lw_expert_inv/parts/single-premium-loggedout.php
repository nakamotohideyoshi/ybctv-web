<div class="content-category content-single contlocked">
   <?php
   if(have_posts()): while(have_posts()): the_post();
      setReadCount(get_the_ID());
      $lw_primary_medium = get_post_meta($post->ID,'lw_primary_medium', TRUE);
      $lw_brightcove_video_id = get_post_meta($post->ID,'lw_brightcove_video_id', TRUE);
      ?>
      <?php if (is_singular('post')): ?>
         <p class="name-cat">
            <?php $category = get_the_category(); ?>
            <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><img src="<?php echo THEME_PATH.'/images/assets/padlock-small.svg' ?>" alt="Padlock"/><?php echo $category[0]->cat_name;?></a>
         </p>
      <?php endif; ?>
      <h1 class="title-single"><?php the_title();?></h1>
      <?php
         //If is sponsored
         $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE);
         if($lw_sponsored){ ?>
      <p class="name-cat">Sponsored by <?php echo $lw_sponsored;?></p>
      <p>Published: <?php the_time('j M y');?></p>
      <?php } ?>
      <?php
         $tag_list = get_the_tag_list('<p class="tag-post">Tags: ', ' | ', '</p>');
         if ($tag_list) {
           echo $tag_list;
         }
         ?>
      </span></p>
      <p><b>By <?php coauthors_posts_links(', '); ?>,</b> <?php the_time('j M y');?></p>
      <div class="content-post">
         <div class="description-single">
            <?php the_excerpt(); ?>
         </div>
         <div class="thump-single">
            <?php
               if ( has_post_thumbnail() ) {
                   the_post_thumbnail('main-article');
               }
               else { ?>
            <img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" />
            <?php }
               ?>
            <div class="feat-sponsor-logo">
               <img src="<?php echo THEME_PATH.'/images/T-Rowe-Price-logo-overimage.png' ?>" alt="T. Rowe Price"/>
            </div>
         </div>
         <p class="locked-notice">To access this content please sign in or register</p>
         <div class="locked-buttons">
            <a href="#" data-toggle="modal" data-target="#myModal" class="locked-button signin">Sign in</a>
            <a href="/register" class="locked-button">Register</a>
         </div>
         <p>Register now for full access to online content at Expert Investor plus receive:</p>
         <ul class="locked-list">
            <li>- Twice daily email news bulletins</li>
            <li>- Weekly news round-up</li>
            <li>- Monthly regional focus summary</li>
            <li>- Digital monthly edition of Expert Investor viewable across all devices</li>
         </ul>
         <hr>
         <p>For assistance please contact our customer service team or visit our <a href="#">FAQ page</a>.<br />
            Phone: +44 20 7382 4477<br />
            Email: subscriptions@lastwordmedia.com
        <?php
          if (wp_is_mobile()) {
            echo '<div style="max-width: 300px; margin: 30px auto 0 auto">';
            lastWordAdUnit('lhs-mpu');
            echo '</div>';
          }
        ?>
      </div>
   <?php endwhile;endif;?>
</div>
