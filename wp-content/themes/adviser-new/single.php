<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>
<div class="col-md-3" id="sidebar">
  <div class="ads-placeholder ads-placeholder-article-left">
    <span></span>
  </div>
	</div>
	<section id="primary" class="content-area col-sm-12 col-lg-6">
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
	<div class="col-md-3" id="sidebar">
        <hr class="border-n"></hr>
		<h2 class="no-border">NEWSLETTER</h2>
		<P><b>Sign Up for Portfolio<BR> Adviser Daily Newsletter</b></p>
		<button type="button" class="btn btn-newsletter">Subscribe</button>
    <?php get_template_part('template-parts/sidebar', 'container'); ?>
	</div>

<?php
get_footer();
