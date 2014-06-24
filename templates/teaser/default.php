<article <?php post_class('uk-article') ?> id="post-<?php the_ID(); ?>">
	<?php do_action( 'basey_post_inside_before' ); ?>

	<header>
		<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
	</header>
	<?php

	echo '<div class="entry-content">';
		$content = strip_shortcodes(get_the_content());
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]>', $content);

		echo '<p>' . wp_trim_words( $content, apply_filters( 'basey_teaser_word_count', 55) ) . '</p>';
	echo '</div>'; ?>
	<div class="uk-clearfix">
		<?php

		wp_link_pages();
		edit_post_link(__('Edit this post', 'basey'), '<p><i class="uk-icon-pencil"></i> ','</p>');

		?>
	</div>
	<?php do_action( 'basey_post_inside_after' ); ?>
</article>