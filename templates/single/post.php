<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
	<header>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php get_template_part('templates/entry-meta'); ?>
		<div class="taxonomy">
			<?php echo __( 'Posted in ', 'basey' ); the_category( ', ' ); ?>
		</div>
		<?php $tag = get_the_tags(); if ( !$tag ) { } else { ?><div class="tags"><?php the_tags(); ?></div><?php } ?>
		<div class="commentLinks"><?php comments_popup_link( __( ' 0 Comments', 'blank' ), __( ' 1 Comment', 'blank' ), __( ' % Comments', 'blank' ), 'scroll comments-link', __( 'Comments closed', 'blank' ) ); ?> <?php if ( comments_open() ) : ?>| <a class="scroll" href="<?php the_permalink(); ?>#respond" title="<?php echo __( 'Add a Comment', 'basey' ); ?>"><?php echo __( 'Add a Comment', 'basey' ); ?></a><?php endif; ?>
		</div>
	</header>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<footer>
		<?php wp_link_pages( array( 'before' => '<nav class="pagination"><p>' . __( 'Pages:', 'basey' ), 'after' => '</p></nav>' ) ); ?>
	</footer>
	<?php comments_template('/templates/comments.php'); ?>
</article>