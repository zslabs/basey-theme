<p class="meta">
	<?php echo __('Written by', 'basey'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a>
	<time class="published" datetime="<?php echo get_the_time('c'); ?>"> on <?php echo get_the_date(); ?></time>.
	<?php echo __( 'Posted in ', 'basey' ); the_category( ', ' ); ?>
	<?php

	$tag = get_the_tags();
	if ( $tag ) {
		echo '<br>';
		the_tags();
	}

	echo '<br>';
	comments_popup_link( __( ' 0 Comments', 'blank' ), __( ' 1 Comment', 'blank' ), __( ' % Comments', 'blank' ), 'comments-link', __( 'Comments closed', 'blank' ) );

	?>
</p>