<?php

// start loop
while (have_posts()) : the_post();

	switch($post->post_type) {

		case has_action( "basey_loop_teaser_{$post->post_type}" ) :
			do_action( "basey_loop_teaser_{$post->post_type}" );
		break;

		case 'post':
			echo basey_teaser_post();
		break;

		default:
			echo basey_teaser_default();
		break;
	}

endwhile;

// display navigation to next/previous pages when applicable
basey_pagination();

// if no posts
if ((!have_posts()) || (get_search_query() == ' ')) {
	do_action('basey_post_before');
	echo '<p>'._e('Sorry, no results were found.', 'basey').'</p>';
	do_action('basey_post_after');
}