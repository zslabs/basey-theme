<article <?php post_class('uk-article') ?> id="post-<?php the_ID(); ?>">
	<?php do_action( 'basey_post_inside_before' ); ?>

	<header>
		<h2 class="uk-article-title"><?php the_title(); ?></h2>
	</header>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php wp_link_pages();

	do_action( 'basey_post_inside_after' ); ?>
</article>