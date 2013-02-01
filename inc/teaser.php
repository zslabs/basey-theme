<?php

/**
 * returns default post teaser view
 * @param  boolean $search are we on the search page or not?
 * @return output buffer
 */
function basey_teaser_post($search = false) {
	ob_start();

	do_action('basey_post_before'); ?>
	<article id="post-<?php the_ID(); ?>" class="<?php echo join( ' ', get_post_class( 'infinite', get_the_ID() ) ); ?>">
	<?php do_action('basey_post_inside_before'); ?>
		<header>
			<?php if (has_post_thumbnail()) : ?>
				<figure class="postThumbnail">
					<a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?></a>
				</figure>
			<?php endif; ?>
			<a href="<?php echo get_permalink(); ?>"><?php echo apply_filters('basey_post_title', '<h2 class="entry-title">'.get_the_title().'</h2>'); ?></a>
			<?php basey_entry_meta(); ?>
		</header>
		<div class="entry-content">
		<?php
			$content = ($search ? strip_shortcodes(get_the_content()) : get_the_content());
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]>', $content);
			echo '<p>'.wp_trim_words($content, apply_filters('basey_teaser_word_count',55)).'</p>';
		?>
		</div>
		<footer>
			<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'basey'), 'after' => '</p></nav>' )); ?>
			<div class="taxonomy">
				<?php echo __('Posted in ','basey'); the_category(', ', '' ); ?>
			</div>
			<?php $tag = get_the_tags(); if (!$tag) { } else { ?><div class="tags"><?php the_tags(); ?></div><?php } ?>
			<div class="comment-links">
				<?php
				$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
				if ( comments_open() ) {
					if ( $num_comments == 0 ) {
						$comments = __('No Comments','basey');
					} elseif ( $num_comments > 1 ) {
						$comments = $num_comments . __(' Comments','basey');
					} else {
						$comments = __('1 Comment','basey');
					}
					$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
				} else {
					$write_comments =  __('Comments are closed','basey');
				}
				echo $write_comments;
				?>
				<?php if ( comments_open() ) : ?>
					| <a href="<?php echo get_permalink(); ?>#respond" title="<?php echo __('Add a Comment','basey'); ?>"><?php echo __('Add a Comment','basey'); ?></a>
				<?php endif; ?>
			</div>
		</footer>
		<?php do_action('basey_post_inside_after'); ?>
	</article>
	<?php do_action('basey_post_after');

	$display = apply_filters('basey_teaser_post_view',ob_get_clean());
	return $display;
}

/**
 * returns default teaser view
 * @param  boolean $search are we on the search page or not?
 * @return output buffer
 */
function basey_teaser_default($search = false) {
	ob_start();

	do_action('basey_post_before'); ?>
	<article id="post-<?php the_ID(); ?>" class="<?php echo join( ' ', get_post_class( 'infinite', get_the_ID() ) ); ?>">
	<?php do_action('basey_post_inside_before'); ?>
		<header>
			<a href="<?php echo get_permalink(); ?>"><?php echo apply_filters('basey_post_title', '<h2 class="entry-title">'.get_the_title().'</h2>'); ?></a>
		</header>
		<div class="entry-content">
		<?php
			$content = ($search ? strip_shortcodes(get_the_content()) : get_the_content());
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]>', $content);
			echo '<p>'.wp_trim_words($content, apply_filters('basey_teaser_word_count',55)).'</p>';
		?>
		</div>
		<?php do_action('basey_post_inside_after'); ?>
	</article>
	<?php do_action('basey_post_after');

	$display = apply_filters('basey_teaser_default_view',ob_get_clean());
	return $display;
}

/**
 * returns default taxonomy view for search results
 * @param  object $term_object
 * @param  string $term_single
 * @return output buffer
 */
function basey_taxonomy_search_teaser_default($term_object,$term_single) {
	ob_start();

	do_action('basey_taxonomy_teaser_before'); ?>
	<article id="tax-<?php echo $term_object->term_id; ?>" class="<?php echo $term_object->taxonomy; ?>">
		<a href="<?php echo get_term_link($term_object); ?>"><?php echo $term_object->name; ?></a>
	</article>
	<?php
	do_action('basey_taxonomy_teaser_after');

	$display = apply_filters('basey_taxonomy_teaser_default_view', ob_get_clean());
	return $display;
}