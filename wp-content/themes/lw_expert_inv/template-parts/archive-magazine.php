<div class="loop-list">
  <div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="content-image">
        <?php
        if ( has_post_thumbnail() ) {
        echo '<a href="' . get_the_permalink() . '">';
          the_post_thumbnail();
        echo '</a>';
        }
        else {
        ?>
        <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
        <?php
        }
        ?>
      </div>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
      <div class="content-des">
        <p class="name-cat">Expert Investor Magazine</p>
        <a href="<?php the_permalink();?>"><h3><?php echo get_the_title(); ?></h3></a>
        <p><?php echo get_excerpt(100); ?></p>
        <p class="date">Published <?php the_time('j M y');?></p>
      </div>
    </div>
  </div>
</div>