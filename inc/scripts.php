<?php

// Don't want Basey to load any assets?
// Add define( 'BASEY_NO_ASSETS', true ); to your wp-config.php file
if ( !defined( 'BASEY_NO_ASSETS') ) {

	// Don't want Basey to load any styles?
	// Add define ( 'BASEY_NO_CSS', true ); to your wp-config.php file
	if ( !defined( 'BASEY_NO_CSS' ) ) {

		/**
		 * enqueue base styles
		 * @return void
		 */
		function basey_styles() {
			wp_enqueue_style( 'foundation-app', get_template_directory_uri() . '/assets/css/app.css', false, BASEY_VER, 'all' );
		}
		add_action( 'wp_enqueue_scripts', 'basey_styles', 4 );
	}

	// Don't want Basey to load any javascript?
	// Add define ( 'BASEY_NO_JS', true ); to your wp-config.php file
	if ( !defined( 'BASEY_NO_JS' ) ) {

		/**
		 * Register Modernizr on init() (trick below)
		 * @return void
		 */
		function basey_register_modernizr() {
			wp_register_script( 'foundation-modernizr', get_template_directory_uri() . '/assets/js/vendor/custom.modernizr.js', '', BASEY_VER, false );
		}
		add_action( 'init', 'basey_register_modernizr' );

		/**
		 * Print Modernizr at the top of wp_head()
		 * Since we want this to load as soon as possible
		 * @return void
		 */
		function basey_print_modernizr() {
			wp_print_scripts( 'foundation-modernizr' );
		}
		add_action( 'wp_head', 'basey_print_modernizr', 4 );

		/**
		 * Enqueue scripts
		 * @return void
		 */
		function basey_scripts() {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'basey-plugins', get_template_directory_uri() . '/assets/js/custom/plugins.js', array( 'jquery' ), BASEY_VER, true );

			wp_enqueue_script( 'foundation', get_template_directory_uri() . '/assets/js/foundation/foundation.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-alerts', get_template_directory_uri() . '/assets/js/foundation/foundation.alerts.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-clearing', get_template_directory_uri() . '/assets/js/foundation/foundation.clearing.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-cookie', get_template_directory_uri() . '/assets/js/foundation/foundation.cookie.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-dropdown', get_template_directory_uri() . '/assets/js/foundation/foundation.dropdown.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-forms', get_template_directory_uri() . '/assets/js/foundation/foundation.forms.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-interchange', get_template_directory_uri() . '/assets/js/foundation/foundation.interchange.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-joyride', get_template_directory_uri() . '/assets/js/foundation/foundation.joyride.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-magellan', get_template_directory_uri() . '/assets/js/foundation/foundation.magellan.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-orbit', get_template_directory_uri() . '/assets/js/foundation/foundation.orbit.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-placeholder', get_template_directory_uri() . '/assets/js/foundation/foundation.placeholder.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-reveal', get_template_directory_uri() . '/assets/js/foundation/foundation.reveal.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-section', get_template_directory_uri() . '/assets/js/foundation/foundation.section.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-tooltips', get_template_directory_uri() . '/assets/js/foundation/foundation.tooltips.js', array( 'jquery' ), BASEY_VER, true );
			wp_enqueue_script( 'foundation-topbar', get_template_directory_uri() . '/assets/js/foundation/foundation.topbar.js', array( 'jquery' ), BASEY_VER, true );

			wp_enqueue_script( 'basey-scripts', get_template_directory_uri() . '/assets/js/custom/scripts.js', array( 'jquery' ), BASEY_VER, true );

			// Register the 'comment-reply' JS if we are on a single post, comments are open and we have the 'thread_comments' options set
			if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'basey_scripts' );
	}

}