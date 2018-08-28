<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>
  <div class="row">
  <div class="col-lg-3 col-md-12 col-sm-12" id="sidebar">
    <?php lastWordAdUnit2('lhs-hpu-1'); ?>
    <?php lastWordAdUnit2('lhs-hpu-2'); ?>
  </div>
	<section id="primary" class="content-area col-sm-8 col-12 col-lg-6">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );



			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
    ?>
		</main><!-- #main -->
	</section><!-- #primary -->
	<div class="col-lg-3 col-md-4 col-sm-4 col-12" id="sidebar">
    <div class="newsletter-wrapper">
      <hr class="border-n"></hr>
		  <h2 class="no-border">NEWSLETTER</h2>
		  <p><b>Sign Up for Portfolio<br> Adviser Daily Newsletter</b></p>
		  <a href="/subscribe" class="btn btn-newsletter">Subscribe</a>
    </div>
    <?php get_template_part('template-parts/sidebar', 'container'); ?>
	 </div>
      </div>
<?php
get_footer();
