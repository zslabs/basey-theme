<?php

/**
 * Foundation version: 4.2.1
 */

if ( !defined( 'BASEY_VER' ) ) {
	define( 'BASEY_VER', '4.2.1' );
}

require_once locate_template( '/inc/scripts.php' );      // modified scripts output
require_once locate_template( '/inc/functions.php' );    // helper functions
require_once locate_template( '/inc/menus.php' );        // menu walkers
require_once locate_template( '/inc/teaser.php' );       // holds teaser views for search results and archive pages
require_once locate_template( '/inc/single.php' );       // holds full views for single pages
require_once locate_template( '/inc/custom.php' );       // custom functions
require_once locate_template( '/inc/output.php' );       // html output