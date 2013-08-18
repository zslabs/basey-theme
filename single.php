<?php

locate_template( 'templates/header.php', true, true );
	// determine if template is available
	$template_available = locate_template( 'templates/single/' . get_post_type() . '.php' ) ? get_post_type() : false;

	switch( get_post_type() ) {

		case $template_available :
			locate_template( 'templates/single/' . get_post_type() . '.php', true, false );
			break;

		default:
			locate_template( 'templates/single/default.php', true, false );
			break;
	}
locate_template( 'templates/footer.php', true, true );