<?php

get_header();
	do_action( 'basey_main_before' );
		do_action( 'basey_content_before' );
			echo '<h1>' . apply_filters( 'basey_404_page_title', __( 'Page not found', 'basey' ) ) . '</h1>';
			echo basey_404_page_content();
		do_action( 'basey_content_after' );
	do_action( 'basey_main_after' );
get_footer();