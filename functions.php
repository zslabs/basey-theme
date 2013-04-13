<?php

/**
 * Foundation version: 4.1.2
 */

if ( !defined( 'BASEY_VER' ) ) {
	define( 'BASEY_VER', '4.1.2' );
}

require_once locate_template( '/inc/scripts.php' );      // modified scripts output
require_once locate_template( '/inc/functions.php' );    // helper functions
// require_once locate_template( '/inc/menus.php' );        // menu walkers
// Will be rewriting the menu walker to support the F4 top-bar soon
require_once locate_template( '/inc/teaser.php' );       // holds teaser views for search results and archive pages
require_once locate_template( '/inc/single.php' );       // holds full views for single pages
require_once locate_template( '/inc/custom.php' );       // custom functions
require_once locate_template( '/inc/output.php' );       // html output