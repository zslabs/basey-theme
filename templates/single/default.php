<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
	<?php do_action( 'basey_post_inside_before' ); ?>
		<header>
			<h1><?php echo apply_filters( 'basey_page_title', get_the_title() ); ?></h1>
		</header>
		<?php the_content();
		wp_link_pages( array( 'before' => '<nav class="pagination">', 'after' => '</nav>' ) ); ?>
	<?php do_action( 'basey_post_inside_after' ); ?>
</article>