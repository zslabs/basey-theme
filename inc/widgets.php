<?php

/**
 * Register sidebars
 * Add more by adding onto the $sidebar array
 * http://codex.wordpress.org/Function_Reference/register_sidebar
 * http://codex.wordpress.org/Function_Reference/get_sidebar
 * @return void
 */
function basey_custom_register_sidebars() {
	$sidebars = array( 'Sidebar' );

	foreach( $sidebars as $sidebar ) {
		register_sidebar(
			array(
				'id'            => 'basey-' . sanitize_title( $sidebar ),
				'name'          => __( $sidebar, 'basey' ),
				'description'   => __( $sidebar, 'basey' ),
				'before_widget' => '<article id="%1$s" class="widget %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></article>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
			)
		);
	}
}
add_action( 'widgets_init', 'basey_custom_register_sidebars' );