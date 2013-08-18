<article id="post-<?php the_ID(); ?>" class="<?php echo join( ' ', get_post_class( 'infinite', get_the_ID() ) ); ?>">
<?php do_action( 'basey_post_inside_before' ); ?>
	<header>
		<a href="<?php echo get_permalink(); ?>"><?php echo apply_filters( 'basey_post_title', '<h2 class="entry-title">'.get_the_title().'</h2>' ); ?></a>
	</header>
	<div class="entry-content">
	<?php
		$content = strip_shortcodes(get_the_content());
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]>', $content );
		echo '<p>' . wp_trim_words( $content, apply_filters( 'basey_teaser_word_count', 55 ) ) . '</p>';
	?>
	</div>
	<?php do_action( 'basey_post_inside_after' ); ?>
</article>