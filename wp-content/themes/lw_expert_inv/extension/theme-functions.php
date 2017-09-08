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

// Add Category locked content option

function xg_edit_locked_category_field( $term ){
    $term_id = $term->term_id;
    $term_meta = get_option( "taxonomy_$term_id" );         
?>
    <tr class="form-field">
        <th scope="row">
            <label for="term_meta[locked]"><?php echo _e('Locked Content') ?></label>
            <td>
              <select name="term_meta[locked]" id="term_meta[locked]">
                  <option value="0" <?=($term_meta['locked'] == 0) ? 'selected': ''?>><?php echo _e('No'); ?></option>
                  <option value="1" <?=($term_meta['locked'] == 1) ? 'selected': ''?>><?php echo _e('Yes'); ?></option>
              </select>                   
            </td>
        </th>
    </tr>
<?php
} 

// Add the locked content dropdown to the Edit form
     
 add_action( 'category_edit_form_fields', 'xg_edit_locked_category_field' ); 

 // Save the locked content field
    
  function xg_save_tax_meta( $term_id ){ 
  
      if ( isset( $_POST['term_meta'] ) ) {
         
          $term_meta = array();
 
          // Be careful with the intval here.
          $term_meta['locked'] = isset ( $_POST['term_meta']['locked'] ) ? intval( $_POST['term_meta']['locked'] ) : '';
  
      // Save the option array.
          update_option( "taxonomy_$term_id", $term_meta );
   
      } 
  } // save_tax_meta
  
add_action( 'edited_category', 'xg_save_tax_meta', 10, 2 ); 

// Add the locked content dropdown to the Create form
 
add_action( 'category_add_form_fields', 'xg_edit_locked_category_field' );
add_action( 'create_category', 'xg_save_tax_meta', 10, 2 );    

// Add locked content column to Category list
  
  function xg_locked_category_columns($columns)
  {
      return array_merge($columns, 
                array('locked' =>  __('Locked')));
  }
  
  add_filter('manage_edit-category_columns' , 'xg_locked_category_columns');

// Add the value to the column
 
function xg_locked_category_columns_values( $deprecated, $column_name, $term_id) {
 
  if($column_name === 'locked'){ 
    
    $term_meta = get_option( "taxonomy_$term_id" );
    
    if($term_meta['locked'] === 1){
      
      echo _e('Yes');
    }else{
      echo _e('No');
    } 
  }
}
 
add_action( 'manage_category_custom_column' , 'xg_locked_category_columns_values', 10, 3 );