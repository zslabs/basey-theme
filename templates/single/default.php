<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
	<?php do_action( 'basey_post_inside_before' ); ?>

	<header>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php basey_page_nav();

	do_action( 'basey_post_inside_after' ); ?>
</article>