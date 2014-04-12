<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
	<?php do_action( 'basey_post_inside_before' ); ?>

	<header>
		<h2 class="entry-title"><?php the_title(); ?></h2>
		<?php

		if (has_post_thumbnail()) { ?>
			<figure class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</figure>
		<?php }
		get_template_part('templates/partials/post-header'); ?>
	</header>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php basey_page_nav();

	comments_template('/templates/comments.php');
	do_action( 'basey_post_inside_after' ); ?>
</article>