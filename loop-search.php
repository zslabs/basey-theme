<?php

do_action('basey_search_header_before');

echo '<h1>' . apply_filters('basey_page_title_search', sprintf(__('Search Results','basey'))) . '</h1>';
echo '<h3>' . apply_filters('basey_search_query_title', sprintf(__('Search Results for %s','basey'),get_search_query())) . '</h3>';

$results = array();

if ( have_posts() ) {

	while ( have_posts() ) {

		the_post();

		// determines if we're using a taxonomy or not (for use with relavanssi plugin)
		if (isset($post->term_id)) {
			global $wp_taxonomies;

			$results['terms'][$post->post_type]['tax_name'] = $post->post_type;
			$results['terms'][$post->post_type]['single'] = $wp_taxonomies[$post->post_type]->labels->singular_name;
			$results['terms'][$post->post_type]['plural'] = $wp_taxonomies[$post->post_type]->labels->name;
			$results['terms'][$post->post_type]['term_ids'][] = $post->term_id;
		}
		else {
			$post_type_object = get_post_type_object(get_post_type());
			$results['post_types'][get_post_type()]['name'] = $post_type_object->name;
			$results['post_types'][get_post_type()]['single'] = $post_type_object->labels->singular_name;
			$results['post_types'][get_post_type()]['plural'] = $post_type_object->labels->name;
			$results['post_types'][get_post_type()]['ids'][] = get_the_ID();
		}

	}

	// DEBUG: Prints out current search results
	//print_r($results);

	// generates anchor links for each term/post type found
	if(!isset($_GET['post_type']) && !empty($results)) {
		echo '<ul id="results-overview-list">';
		if (!empty($results['terms'])) {
			foreach ($results['terms'] as $term) {
				$count = count($term['term_ids']);
				$term_name = $term['tax_name'];
				$term_name = ($count > 1 ? apply_filters("basey_search_results_{$term_name}_plural", $term['plural']) : apply_filters("basey_search_results_{$term_name}_single", $term['single']));
				echo '<li class="'.$term['tax_name'].'">'.sprintf(__('<a class="scroll" href="#%1$s">%2$s %3$s found</a>','basey'), $term['tax_name'],$count, $term_name).'</li>';
			}
		}
		if (!empty($results['post_types'])) {
			foreach ($results['post_types'] as $post_type) {
				$count = count($post_type['ids']);
				$post_type_name = $post_type['name'];
				$post_type_name = ($count > 1 ? apply_filters("basey_search_results_{$post_type_name}_plural", $post_type['plural']) : apply_filters("basey_search_results_{$post_type_name}_single", $post_type['single']));
				echo '<li class="'.$post_type['name'].'">'.sprintf(__('<a class="scroll" href="#%1$s">%2$s %3$s found</a>','basey'), $post_type['name'],$count, $post_type_name).'</li>';
			}
		}
		echo '</ul>';
	}

do_action('basey_search_header_after');

	// if terms are not empty, print each section and ultimately the terms within them out
	if (!empty($results['terms']) && !isset($_GET['post_type'])) {

		foreach ($results['terms'] as $term) {

			$tax_name = $term['tax_name'];
			echo '<section class="term" id="' . $tax_name . '">';

			$count = count($term['term_ids']);
			$term_name = $term['tax_name'];
			$term_name = ($count > 1 ? apply_filters("basey_search_results_{$term_name}_plural", $term['plural']) : apply_filters("basey_search_results_{$term_name}_single", $term['single']));
			echo '<h3>'.sprintf(__('%1$s %2$s found','basey'), $count, $term_name).'</h3>';

			do_action("basey_search_before_{$tax_name}");

			foreach ($term['term_ids'] as $term_single) {
				$term_object = get_term_by('id', $term_single, $tax_name);

				switch ($term['tax_name']) {

					case has_action( "basey_taxonomy_search_teaser_{$tax_name}" ) :
						do_action( "basey_taxonomy_search_teaser_{$tax_name}",$term_object, $term_single );
					break;

					default:
						echo basey_taxonomy_search_teaser_default($term_object,$term_single);
					break;
				}
			}

			do_action("basey_search_after_{$tax_name}");

			echo '</section>';
		}
	}

	// if post types are not empty, print each section and ultimately the posts within them out
	if (!empty($results['post_types'])) {
		foreach ($results['post_types'] as $post_type) {

			$post_type_name = $post_type['name'];

			// container around each post type for proper anchors
			echo '<section class="post-type" id="' . $post_type_name . '">';

			// count number of posts available
			$count = count($post_type['ids']);
			if(!isset($_GET['post_type'])) {
				$post_type_label = ($count > 1 ? apply_filters("basey_search_results_{$post_type_name}_plural", $post_type['plural']) : apply_filters("basey_search_results_{$post_type_name}_single", $post_type['single']));
				echo '<h3>'.sprintf(__('%1$s %2$s found','basey'), $count, $post_type_label).'</h3>';
				echo ($count > apply_filters('basey_search_results_limit',5) && (!isset($_GET['post_type'])) ? '<a class="search-more-button" href="'.add_query_arg('post_type',$post_type_name).'">'.__('More','basey').'</a>' : '');
			}

			do_action("basey_search_before_{$post_type_name}");

			$i = 0;
			foreach ($post_type['ids'] as $post) {
				$post = get_post($post);
				setup_postdata($post);
				$post_type_single = get_post_type();
				switch($post_type_single) {

					case has_action( "basey_loop_teaser_{$post_type_single}" ) :
						do_action( "basey_loop_teaser_{$post_type_single}" );
					break;

					case 'post':
						echo basey_teaser_post($search = true);
					break;

					default:
						echo basey_teaser_default($search = true);
					break;
				}

				if(!isset($_GET['post_type'])) {
					if (++$i == apply_filters('basey_search_results_limit',5)) break;
				}

				wp_reset_postdata();
			}

			do_action("basey_search_after_{$post_type_name}");

			// close container around each post type for proper anchors
			echo '</section>';
		}

		if(isset($_GET['post_type'])) {
			basey_pagination();
		}
	}

} else {
	echo basey_no_results_content();
}

if(isset($_GET['post_type'])) {
	echo '<p><a href="'.get_search_link().'">'.__('&larr; Back to search results','basey').'</a></p>';
}