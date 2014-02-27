<?php

/**
 * Enqueue styles
 * @return void
 */
function basey_styles() {
	wp_enqueue_style( 'basey-styles', get_template_directory_uri() . '/assets/css/build/app.css', false, BASEY_VER, 'all' );
}
add_action( 'wp_enqueue_scripts', 'basey_styles', 12 );

/**
 * Enqueue Modernizr
 * @return void
 */
function basey_enqueue_modernizr() {
	wp_enqueue_script( 'basey-modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr.js', '', BASEY_VER, false );
}
add_action( 'wp_enqueue_scripts', 'basey_enqueue_modernizr', 8 );

/**
 * Add conditional IE scripts
 * @return void
 */
function basey_ie_scripts() { ?>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/build/ie.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/build/rem-fallback.css">
	<![endif]-->
<?php }
add_action( 'wp_head', 'basey_ie_scripts', 8 );

/**
 * Enqueue scripts
 * @return void
 */
function basey_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );

	// Register the 'comment-reply' JS if we are on a single post, comments are open and we have the 'thread_comments' options set
	if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'basey-scripts', get_template_directory_uri() . '/assets/js/build/scripts.min.js', array( 'jquery' ), BASEY_VER, true );
}
add_action( 'wp_enqueue_scripts', 'basey_enqueue_scripts' );