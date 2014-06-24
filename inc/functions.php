<?php

/**
 * Setup default theme actions
 * @return void
 */
function basey_setup() {
	// tell the TinyMCE editor to use editor-style.css
	add_editor_style( 'editor-style.css' );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );

	register_nav_menus(array(
		'primary' => __( 'Primary Menu', 'basey' ),
	));

	if ( ! isset( $content_width ) ) $content_width = 1000;

}
add_action( 'after_setup_theme', 'basey_setup' );

/**
 * Returns "nothing found" content
 * @return void
 */
function basey_no_results() { ?>

	<div data-alert class="alert-box alert">
		<p><?php _e('Sorry, no results were found . ', 'basey'); ?></p>
	</div>
	<?php get_search_form(); ?>

<?php }

/**
 * Pagination for various lists
 * @param  string $type
 * @return html
 * @source http://yootheme.com (Warp Themes)
 */
function basey_pagination($type = 'posts') {
	global $wp_query, $post, $wpdb;

	if ($type === 'comments' && !get_option('page_comments')) return;

	if (!isset($page) && !isset($pages)) {

		if ($type === 'posts') {
			$page = get_query_var('paged');
			$posts_per_page = intval(get_query_var('posts_per_page'));
			$pages = intval(ceil($wp_query->found_posts / $posts_per_page));

		} else {
			$comments = $wpdb->get_var("
				SELECT COUNT(*)
				FROM $wpdb->comments
				WHERE comment_approved = '1'
				AND comment_parent = '0'
				AND comment_post_ID = $post->ID");

			$page = get_query_var('cpage');
			$comments_per_page = get_option('comments_per_page');
			$pages = intval(ceil($comments / $comments_per_page));
		}

		$page = !empty($page) ? intval($page) : 1;
	}

	$output = array();

	if ($pages > 1) {

		$current = $page;
		$max     = 3;
		$end     = $pages;
		$range   = ($current + $max < $end) ? range($current, $current + $max) : range($current - ($current + $max - $end), $end);

		$output[] = '<ul class="uk-pagination">';

		$range_start = max($page - $max, 1);
		$range_end   = min($page + $max - 1, $pages);

		if ($page > 1) {

			$link     = ($type === 'posts') ? get_pagenum_link($page - 1) : get_comments_pagenum_link($page - 1);
			$output[] = '<li><a href="' . $link . '"><i class="uk-icon-angle-double-left"></i></a></li>';
		}

		for ($i = 1; $i <= $end; $i++) {

			if ($i == 1 || $i == $end || in_array($i, $range)) {

				if ($i == $page) {
					$output[] = '<li class="uk-active"><span>' . $i . '</span></li>';
				} else {
					$link  = ($type === 'posts') ? get_pagenum_link($i) : get_comments_pagenum_link($i);
					$output[] = '<li><a href="' . $link . '">' . $i . '</a></li>';
				}

			} else{
				$output[] = '#';
			}
		}

		if ($page < $pages) {
			$link     = ($type === 'posts') ? get_pagenum_link($page+1) : get_comments_pagenum_link($page+1);
			$output[] = '<li><a href="' . $link . '"><i class="uk-icon-angle-double-right"></i></a></li>';
		}

		$output[] = '</ul>';
		$output   = preg_replace('/>#+</', '><li><span>...</span></li><', implode("", $output));

		echo $output;
	}
}

/**
 * Add UIkit class for avatars
 * @param  string $class
 * @return string
 */
function basey_avatar_class($class) {
	$class = str_replace("class='avatar", "class='uk-comment-avatar", $class) ;
	return $class;
}
add_filter('get_avatar','basey_avatar_class');

/**
 * Adjust captions to not include width inline
 * @param  string $output
 * @param  array $attr
 * @param  strin $content
 * @return string
 */
function basey_caption($output, $attr, $content) {
	if (is_feed()) {
		return $output;
}

	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	$attr = shortcode_atts($defaults, $attr);

	// If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
	if (1 > $attr['width'] || empty($attr['caption'])) {
		return $content;
	}

	// Set up the attributes for the caption <figure>
	$attributes  = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '' );
	$attributes .= ' class="uk-thumbnail ' . esc_attr($attr['align']) . '"';

	$output  = '<figure' . $attributes  . '>';
	$output .= do_shortcode($content);
	$output .= '<figcaption class="uk-thumbnail-caption">' . $attr['caption'] . '</figcaption>';
	$output .= '</figure>';

	return $output;
}

add_filter('img_caption_shortcode', 'basey_caption', 10, 3);

/**
 * Returns page titles based on context
 * @return void
 */
function basey_title() {
	if (is_home()) {
		if (get_option('page_for_posts', true)) {
			echo get_the_title(get_option('page_for_posts', true));
		} else {
			_e('Latest Posts', 'basey');
		}
	} elseif (is_archive()) {
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		if ($term) {
			echo $term->name;
		} elseif (is_post_type_archive()) {
			echo get_queried_object()->labels->name;
		} elseif (is_day()) {
			printf(__('Daily Archives: %s', 'basey'), get_the_date());
		} elseif (is_month()) {
			printf(__('Monthly Archives: %s', 'basey'), get_the_date('F Y'));
		} elseif (is_year()) {
			printf(__('Yearly Archives: %s', 'basey'), get_the_date('Y'));
		} elseif (is_author()) {
			$author = get_queried_object();
			printf(__('Author Archives: %s', 'basey'), $author->display_name);
		} else {
			single_cat_title();
		}
	} elseif (is_search()) {
		printf(__('Search Results for %s', 'basey'), get_search_query());
	} elseif (is_404()) {
		_e('Not Found', 'basey');
	} else {
		the_title();
	}
}