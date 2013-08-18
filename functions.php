<?php

/**
 * Foundation version: 4.3.1
 */

if ( !defined( 'BASEY_VER' ) ) {
	define( 'BASEY_VER', '4.3.1' );
}

locate_template( '/inc/scripts.php', true, true );      // modified scripts output
locate_template( '/inc/init.php', true, true );         // helper functions
locate_template( '/inc/comments.php', true, true );     // comment walker
locate_template( '/inc/gallery.php', true, true );      // gallery rewrite
locate_template( '/inc/search.php', true, true );       // search helpers
locate_template( '/inc/menus.php', true, true );        // menu walkers
locate_template( '/inc/widgets.php', true, true );      // widgets
locate_template( '/inc/custom.php', true, true );       // custom functions
locate_template( '/inc/output.php', true, true );       // html output