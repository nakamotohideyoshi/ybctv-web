<?php
/**
 * Template Name: Event
 */
?>
<?php get_header();?>
<section id="primary" class="content-area">
  <div id="content" class="site-content" role="main">
    <div class="content-page">
      <div class="container">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <div class="content-left">
            <?php get_sidebar('left');?>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="bread">
            <?php
              if(function_exists('bcn_display'))
              {
                bcn_display();
              }
            ?>
          </div>
          <div class="list-content-page">
            <?php
              if ( have_posts() ) : while (have_posts()) : the_post();
            ?>
            <div class="page-header">
              <h1 class="page-title"><?php the_title();?></h1>
              <div class="page-description"><?php the_content();?></div>
            </div><!-- .page-header -->
            <?php
              endwhile;endif;
            ?>
            <div class="list-event">
  						<?php
                query_posts(array(
                  'showposts' => 1,
                  'post_type' => 'event',
                  'meta_key' => 'lw_event_start_date',
                  'orderby' => 'meta_value_num',
                  'order' => 'ASC',
                  'meta_query' => array(
                    array(
                      'key' => 'lw_event_start_date',
                      'compare' => '>=',
                      'value' => $today
                    )
                  )
                ));
                if (have_posts()) : while (have_posts()) : the_post();
                  if ($post->lw_event_start_date) {
                    $event_start_date = new DateTime($post->lw_event_start_date);
                  }
                  else {
                    $event_start_date = '';
                  }

                  if ($post->lw_event_end_date) {
                    $event_end_date = new DateTime($post->lw_event_end_date);
                  }
                  else {
                    $event_end_date = '';
                  }
  						?>
              <div class="loop-list">
                <div class="row">
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="content-image">
                      <?php
                        if ( has_post_thumbnail() ) {
                          echo '<a' . ($post->lw_event_target_blank == 'yes' ? ' target="_blank"' : '') . ' href="' . $post->lw_event_link . '">';
                          the_post_thumbnail();
                          echo '</a>';
                        }
                        else {
                      ?>
                      <a<?php echo $post->lw_event_target_blank == 'yes' ? ' target="_blank"' : ''; ?> href="<?php $post->lw_event_link; ?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
                      <?php
                        }
                      ?>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="content-des">
                      <a<?php echo $post->lw_event_target_blank == 'yes' ? ' target="_blank"' : ''; ?> href="<?php echo $post->lw_event_link; ?>"><h3><?php echo get_the_title(); ?></h3></a>
                      <p class="date">
                        <?php
                          echo date_format($event_start_date, 'l jS F');
                          if ($event_end_date != '') {
                            echo ' - ' . date_format($event_end_date, 'l jS F');
                          }
                        ?>
                      </p>
                      <p><?php echo $post->lw_event_location; ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <?php
                endwhile;endif;
              ?>
            </div>
            <div class="list-event-ajax">
              <?php
                query_posts(array(
                  'offset' => 1,
                  'post_type' => 'event',
                  'meta_key' => 'lw_event_start_date',
                  'orderby' => 'meta_value_num',
                  'order' => 'ASC',
                  'meta_query' => array(
                    array(
                      'key' => 'lw_event_start_date',
                      'compare' => '>=',
                      'value' => $today
                    )
                  )
                ));

                if (have_posts()) : while (have_posts()) : the_post();
                  if ($post->lw_event_start_date) {
                    $event_start_date = new DateTime($post->lw_event_start_date);
                  }
                  else {
                    $event_start_date = '';
                  }

                  if ($post->lw_event_end_date) {
                    $event_end_date = new DateTime($post->lw_event_end_date);
                  }
                  else {
                    $event_end_date = '';
                  }
              ?>
              <div class="loop-list">
                <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="content-image">
                      <?php
                        if ( has_post_thumbnail() ) {
                          echo '<a' . ($post->lw_event_target_blank == 'yes' ? ' target="_blank"' : '') . ' href="' . $post->lw_event_link . '">';
                          the_post_thumbnail();
                          echo '</a>';
                        }
                        else {
                      ?>
                      <a<?php echo $post->lw_event_target_blank == 'yes' ? ' target="_blank"' : ''; ?> href="<?php $post->lw_event_link; ?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?>" /></a>
                      <?php
                        }
                      ?>
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="content-des">
                      <a<?php echo $post->lw_event_target_blank == 'yes' ? ' target="_blank"' : ''; ?> href="<?php echo $post->lw_event_link; ?>"><h3><?php echo get_the_title(); ?></h3></a>
                      <p class="date">
                        <?php
                          echo date_format($event_start_date, 'l jS F');

                          if ($event_end_date != '') {
                            echo ' - ' . date_format($event_end_date, 'l jS F');
                            }
                        ?>
                      </p>
                      <p><?php echo $post->lw_event_location; ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <?php
                endwhile;endif;
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-md-offset-1 col-sm-12 col-xs-12">
          <?php get_sidebar('right');?>
        </div>
      </div>
    </div>
  </div><!-- #content -->
</section><!-- #primary -->
<?php get_footer();?>
