<?php
/**
 * Template Name: Saved Articles
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
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <div class="bread">
                        <?php if(function_exists('bcn_display'))
                        {
                            bcn_display();
                        }?>
                    </div>
                    <div class="image-feature">
                        <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail();
                        }?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="list-content-page">
                        <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
                            <div class="page-header">
                            	<h1 class="page-title" style="display: none;"><?php the_title();?></h1>
                            	<div class="page-description"><?php the_content();?></div>
                            </div><!-- .page-header -->
                        <?php endwhile;endif;?>

                        <div class="list-category">
                        	<h2><?php the_title();?></h2>                        	
                        </div>

                        <div class="list-category-ajax">
                            <?php
                            // $category_page    =   get_post_meta($post->ID,'category_page', TRUE);
							$user_id = get_current_user_id();
							$saved_articles = get_user_meta( $user_id, '_saved_articles', true );
							$ids=array(0);
							if(is_array($saved_articles)){								
								foreach( $saved_articles as $key => $saved ){
									$id=substr($key, 3);
									if( $saved ){
										$ids[]=$id;
									}
								}
							}
							
							// print_r( $ids );
                            $args = array(
										'post_type'=>'post',
										// 'category' => $category_page,
										'post__in' => $ids,
										'post_per_page' => -1,
									);
                            $myposts = get_posts( $args );
							if($myposts):
                            foreach ( $myposts as $post ) : setup_postdata( $post );
                            // $  = get_post_meta($post->ID,'lw_sponsored', TRUE);
                            ?>
                                <div class="loop-list loop-list-load post-<?php the_ID(); ?>">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="content-image">
                                                <?php
                                                if ( has_post_thumbnail() ) {
                                                    the_post_thumbnail();
                                                }
                                                else { ?>
                                                    <a href="<?php the_permalink();?>"><img src="<?php echo THEME_PATH.'/images/not-image.jpg' ?>" alt="<?php the_title();?>" /></a>
                                                <?php }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <div class="content-des">
												<div class="col-md-6">
													<p class="name-cat">
													<?php $category = get_the_category(); ?>
													<a href="<?php echo get_category_link($category[0]->cat_ID);?>"><?php echo $category[0]->cat_name;?></a>
													<span><?php the_time('d M y');?></span></p>
												</div>
												<div class="col-md-6">
													<p class="action pull-right name-cat"><!-- <a href="#">Copy</a> | --> <a class="unsave-article" href="#" post-id="<?php the_ID(); ?>">Unsaved</a></p>
												</div>
												<div class="clearfix"></div>
                                                <!-- <a href="<?php the_permalink(); ?>"><h3><?php echo mb_strimwidth( get_the_title(), 0, 50, '...' ); ?></h3></a> -->
                                                <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                                                <p><?php echo get_excerpt(100); ?></p>												
                                            </div>
                                        </div>
                                    </div>
								</div>
                            <?php endforeach;
							else:
								echo '<p class="no-post">No saved article</p>';
							endif;
							
							
                            wp_reset_postdata();?>
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
<script>
	jQuery(".unsave-article").on( 'click', function(e){// when a div is clicked my form cames to the interface  
		var curr_element = jQuery(this);
		var saved = "true";
		var post_id = curr_element.attr('post-id');
		var article = jQuery('.loop-list.post-'+post_id);
		
		var data = {
			action: 'save_post_article',
			'post_id': post_id,                    
			'saved': saved,                    
		};
		
		jQuery.ajax({
			  type: "POST",
			  url: lastword.ajaxurl,
			  timeout: 30000,
			  data : data,
			  cache: false,
			  error: function(){
				   alert('server not responding');
				},
				success: function( response ) {
					var data = jQuery.parseJSON(response);
					console.log(data);
					if(!data.new_status){
						article.remove();
					}
				}
		});
		
		e.preventDefault();
	});
</script>
<?php get_footer();?>
