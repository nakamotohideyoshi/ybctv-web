<?php

    function get_social_url(){
        $social_networks            = get_social_network();
        $size_social                = ot_get_option('social_network_size','30');

        echo"<ul>";
        foreach($social_networks as $social) {
            $social_url = ot_get_option('social_network_' . $social['id']);
            if($social_url) {
                ?>

            <li>
                <a href="<?php echo $social_url; ?>" class="socialfont size<?php echo $size_social; ?> fa fa-<?php echo $social['id']; ?>"></a>
            </li>

            <?php
            }
        }
        echo"</ul>";
    }
    function check_social(){
        $social_networks = get_social_network();
        $tz_social_arr   = array();
        foreach($social_networks as $social) {
        $social_url = ot_get_option('social_network_' . $social['id']);
             if($social_url){
                 $tz_social_arr[] = $social_url;
             }
        }
        $socialclass ="";
        $span_social = 'span7';
        $social_class = array();
        if(empty($tz_social_arr)){
            $social_class['class_sp'] = 'span10';
            $social_class['class'] = "socialnone";
        }else{
            $social_class['class_sp'] = $span_social;
            $social_class['class'] = $socialclass;
        }
        return $social_class;
    }

    function get_social_network(){
        return array(
            array('id' => 'facebook', 'title' => 'Facebook'),
            array('id' => 'twitter', 'title' => 'Twitter'),
            array('id' => 'flickr', 'title' => 'Flickr'),
            array('id' => 'dribbble', 'title' => 'Dribbble'),
            array('id' => 'dropbox', 'title' => 'Dropbox'),
            array('id' => 'google-plus', 'title' => 'Google Plus'),
            array('id' => 'linkedin', 'title' => 'linkedin'),
            array('id' => 'foursquare', 'title' => 'Foursquare'),
            array('id' => 'pinterest', 'title' => 'Pinterest'),
            array('id' => 'skype', 'title' => 'Skype'),
            array('id' => 'tumblr', 'title' => 'Tumblr'),
            array('id' => 'vimeo-square', 'title' => 'Vimeo'),
            array('id' => 'youtube', 'title' => 'Youtube'),
        );
    }

  if ( ! function_exists( 'plazart_comment' ) ) :
    function plazart_comment( $comment, $args, $depth ) {
      $GLOBALS['comment'] = $comment;
      switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        // Display trackbacks differently than normal comments.
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
          <p><?php _e( 'Pingback:', TEXT_DOMAIN ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', TEXT_DOMAIN ), '<span class="edit-link">', '</span>' ); ?></p>
        <?php
          break;
        default :
          // Proceed with normal comments.
          global $post;
          ?>
          <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment">
              <header class="comment-meta comment-author vcard">
                <?php echo get_avatar( $comment, 59 ); ?>
              </header><!-- .comment-meta -->

              <?php if ( '0' == $comment->comment_approved ) : ?>
              <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', TEXT_DOMAIN ); ?></p>
              <?php endif; ?>

              <section class="comment-content comment">
                <?php
                  printf( '<cite class="fn">%1$s %2$s</cite>',
                    get_comment_author_link(),
                    // If current post author is also comment author, make it known visually.
                    ( $comment->user_id === $post->post_author ) ? '<span> ' . __( '- Post Author ', TEXT_DOMAIN ) . '</span>' : ''
                  );
                  printf( '<a class="comments-datetime" href="%1$s">&nbsp;&nbsp;&nbsp;<time datetime="%2$s">%3$s</time></a>',
                    esc_url( get_comment_link( $comment->comment_ID ) ),
                    get_comment_time( 'c' ),
                    /* translators: 1: date, 2: time */
                    sprintf( __( '%1$s at %2$s', TEXT_DOMAIN ), get_comment_date('d M, Y'), get_comment_time() )
                  );
                edit_comment_link( __( ' <span style="color: #000;">|</span> Edit ', TEXT_DOMAIN ) );
                comment_reply_link( array_merge( $args, array( 'reply_text' => __( ' <span style="color: #000;">|</span> Reply', TEXT_DOMAIN ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
                comment_text();
                ?>
              </section><!-- .comment-content -->
              <div class="clearfix"></div>
            </article><!-- #comment-## -->
          <?php
          break;
      endswitch; // end comment_type check
    }
  endif;

  if ( ! function_exists( 'content_nav' ) ) :
    /**
     * Displays navigation to next/previous pages when applicable.
     */
    function content_nav( $html_id ) {
      global $wp_query;

      $html_id = esc_attr( $html_id );

      if ( $wp_query->max_num_pages > 1 ) : ?>
        <nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
          <div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>
          <div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
        </nav><!-- #<?php echo $html_id; ?> .navigation -->
      <?php endif;
    }
  endif;