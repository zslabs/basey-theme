<div class="uk-clearfix article-bottom">
	<?php wp_link_pages(); ?>
	<a class="uk-button" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php _e('Continue Reading', 'basey'); ?></a>
	<?php if (comments_open()) : ?>
		<button class="uk-button"><?php comments_popup_link(__('No Comments', 'basey'), __('1 Comment', 'basey'), __('% Comments', 'basey'), '', ''); ?></button>
	<?php endif; ?>
	<p class="uk-article-meta">
		<?php
			$date = '<time datetime="' . get_the_date('Y-m-d') . '">' . get_the_date() . '</time>';
			printf(__('Written by %s on %s. Posted in %s', 'basey'), '<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" title="' .get_the_author() . '">' . get_the_author() . '</a>', $date, get_the_category_list(', '));
		?>
	</p>
	<?php edit_post_link(__('Edit this post', 'basey'), '<p><i class="uk-icon-pencil"></i> ','</p>'); ?>
</div>