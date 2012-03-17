<div id="comments-wrap">
<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!', 'azsimple'));

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'azsimple'); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
<?php // Begin Comments & Trackbacks ?>
<?php if ( have_comments() ) : ?>
<h3 id="comments-number"><?php comments_number(__('No Comments', 'azsimple'), __('1 Comment', 'azsimple'), __('% Comments', 'azsimple') );?><?php printf(__(' to &#8220;%s&#8221;', 'azsimple'), get_the_title()); ?></h3>

<ol class="commentlist">
	<?php wp_list_comments(); ?>
</ol>

	<div class="comments-navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

<?php // End Comments ?>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>

	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

<h3 class="postcomment"><?php comment_form_title( __('Leave a Reply', 'azsimple'), __('Leave a Reply to %s', 'azsimple') ); ?></h3>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php $urlRedirection = get_option('siteurl') . "/wp-login.php?redirect_to=" . urlencode(get_permalink()); ?><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'azsimple'), $urlRedirection); ?></p>

<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ( $user_ID ) : ?>

<p><?php $urlProfil = get_option('siteurl') . "/wp-admin/profile.php"; ?><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.', 'azsimple'), $urlProfil, $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', 'azsimple'); ?>"><?php _e('Log out &raquo;', 'azsimple'); ?></a></p>

	<?php else : ?>

	<p>
	<input type="text" name="author" id="author" class="textarea" value="<?php echo $comment_author; ?>" size="28" tabindex="1" />
	<label for="author"><?php _e('Name', 'azsimple'); ?></label> <?php if ($req) _e('*', 'azsimple'); ?>
	</p>

	<p>
	<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="28" tabindex="2" class="textarea" />
	<label for="email"><?php _e('E-mail', 'azsimple'); ?></label> <?php if ($req) _e('*', 'azsimple'); ?>
	</p>

	<p>
	<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="28" tabindex="3" class="textarea" />
	<label for="url"><?php _e('<acronym title="Uniform Resource Identifier">URI</acronym>', 'azsimple'); ?></label>
	</p>

	<?php endif; ?>

	<p>
	<textarea name="comment" id="comment" cols="60" rows="10" tabindex="4" class="textarea"></textarea>
	</p>

	<p>
	<input name="submit" id="submit" type="submit" tabindex="5" value="<?php _e('Submit Comment', 'azsimple'); ?>" class="Cbutton" />
	<?php comment_id_fields(); ?>
	</p>
	<?php do_action('comment_form', $post->ID); ?>
</form>
<?php endif; ?>
</div>
<?php else : // Comments are closed ?>
<p><?php _e('Sorry, the comment form is closed at this time.', 'azsimple'); ?></p>
<?php endif; ?>
</div>
