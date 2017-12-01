<div class="most-viewed">
    <h2 class="title">MOST VIEWED</h2>
    <div class="list-most-viewed">
        <?php
          $no_of_days = (int)get_option('most_read_days');
          $start_date = date('Y-m-d', strtotime('-' . $no_of_days . ' days'));
          $args = array(
            'posts_per_page' => 5,
            'showposts' => 5,
            'date_query' => array(
              'after' => $start_date
            ),
            'meta_key' => 'lw_read_count',
            'orderby' => 'meta_value_num',
            'ignore_sticky_posts' => 1,
            'order' => 'DESC'
          );
          $myposts = get_posts( $args );
          $popcounter = 1;
          foreach ( $myposts as $post ) : setup_postdata( $post );
        ?>
        <div class="loop-list">
          <div class="content-des">
            <a href="<?php the_permalink(); ?>"><h4><span><?php echo $popcounter . ". "; ?></span><?php echo get_the_title(); ?></h4></a>
            <hr>
          </div>
        </div>
        <?php
          $popcounter++;
          endforeach;
          wp_reset_postdata();
        ?>
    </div>
</div>

