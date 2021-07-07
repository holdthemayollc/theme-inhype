<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to inhype_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package InHype
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;

// Custom comments form layout
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );

$comments_fields =  array(

  'author' =>
    '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'inhype' ) . '' .
    ( $req ? '<span class="required">*</span>' : '' ) .
    '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
    '" size="30"' . $aria_req . ' /></p>',

  'email' =>
    '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'inhype' ) . '' .
    ( $req ? '<span class="required">*</span>' : '' ) .
    '</label><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' /></p>',

  'url' =>
    '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'inhype' ) . '</label>' .
    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
    '" size="30" /></p>',
);

$comments_args = array(
    // change the title of send button
    'label_submit'=> esc_html__( 'Post comment', 'inhype' ),
    // change the title of the reply section
    //'title_reply'=>'Write a Reply or Comment',
    // remove "Text or HTML to be displayed after the set of comment fields"
    'comment_notes_after' => '',
    // redefine your own textarea (the comment body)
    'fields' => apply_filters( 'comment_form_default_fields', $comments_fields ),
     'comment_field' =>  '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
    '</textarea></p>',
);
?>


	<?php // You can start editing here -- including this comment! ?>
	<div class="clear"></div>
	<?php if ( have_comments() ) : ?>
		<div id="comments" class="comments-area">
		<h2 class="comments-title">
			<?php comments_number( esc_html__('0 Comments', 'inhype'), esc_html__('1 Comment', 'inhype'), esc_html__('% Comments', 'inhype') ); ?>
		</h2>
		<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<div class="message-comments-closed"><?php esc_html_e( 'Comments are closed.', 'inhype' ); ?></div>
		<?php endif; ?>


		<ul class="comment-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use inhype_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define inhype_comment() and that will be used instead.
				 * See inhype_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'inhype_comment' ) );
			?>
		</ul><!-- .comment-list -->


		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="nav-below" class="navigation-paging" role="navigation">
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="nav-previous col-md-2">
					<?php previous_comments_link( esc_html__( 'Older Comments', 'inhype' ) ); ?>
					</div>
					<div class="col-md-8 nav-text"><?php esc_html_e("Comments navigation", 'inhype'); ?></div>
					<div class="nav-next col-md-2">
					<?php next_comments_link( esc_html__( 'Newer Comments', 'inhype' ) ); ?>
					</div>
				</div>
			</div>
		</nav>
		<?php endif; // check for comment navigation ?>

		</div><!-- #if comments -->

		<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( comments_open() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<div class="comments-form-wrapper" id="comments-form-wrapper">
		<?php comment_form($comments_args); ?>
		</div>
		<?php endif; ?>

	<?php else: ?>
		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( comments_open() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<div class="comments-form-wrapper" id="comments-form-wrapper">
		<?php comment_form($comments_args); ?>
		</div>
		<?php endif; ?>

	<?php endif; // have_comments() ?>
