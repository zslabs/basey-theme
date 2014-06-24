<article <?php post_class('uk-article') ?> id="post-<?php the_ID(); ?>">
	<?php do_action( 'basey_post_inside_before' ); ?>

	<header>
		<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php

		if (has_post_thumbnail()) {
			$width = get_option('thumbnail_size_w');
			$height = get_option('thumbnail_size_h');
		?>
		<figure class="uk-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail(array($width, $height), array('class' => '')); ?>
			</a>
		</figure>
		<?php } ?>
	</header>
	<?php

	echo '<div class="entry-content">';
		if (has_excerpt()) {
			the_excerpt();
		}
		else {
			$content = strip_shortcodes(get_the_content());
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]>', $content);

			echo '<p>' . wp_trim_words( $content, apply_filters( 'basey_teaser_word_count', 55) ) . '</p>';
		}
	echo '</div>';
	get_template_part('templates/teaser/post-meta');

	do_action( 'basey_post_inside_after' ); ?>
</article>