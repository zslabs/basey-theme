<?php

get_header();
	do_action( 'basey_main_before' );
		do_action( 'basey_content_before' );
			do_action( 'basey_loop_before' );
				get_template_part( 'loop', 'search' );
			do_action( 'basey_loop_after' );
		do_action( 'basey_content_after' );
	do_action( 'basey_main_after' );
get_footer();