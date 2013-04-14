<?php

/*-----------------------------------------------------------------------------------*/
/*	Custom Functionality

This section is used to add things like menus, sidebars or any other functions.php additions
that we'd normally bring in.

/*-----------------------------------------------------------------------------------*/

/**
 * register menus
 * http://codex.wordpress.org/Function_Reference/register_nav_menus
 * http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
register_nav_menus(array(
	'top-bar-l' => 'Left Top Bar',
	'top-bar-r' => 'Right Top Bar'
));

/**
 * register sidebars
 * add more by adding onto the $sidebar array
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

/**
 * define additional css/js
 * http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @return void
 */
function basey_custom_scripts() {
	$stylesheet_uri = get_stylesheet_directory_uri();
}
add_action( 'wp_enqueue_scripts', 'basey_custom_scripts' );