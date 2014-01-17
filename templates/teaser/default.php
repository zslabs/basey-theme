<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
	<?php do_action( 'basey_post_inside_before' ); ?>

	<header>
		<h3 class="entry-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
	</header>
	<?php

	$content = strip_shortcodes(get_the_content());
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]>', $content);
	if (!empty($content)) {
		echo '<div class="entry-content">';
			echo '<p>'.wp_trim_words( $content, apply_filters( 'basey_teaser_word_count', 55) ).'</p>';
		echo '</div>';
	}

	basey_page_nav();

	do_action( 'basey_post_inside_after' ); ?>
</article>