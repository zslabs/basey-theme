<?php

locate_template( 'templates/header.php', true, true );
	$results = array();

	get_template_part('templates/page', 'header');
	if ( have_posts() ) {

		while ( have_posts() ) {

			the_post();

			$post_type_object = get_post_type_object( get_post_type() );
			$results['post_types'][get_post_type()]['name'] = $post_type_object->name;
			$results['post_types'][get_post_type()]['single'] = $post_type_object->labels->singular_name;
			$results['post_types'][get_post_type()]['plural'] = $post_type_object->labels->name;
			$results['post_types'][get_post_type()]['ids'][] = get_the_ID();
		}

		// DEBUG: Prints out current search results
		//print_r( $results);

		// generates anchor links for each term/post type found
		if( !isset( $_GET['post_type'] ) && !empty( $results ) ) {
			echo '<ul id="results-overview-list">';
			if ( !empty( $results['post_types'] ) ) {
				foreach ( $results['post_types'] as $post_type) {
					$count = count( $post_type['ids'] );
					$post_type_name = $post_type['name'];
					$post_type_name = ( $count > 1 ? apply_filters( "basey_search_results_{$post_type_name}_plural", $post_type['plural'] ) : apply_filters( "basey_search_results_{$post_type_name}_single", $post_type['single'] ) );
					echo '<li class="' . $post_type['name'] . '">' . sprintf(__( '<a class="scroll" href="#%1$s">%2$s %3$s found</a>', 'basey' ), $post_type['name'], $count, $post_type_name) . '</li>';
				}
			}
			echo '</ul>';
		}

	do_action( 'basey_search_header_after' );


		// if post types are not empty, print each section and ultimately the posts within them out
		if ( !empty( $results['post_types'] ) ) {
			foreach ( $results['post_types'] as $post_type) {

				$post_type_name = $post_type['name'];

				// container around each post type for proper anchors
				echo '<section class="post-type" id="' . $post_type_name . '">';

				// count number of posts available
				$count = count( $post_type['ids'] );
				if( !isset( $_GET['post_type'] ) ) {
					$post_type_label = ( $count > 1 ? apply_filters( "basey_search_results_{$post_type_name}_plural", $post_type['plural'] ) : apply_filters( "basey_search_results_{$post_type_name}_single", $post_type['single'] ) );
					echo '<h3>' . sprintf(__( '%1$s %2$s found', 'basey' ), $count, $post_type_label ) . '</h3>';
					echo ( $count > apply_filters( 'basey_search_results_limit', 5 ) && ( !isset( $_GET['post_type'] ) ) ? '<a class="search-more-button" href="' . add_query_arg( 'post_type', $post_type_name) . '">' . __( 'More', 'basey' ) . '</a>' : '' );
				}

				do_action( "basey_search_before_{$post_type_name}" );

				$i = 0;
				foreach ( $post_type['ids'] as $post) {
					$post = get_post( $post);
					setup_postdata( $post);

					// determine if template is available
					$template_available = locate_template( 'templates/teaser/' . get_post_type() . '.php' ) ? get_post_type() : false;

					switch( get_post_type() ) {


						case $template_available :
							locate_template( 'templates/teaser/' . get_post_type() . '.php', true, false );
							break;

						default:
							locate_template( 'templates/teaser/default.php', true, false );
							break;
					}

					if( !isset( $_GET['post_type'] ) ) {
						if ( ++$i == apply_filters( 'basey_search_results_limit', 5 ) ) break;
					}

					wp_reset_postdata();
				}

				do_action( "basey_search_after_{$post_type_name}" );

				// close container around each post type for proper anchors
				echo '</section>';
			}

			if(isset( $_GET['post_type'] ) ) {
				basey_pagination();
			}
		}

	} else {
		echo basey_no_results_content();
	}

	if(isset( $_GET['post_type'] ) ) {
		echo '<p><a href="' . get_search_link() . '">' . __( '&larr; Back to search results', 'basey' ) . '</a></p>';
	}
locate_template( 'templates/footer.php', true, true );