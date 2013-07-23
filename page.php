<?php

get_header();
	do_action( 'basey_main_before' );
		do_action( 'basey_content_before' );
			get_template_part( 'loop', 'page' );
		do_action( 'basey_content_after' );
	do_action( 'basey_main_after' );
get_footer();