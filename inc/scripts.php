<?php

/**
 * enqueue base styles
 * @return void
 */
function basey_styles() {
	// register default CSS file (location /css/style.css of current theme)
	if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/css/app.css' ) ) {
		$foundation_css = get_stylesheet_directory_uri() . '/css/app.css';
	}
	else {
		$foundation_css = get_template_directory_uri() . '/css/app.css';
	}
	wp_enqueue_style( 'basey-foundation', $foundation_css, false, BASEY_VER, 'all' );
}
add_action( 'wp_enqueue_scripts', 'basey_styles', 4 );

/**
 * enqueue child styles
 * @return void
 */
function basey_styles_child() {
	if ( is_child_theme() ) {
		wp_enqueue_style( 'basey-child-style', get_stylesheet_directory_uri() . '/css/style.css', false, BASEY_VER, 'all' );
	}
	else {
		wp_enqueue_style( 'basey-style', get_template_directory_uri() . '/css/style.css', false, BASEY_VER, 'all' );
	}
}
add_action( 'wp_enqueue_scripts', 'basey_styles_child', 9999);

/**
 * enqueue modernizr before all other scripts
 * @return void
 */
function basey_scripts_header() {
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.foundation.js', '', BASEY_VER, false );
}
add_action( 'template_redirect', 'basey_scripts_header', 8);

/**
 * enqueue base scripts
 * @return void
 */
function basey_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'basey-plugins', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'jquery-move', get_template_directory_uri() . '/js/jquery.event.move.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'jquery-swipe', get_template_directory_uri() . '/js/jquery.event.swipe.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-accordion', get_template_directory_uri() . '/js/jquery.foundation.accordion.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-alerts', get_template_directory_uri() . '/js/jquery.foundation.alerts.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-buttons', get_template_directory_uri() . '/js/jquery.foundation.buttons.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-clearing', get_template_directory_uri() . '/js/jquery.foundation.clearing.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-forms', get_template_directory_uri() . '/js/jquery.foundation.forms.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-joyride', get_template_directory_uri() . '/js/jquery.foundation.joyride.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-magellan', get_template_directory_uri() . '/js/jquery.foundation.magellan.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-mediaquerytoggle', get_template_directory_uri() . '/js/jquery.foundation.mediaQueryToggle.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-navigation', get_template_directory_uri() . '/js/jquery.foundation.navigation.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-orbit', get_template_directory_uri() . '/js/jquery.foundation.orbit.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-placeholder', get_template_directory_uri() . '/js/jquery.placeholder.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-reveal', get_template_directory_uri() . '/js/jquery.foundation.reveal.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-tabs', get_template_directory_uri() . '/js/jquery.foundation.tabs.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-tooltips', get_template_directory_uri() . '/js/jquery.foundation.tooltips.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-topbar', get_template_directory_uri() . '/js/jquery.foundation.topbar.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'foundation-offcanvas', get_template_directory_uri() . '/js/jquery.offcanvas.js', array( 'jquery' ), BASEY_VER, true );

	wp_enqueue_script( 'foundation-app', get_template_directory_uri() . '/js/app.js', array( 'jquery' ), BASEY_VER, true );
	wp_enqueue_script( 'basey-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), BASEY_VER, true );

	// register the 'comment-reply' JS if we are on a single post, comments are open and we have the 'thread_comments' options set
	if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'basey_scripts' );