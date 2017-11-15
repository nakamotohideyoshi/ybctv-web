 <div class="content-category content-single contlocked">
    <?php if(have_posts()): while(have_posts()): the_post();
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
       if($lw_sponsored): ?>
         <p class="name-cat">Sponsored by <?php echo $lw_sponsored;?></p>
         <p>Published: <?php the_time('j M y');?></p>
      <?php endif; ?>
      <?php
       $tag_list = get_the_tag_list('<p class="tag-post">Tags: ', ' | ', '</p>');
       if ($tag_list):
         echo $tag_list;
       endif;
       ?>
      </span></p>
      <p><b>By <?php coauthors_posts_links(', '); ?>,</b> <?php the_time('j M y');?></p>
       <div class="content-post">
          <div class="description-single">
             <?php the_excerpt(); ?>
          </div>
          <div class="thump-single">
             <div class="feat-sponsor-logo marketintel">
                <img src="<?php echo THEME_PATH.'/images/T-Rowe-Price-logo-overimage.png' ?>" alt="T. Rowe Price"/>
             </div>
          </div>
          <p><strong>Expert Investor’s Market Intelligence section is for delegates to Expert Investor events only, sign in now and have access to: </strong></p>
          <ul style="margin-left: 25px;">
             <li><strong>Countries:</strong> Discover what European fund buyers think of all the major asset classes</li>
             <li><strong>Strategies:</strong> Explore forward-looking investment sentiments across Europe towards all the major asset classes</li>
             <li><strong>Fund Manager Sentiment:</strong> Learn about the house views of 20 global asset management groups with regards to a series of equities, bonds and other indices</li>
             <li><strong>European Fund Flows:</strong> Find out how monies have flown in and out of all active and passive European-domiciled funds</li>
          </ul>
          <p>If you wish to gain access to this, please contact <strong><a href="mailto:subscriptions@lastwordmedia.com">subscriptions@lastwordmedia.com</a></strong></p>
       </div>
    <?php endwhile;endif;?>
 </div>