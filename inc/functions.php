<?php

/**
 * setup default theme actions
 * @return void
 */
function basey_setup() {
	// tell the TinyMCE editor to use editor-style.css
	add_editor_style('editor-style.css');

	// http://codex.wordpress.org/Post_Thumbnails
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(150, 150, false);

	add_theme_support('menus');

	// Sets the post revisions to 5
	if (!defined('WP_POST_REVISIONS')) { define('WP_POST_REVISIONS', 5); }

	if ( ! isset( $content_width ) ) $content_width = 900;

}
add_action('after_setup_theme', 'basey_setup');

/**
 * http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
function foundation_nav_bar() {
	wp_nav_menu(array(
		'container'       => false,                // remove menu container
		'container_class' => '',                   // class of container
		'menu'            => '',                   // menu name
		'menu_class'      => 'nav-bar',            // adding custom nav class
		'theme_location'  => 'main-menu',          // where it's located in the theme
		'before'          => '',                   // before each link <a>
		'after'           => '',                   // after each link </a>
		'link_before'     => '',                   // before each link text
		'link_after'      => '',                   // after each link text
		'depth'           => 2,                    // limit the depth of the nav
		'fallback_cb'     => 'main_nav_fb',        // fallback function (see below)
		'walker'          => new nav_bar_walker()  // walker to customize menu (see foundation-nav-walker)
	));
}

/**
 * http://codex.wordpress.org/Template_Tags/wp_list_pages
 */
function main_nav_fb() {
	echo '<ul class="nav-bar">';
	wp_list_pages(array(
		'depth'        => 0,
		'child_of'     => 0,
		'exclude'      => '',
		'include'      => '',
		'title_li'     => '',
		'echo'         => 1,
		'authors'      => '',
		'sort_column'  => 'menu_order, post_title',
		'link_before'  => '',
		'link_after'   => '',
		'walker'       => new page_walker(),
		'post_type'    => 'page',
		'post_status'  => 'publish'
	));
	echo '</ul>';
}

/**
 * return post entry meta information
 * @return string
 */
function basey_entry_meta() {
	echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('Posted on %s at %s.', 'basey'), get_the_date(), get_the_time()) .'</time>';
	echo '<p class="byline author vcard">'. __('Written by', 'basey') .' <a href="'. get_author_posts_url(get_the_author_meta('ID')) .'" rel="author" class="fn">'. get_the_author() .'</a></p>';
}

/**
 * return 404 page output
 * @return output buffer
 */
function basey_404_page_content() {

	ob_start(); ?>

	<p><?php echo __('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'basey'); ?></p>
	<p><?php _e('Please try the following:', 'basey'); ?></p>
	<ul>
		<li><?php _e('Check your spelling', 'basey'); ?> </li>
		<li><?php printf(__('Return to the <a href="%s">home page</a>', 'basey'), home_url()); ?></li>
		<li><?php _e('Click the <a href="javascript:history.back()">Back</a> button', 'basey'); ?></li>
	</ul>
	<?php get_search_form();

	$display = apply_filters('basey_404_page_content_output',ob_get_clean());
	return $display;
}

/**
 * returns 'nothing found' content
 * @return output buffer
 */
function basey_no_results_content() {

	ob_start(); ?>

	<article id="post-0" class="post no-results not-found">
		<header class="entry-header">
			<h1 class="entry-title"><?php _e( 'Nothing Found', 'basey' ); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'basey' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->

	<?php

	$display = apply_filters('basey_no_results_content_output',ob_get_clean());
	return $display;
}

/**
 * provides basic query info and output for pagination
 * @return string
 */
function basey_pagination() {
	global $wp_query;
	$total_pages = $wp_query->max_num_pages;
	$big = 999999999; // need an unlikely integer
	if ($total_pages > 1){
		$current_page = max(1, get_query_var('paged'));
		echo '<nav class="page-nav">';
		echo paginate_links(array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => $current_page,
			'total' => $total_pages,
			'prev_text' => 'Prev',
			'next_text' => 'Next'
		));
		echo '</nav>';
	}
}

/**
 * change number of search results to show on page
 * @param  array $query
 * @return array
 */
function basey_search_size($query) {
	$post_types_list = array();
	$args = array(
		'public'   => true
	);
	$output = 'names'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'
	$post_types = get_post_types($args,$output,$operator);
	$count = count($post_types);
	if ( $query->is_search && is_main_query() && !isset($_GET['post_type']) /*&& $query->query_vars['post_type'] != 'nav_menu_item'*/) // Make sure it is a search page
		$query->query_vars['posts_per_page'] = intval(get_option('posts_per_page')) * $count; // Multiplies the setting for posts_page_page by the number of post types publicly queryable

	return $query; // Return our modified query variables
}
add_filter('pre_get_posts', 'basey_search_size'); // Hook our custom function onto the request filter

/**
 * allows pages to be publicly queryable
 * @return void
 */
function basey_page_query() {
	if ( post_type_exists( 'page' ) ) {
		global $wp_post_types;
		$wp_post_types['page']->publicly_queryable = true;
	}
}
add_action( 'init', 'basey_page_query', 1 );

/**
 * if only one result is found on search, go to that page
 * @return void
 */
function basey_one_match_redirect() {
	if (is_search()) {
		global $wp_query;
		if ($wp_query->post_count == 1) {
			wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
		}
	}
}
add_action('template_redirect', 'basey_one_match_redirect');