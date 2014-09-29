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
 * Breadcrumbs
 * @return html
 * @source http://yootheme.com (Warp Themes)
 */
function basey_breadcrumbs() {
	global $wp_query;

	if (!is_home() && !is_front_page()) {

		$output = '<ul class="uk-breadcrumb uk-hidden-small">';

		$output .= '<li><a href="'.get_option('home').'">Home</a></li>';

		if (is_single()) {
			$cats = get_the_category();
			if ($cats) {
				$cat = $cats[0];
				if (is_object($cat)) {
					if ($cat->parent != 0) {
						$cats = explode("@@@", get_category_parents($cat->term_id, true, "@@@"));

						unset($cats[count($cats)-1]);
						$output .= str_replace('<li>@@','<li>', '<li>'.implode("</li><li>", $cats).'</li>');
					} else {
						$output .= '<li><a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a></li>';
					}
				}
			}
		}

		if (is_category()) {

			$cat_obj = $wp_query->get_queried_object();

			$cats = explode("@@@", get_category_parents($cat_obj->term_id, TRUE, '@@@'));

			unset($cats[count($cats)-1]);

			$cats[count($cats)-1] = '@@<span>'.strip_tags($cats[count($cats)-1]).'</span>';

			$output .= str_replace('<li>@@','<li class="uk-active">', '<li>'.implode("</li><li>", $cats).'</li>');
		} elseif (is_tag()) {
			$output .= '<li class="uk-active"><span>'.single_cat_title('',false).'</span></li>';
		} elseif (is_date()) {
			$output .= '<li class="uk-active"><span>'.single_month_title(' ',false).'</span></li>';
		} elseif (is_author()) {

			$user = get_user_by( 'login', get_the_author() );

			$output .= '<li class="uk-active"><span>'.$user->display_name.'</span></li>';
		} elseif (is_search()) {
			$output .= '<li class="uk-active"><span>'.stripslashes(strip_tags(get_search_query())).'</span></li>';
		} elseif (is_tax()) {
			$taxonomy = get_taxonomy (get_query_var('taxonomy'));
			$term = get_query_var('term');
			$output .= '<li class="uk-active"><span>'.$taxonomy->label .': '.$term.'</span></li>';
		} else {
			if (!in_array(get_post_type(), array('post', 'page'))) {
				$cpt = get_post_type_object( get_post_type() );

				$output .= '<li><a href="' . get_post_type_archive_link(get_post_type()) . '">' . $cpt->labels->name . '</a></li>';
			}
			$ancestors = get_ancestors(get_the_ID(), 'page');
			for($i = count($ancestors)-1; $i >= 0; $i--) {
				$output .= '<li><a href="'.get_page_link($ancestors[$i]).'" title="'.get_the_title($ancestors[$i]).'">'.get_the_title($ancestors[$i]).'</a></li>';
			}
			$output .= '<li class="uk-active"><span>'.get_the_title().'</span></li>';
		}

		$output .= '</ul>';

	} else {

		$output = '<ul class="uk-breadcrumb">';

		$output .= '<li class="uk-active"><span>Home</span></li>';

		$output .= '</ul>';

	}

	echo $output;
}

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
	$class = str_replace("class='avatar", "class='uk-comment-avatar uk-border-circle", $class) ;
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