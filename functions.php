<?php

/**
 * Foundation version: 4.3.1
 */

if ( !defined( 'BASEY_VER' ) ) {
	define( 'BASEY_VER', '4.3.1' );
}

require_once locate_template( '/inc/scripts.php' );      // modified scripts output
require_once locate_template( '/inc/init.php' );         // helper functions
require_once locate_template( '/inc/comments.php' );     // comment walker
require_once locate_template( '/inc/gallery.php' );      // gallery rewrite
require_once locate_template( '/inc/search.php' );       // search helpers
require_once locate_template( '/inc/menus.php' );        // menu walkers
require_once locate_template( '/inc/widgets.php' );      // widgets
require_once locate_template( '/inc/custom.php' );       // custom functions
require_once locate_template( '/inc/output.php' );       // html output