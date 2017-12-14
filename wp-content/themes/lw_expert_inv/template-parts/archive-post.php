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
      <?php 
        $premium = get_post_meta($post->ID, 'lw_premium', true); 
        if($premium == 'yes') {
          //If premium
          if(!is_user_logged_in() ){ //If user is logged in?>
            <div class="content-des contlocked">
              <p class="name-cat">
                <?php
                  if(empty($category_id)){
                    $category_id = get_the_category()[0]->term_id;
                  }
                  $category = get_term_by('id', $category_id, 'category');
                  $terms = wp_get_post_terms( get_the_ID(), 'type');
                  $type = $terms[0]->name;
                ?>
                <a href="<?php echo get_category_link($category->term_id);?>">
                  <img src="<?php echo THEME_PATH.'/images/assets/padlock-small.svg' ?>" />
                  <?php echo $category->name;?></a>
                <?php if($type): ?>
                  <a href="<?php echo get_term_link($terms[0]->term_id);?>">
                  <?php if($category->name){
                    echo ' | ';
                  }?>  
                  <?php echo $type; ?>
                  </a>
                <?php endif; ?>   
                <span><?php the_time('j M y');?></span>
              </p>
              <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
              <p><?php echo the_excerpt(); ?></p>
              <?php
              //If is sponsored
              $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE);
              if($lw_sponsored){ ?>
                <p class="name-cat">Sponsored by <?php echo $lw_sponsored;?></p>
                <p>Published: <?php the_time('j M y');?></p>
              <?php } ?>
            </div>
            
          <?php } else { //If user is logged out?>
            <div class="content-des ">
              <p class="name-cat">
                <?php
                  if(empty($category_id)){
                    $category_id = get_the_category()[0]->term_id;
                  }
                  $category = get_term_by('id', $category_id, 'category');
                  $terms = wp_get_post_terms( get_the_ID(), 'type');
                  $type = $terms[0]->name;
                ?>
                <a href="<?php echo get_category_link($category->term_id);?>">
                  <?php echo $category->name;?></a>
                <?php if($type): ?>
                  <a href="<?php echo get_term_link($terms[0]->term_id);?>">
                  <?php if($category->name){
                    echo ' | ';
                  }?>  
                  <?php echo $type; ?>
                  </a>
                <?php endif; ?>   
                <span><?php the_time('j M y');?></span>
              </p>
              <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
              <p><?php echo the_excerpt(); ?></p>
              <?php
              //If is sponsored
              $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE);
              if($lw_sponsored){ ?>
                <p class="name-cat">Sponsored by <?php echo $lw_sponsored;?></p>
                <p>Published: <?php the_time('j M y');?></p>
            <?php } ?>
            </div>
          <?php }
          } else{
          //Not premium ?>
          <div class="content-des">
            <p class="name-cat">
             <?php $category = get_the_category();
 echo '<a class="category" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; ?>

<a> | <?php echo $type; ?> </a>
                      
              <span><?php the_time('j M y');?></span>
            </p>
            <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
            <p><?php echo the_excerpt(); ?></p>
            <?php
              //If is sponsored
              $lw_sponsored = get_post_meta($post->ID,'lw_sponsored', TRUE);
              if($lw_sponsored){ ?>
                <p class="name-cat">Sponsored by <?php echo $lw_sponsored;?></p>
                <p>Published: <?php the_time('j M y');?></p>
            <?php } ?>
          </div>

       <?php } ?>
    </div>
  </div>
</div>