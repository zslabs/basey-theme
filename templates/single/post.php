<article <?php post_class('uk-article') ?> id="post-<?php the_ID(); ?>">
	<?php

	do_action( 'basey_post_inside_before' );
	apply_filters( 'basey_show_breadcrumbs', basey_breadcrumbs() ); ?>

	<header>
		<h2 class="uk-article-title"><?php the_title(); ?></h2>
		<?php if (has_post_thumbnail()) : ?>
			<?php
			$width = get_option('thumbnail_size_w');
			$height = get_option('thumbnail_size_h');

			the_post_thumbnail(array($width, $height), array('class' => ''));

		endif; ?>
	</header>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php

	get_template_part( 'templates/single/post-meta' );
	do_action( 'basey_post_inside_after' ); ?>
</article>