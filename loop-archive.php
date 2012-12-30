<?php

global $wp_query;
$query_object = $wp_query->get_queried_object();
$post_type = $wp_query->query_vars['post_type'];

if(isset($query_object->taxonomy)) {
	switch($query_object->taxonomy) {

		case has_action( "basey_loop_archive_{$query_object->taxonomy}" ) :
			do_action( "basey_loop_archive_{$query_object->taxonomy}" );
		break;

		default:
			echo '<h2>';

			$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
			if ($term) {
				echo $term->name;
			} else {
				single_cat_title();
			}

			echo '</h2>';

			if (is_category() && (category_description() != '')) {
				echo '<div clas="cat-description">'.category_description().'</div>';
			}
			if(have_posts()) {
				while (have_posts()) : the_post();
					echo basey_teaser_post();
				endwhile;

				basey_pagination();
			}
		break;
	}
}
elseif(!empty($post_type)) {

	switch($post_type) {

		case has_action( "basey_loop_archive_{$post_type}" ) :
			do_action( "basey_loop_archive_{$post_type}" );
		break;

		default:
			if(have_posts()) {
				while (have_posts()) : the_post();
					echo basey_teaser_post();
				endwhile;

				basey_pagination();
			}
		break;
	}
}
else {
	echo '<h2>';

	if (is_day()) {
		printf(__('Daily Archives: %s', 'basey'), get_the_date());
	} elseif (is_month()) {
		printf(__('Monthly Archives: %s', 'basey'), get_the_date('F Y'));
	} elseif (is_year()) {
		printf(__('Yearly Archives: %s', 'basey'), get_the_date('Y'));
	} elseif (is_author()) {
		global $post;
		$author_id = $post->post_author;
		printf(__('Author Archives: %s', 'basey'), get_the_author_meta('user_nicename', $author_id));
				}

	echo '</h2>';

	if (is_category() && (category_description() != '')) {
		echo '<div clas="cat-description">'.category_description().'</div>';
			}
	if(have_posts()) {
		while (have_posts()) : the_post();
			echo basey_teaser_post();
		endwhile;

		basey_pagination();
	}
}