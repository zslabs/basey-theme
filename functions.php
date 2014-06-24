<?php

if ( !defined( 'BASEY_VER' ) ) {
	define( 'BASEY_VER', '5.3' );
}

locate_template( '/inc/assets.php', true, true );
locate_template( '/inc/functions.php', true, true );
locate_template( '/inc/comments.php', true, true );
locate_template( '/inc/gallery.php', true, true );
locate_template( '/inc/search.php', true, true );
locate_template( '/inc/menus.php', true, true );
locate_template( '/inc/widgets.php', true, true );
locate_template( '/inc/custom.php', true, true );
locate_template( '/inc/output.php', true, true );