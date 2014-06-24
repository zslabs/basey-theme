<?php
	if (post_password_required()) {
		return;
	}

 if (have_comments()) : ?>
 	<hr class="uk-article-divider">
	<section id="comments">
		<h3><?php printf(_n('One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'basey'), number_format_i18n(get_comments_number()), get_the_title()); ?></h3>

		<ul class="uk-comment-list">
			<?php wp_list_comments(array('walker' => new Basey_Walker_Comment)); ?>
		</ul>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments'))
			basey_pagination('comments');
		?>

		<?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
		<div class="uk-alert uk-alert-warning">
			<?php _e('Comments are closed.', 'basey'); ?>
		</div>
		<?php endif; ?>
	</section><!-- /#comments -->
<?php endif; ?>

<?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
	<section id="comments">
		<div class="uk-alert uk-alert-warning">
			<?php _e('Comments are closed.', 'basey'); ?>
		</div>
	</section><!-- /#comments -->
<?php endif; ?>

<?php if (comments_open()) : ?>
	<section id="respond">
		<h3><?php comment_form_title(__('Leave a Reply', 'basey'), __('Leave a Reply to %s', 'basey')); ?></h3>
		<p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
		<?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
			<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'basey'), wp_login_url(get_permalink())); ?></p>
		<?php else : ?>
			<form class="uk-form" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" data-parsley-validate>
				<?php if (is_user_logged_in()) : ?>
					<p>
						<?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', 'basey'), get_option('siteurl'), $user_identity); ?>
						<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Log out of this account', 'basey'); ?>"><?php _e('Log out &raquo;', 'basey'); ?></a>
					</p>
				<?php else : ?>
					<div class="uk-grid uk-grid-small" data-uk-grid-margin>
						<div class="uk-width-medium-1-3">
							<input class="uk-width-1-1" type="text" placeholder="<?php _e('Name', 'basey'); if ($req) _e(' (required)', 'basey'); ?>" name="author" value="<?php echo esc_attr($comment_author); ?>" <?php if ($req) echo 'data-parsley-required'; ?>>
						</div>
						<div class="uk-width-medium-1-3">
							<input class="uk-width-1-1" type="email" placeholder="<?php _e('Email', 'basey'); if ($req) _e(' (required)', 'basey'); ?>" name="email" value="<?php echo esc_attr($comment_author_email); ?>" <?php if ($req) echo 'data-parsley-required'; ?>>
						</div>
						<div class="uk-width-medium-1-3">
							<input class="uk-width-1-1" type="url" placeholder="<?php _e('Website', 'basey'); ?>" class="form-control" name="url" value="<?php echo esc_attr($comment_author_url); ?>">
						</div>
				<?php endif; ?>
						<div class="uk-width-1-1">
							<textarea placeholder="<?php _e('Comment', 'basey'); ?>" name="comment" class="uk-width-1-1" data-parsley-required></textarea>
						</div>
				<?php if (!is_user_logged_in()) : ?>
					</div>
				<?php endif; ?>
					<button class="uk-button uk-margin-top"><?php _e('Submit Comment', 'basey'); ?></button>
				<?php comment_id_fields(); ?>
				<?php do_action('comment_form', $post->ID); ?>
			</form>
		<?php endif; ?>
	</section><!-- /#respond -->
<?php endif;