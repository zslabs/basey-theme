<?php

/**
 * single-view for posts
 * @return output buffer
 */
function basey_single_post() {

	global $post;
	ob_start();

	do_action('basey_post_before');?>
	<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<?php do_action('basey_post_inside_before'); ?>
			<header>
				<?php echo apply_filters('basey_post_title', '<h1>'.get_the_title().'</h1>'); ?>
				<?php basey_entry_meta($post->ID); ?>
				<div class="taxonomy">
					<?php echo __('Posted in ','basey'); the_category(', '); ?>
				</div>
				<?php $tag = get_the_tags(); if (!$tag) { } else { ?><div class="tags"><?php the_tags(); ?></div><?php } ?>
				<div class="commentLinks"><?php comments_popup_link( __( ' 0 Comments', 'blank' ), __( ' 1 Comment', 'blank' ), __( ' % Comments', 'blank' ), 'scroll comments-link', __('Comments closed', 'blank')); ?> <?php if ( comments_open() ) : ?>| <a class="scroll" href="<?php the_permalink(); ?>#respond" title="<?php echo __('Add a Comment','basey'); ?>"><?php echo __('Add a Comment','basey'); ?></a><?php endif; ?>
				</div>
			</header>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<nav class="pagination"><p>' . __('Pages:', 'basey'), 'after' => '</p></nav>' )); ?>
			</footer>
		<?php do_action('basey_post_inside_after'); ?>
		<?php comments_template(); ?>
	</article>
	<?php do_action('basey_post_after');

	$display = apply_filters('basey_single_post_view', ob_get_clean());
	return $display;
}

/**
 * default single-view (includes pages)
 * @return output buffer
 */
function basey_single_default() {

	global $post;
	ob_start();

	do_action('basey_post_before'); ?>
	<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<?php do_action('basey_post_inside_before'); ?>
			<header>
				<?php echo apply_filters('basey_page_title', '<h1>'.get_the_title().'</h1>'); ?>
			</header>
			<?php the_content();
			wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
		<?php do_action('basey_post_inside_after'); ?>
	</article>
	<?php do_action('basey_post_after');

	$display = apply_filters('basey_single_default_view', ob_get_clean());
	return $display;
}