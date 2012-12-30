<?php

/*-----------------------------------------------------------------------------------*/
/*	Define HTML

This section is used to add your HTML output to the theme. If you look throughout the theme, you'll notice
several function() calls that share similarities baseyd on their position. Those are merely references to
WP actions that you can add content to (in this case - HTML output). This way, it keeps our core theme files
neat and allows us to change HTML on several pages easily (you can always use standard conditional template
logic)

/*-----------------------------------------------------------------------------------*/

/**
 * add menu to header
 * @return string
 */
function basey_head_output() {

	// leave .row open (closed in basey_footer_output())
	echo '<div class="row">';
		echo '<nav role="navigation">';
			foundation_nav_bar();
		echo '</nav>';
		echo '<div style="clear:both;"></div>';
}
add_action('basey_head','basey_head_output');

/**
 * footer output
 * @return string
 */
function basey_footer_output() {
	echo '<div class="panel">';
		dynamic_sidebar('basey-sidebar');
	echo '</div>';
	echo '</div>';
}
add_action('basey_footer','basey_footer_output');

/**
 * display query count and load time
 * @return string
 */
function basey_query_load_time() {
	echo '<p><strong>'.get_num_queries() . '</strong> queries in <strong>';
	timer_stop(1);
	echo '</strong> seconds</p>';
}
add_action('basey_debug','basey_query_load_time');