<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentytwelve_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

  <?php if ( have_comments() ) : ?>
  <span class="CommentTitle">Comments (<?php echo get_comments_number();?>)</span>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'plazart_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', TEXT_DOMAIN ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', TEXT_DOMAIN ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', TEXT_DOMAIN ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , TEXT_DOMAIN ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php
  $aria_req = ( $req ? " aria-required='true'" : '' );
    $args = array(
      'title_reply' => 'Leave a comment',
      'comment_notes_after' => '',
      'fields' => apply_filters( 'comment_form_default_fields',
        array(
          'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder="'.( $req ? 'Name (required)' : '' ).'" /></p>',
          'email' => '<p class="comment-form-email"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="'.( $req ? 'Email (required)' : '' ).'" /></p>',
        )
      ),
      'comment_field' => '<p class="comment-form-comment"><textarea  cols="45" rows="10" id="comment" name="comment" aria-required="true" placeholder="Your Comment"></textarea></p>',
    );
    comment_form( $args ); ?>

</div><!-- #comments .comments-area -->