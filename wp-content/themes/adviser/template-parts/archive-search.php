<div class="loop-list loop-list-load">
  <div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="content-image">
        <?php
        if ( has_post_thumbnail() ) {
        the_post_thumbnail('listing-article');
        }
        else {
        ?>
        <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
        <?php
        }
        ?>
        <span class="overlay"></span>
      </div>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
      <div class="content-des">
        <p class="name-cat">
          <?php $category = get_the_category(); ?>
          <a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
          <span><?php the_time('j M y');?></span>
        </p>
        <a href="<?php the_permalink(); ?>"><h3><?php the_title();?></h3></a>
        <p><?php echo the_excerpt(); ?></p>
      </div>
    </div>
  </div>
</div>