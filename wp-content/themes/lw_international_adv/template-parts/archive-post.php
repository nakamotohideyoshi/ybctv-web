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
      <div class="content-des">
        <p class="name-cat">
          <?php
            $category = get_term_by('id', $category_id, 'category');
            $terms = wp_get_post_terms( get_the_ID(), 'type');
            $type = $terms[0]->name;
          ?>
          <a href="<?php echo get_category_link($category->term_id);?>"><?php echo $category->name;?></a>
          <?php if($type): ?>
            <a href="<?php echo get_term_link($terms[0]->term_id);?>">  
            <?php echo ' | '.$type; ?>
            </a>
          <?php endif; ?>   
          <span><?php the_time('j M y');?></span>
        </p>
        <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
        <p><?php echo the_excerpt(); ?></p>
      </div>
    </div>
  </div>
</div>
