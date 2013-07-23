<?php

while ( have_posts() ) : the_post();

	switch( $post->post_type) {

		case has_action( "basey_loop_single_{$post->post_type}" ) :
			do_action( "basey_loop_single_{$post->post_type}" );
		break;

		case 'post':
			echo basey_single_post();
		break;

		default:
			echo basey_single_default();
		break;
	}

endwhile;