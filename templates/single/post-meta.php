<?php wp_link_pages(); ?>
<p class="uk-article-meta uk-clearfix">
	<?php

	$date = '<time datetime="'.get_the_date('Y-m-d').'">'.get_the_date().'</time>';
	printf(__('Written by %s on %s. Posted in %s', 'basey'), '<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" title="' . get_the_author() . '">' . get_the_author() . '</a>', $date, get_the_category_list(', '));

	the_tags('<br>' . __('Tags: ', 'basey'), ', '); ?>
</p>
<?php

edit_post_link(__('Edit this post', 'basey'), '<p><i class="uk-icon-pencil"></i> ','</p>');

if (pings_open()) : ?>
<p><?php printf(__('<a href="%s">Trackback</a> from your site.', 'basey'), get_trackback_url()); ?></p>
<?php endif; ?>

<?php if (get_the_author_meta('description')) : ?>
<div class="uk-panel uk-panel-box">
	<div class="uk-align-medium-left">
		<?php echo get_avatar(get_the_author_meta('user_email')); ?>
	</div>
	<h2 class="uk-h3 uk-margin-top-remove"><?php the_author(); ?></h2>
	<div class="uk-margin"><?php the_author_meta('description'); ?></div>
</div>
<?php endif;

comments_template('/templates/comments.php');