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
      <span class="overlay"></span>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
      <div class="content-des">
        <p class="name-cat">
         <?php $category = get_the_category();
 echo '<a class="category" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; ?>

<a> | <?php echo $type; ?> </a>
          <span><?php the_time('j M y');?></span>
        </p>
        <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
        <p><?php echo the_excerpt(); ?></p>
      </div>
    </div>
  </div>
</div>