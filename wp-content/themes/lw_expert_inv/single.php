<?php
   /*
    * The Template for displaying all single posts
    */

   get_header(); ?>
<section id="primary" class="content-area">
   <div id="content" class="site-content" role="main">
   <div class="content-page">
      <div class="container">
         <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <?php get_template_part('parts/single-content', 'left'); ?>
         </div>
         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="bread">
               <?php if(function_exists('bcn_display')):
                      bcn_display();
                  endif; ?>
            </div>
            <?php
               $premium = get_post_meta($post->ID, 'lw_premium', true);
               $categories = Array('marketint');
               $chkcat = in_category( $categories, $post->ID);
               $curuser = get_current_user_id();
               $product = get_user_meta($curuser, 'lw_product_ei_market_intelligence', true);

               if($premium == 'yes') {
                   if( !is_user_logged_in() ){
                    get_template_part('parts/single-premium', 'loggedout');
                   } else { 
                    get_template_part('parts/single-premium', 'loggedin');
                   } 
                } else {
                  if ($chkcat == true) {
                    if ($product != 'yes') {
                      if( !is_user_logged_in() ){
                        get_template_part('parts/single-content', 'loggedout');
                      } else { 
                        get_template_part('parts/single-content', 'loggedin');
                      }
                    } else { 
                      get_template_part('parts/single-content', 'product');
                    }
                  } else { 
                    get_template_part('parts/single-content', 'product');
                  }
                } ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 right-side-wrap">
               <?php get_sidebar('right');?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
               <?php get_template_part('parts/single-related', 'posts'); ?>
            </div>
         </div>
      </div>
   </div>
   <!-- #content -->
</section>
<!-- #primary -->
<?php get_footer();?>
