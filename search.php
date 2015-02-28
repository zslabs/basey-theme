<?php

locate_template( 'templates/header.php', true, true );
	$results = array();

	echo '<h2 class="uk-article-title">';
		basey_title();
	echo '</h2>';

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
		// print_r( $results);

		// generates anchor links for each term/post type found
		if( !isset( $_GET['post_type'] ) && !empty( $results['post_types'] ) ) {
			echo '<ul id="search-nav" class="uk-subnav uk-subnav-pill">';
				echo '<li><span>' . __('Filter Results', 'basey') . '</span>';
				foreach ( $results['post_types'] as $post_type) {
					$post_type_name = $post_type['name'];
					$post_type_count = basey_get_post_type_count($post_type_name);

					$post_type_name = ( $post_type_count > 1 ? apply_filters( "basey_search_results_{$post_type_name}_plural", $post_type['plural'] ) : apply_filters( "basey_search_results_{$post_type_name}_single", $post_type['single'] ) );
					echo '<li>' . sprintf(__( '<a href="#post-type-%1$s" data-uk-smooth-scroll>%2$s %3$s</a>', 'basey' ), $post_type['name'], $post_type_count, $post_type_name) . '</li>';

				}
				echo '</li>';
			echo '</ul>';
		}

		// if post types are not empty, print each section and ultimately the posts within them out
		if ( !empty( $results['post_types'] ) ) {
			foreach ( $results['post_types'] as $post_type) {

				$post_type_name = $post_type['name'];

				// container around each post type for proper anchors
				echo '<section class="post-type" id="post-type-' . $post_type_name . '">';

				// count number of posts available
				$post_type_count = basey_get_post_type_count($post_type_name);
				if( !isset( $_GET['post_type'] ) ) {
					$post_type_label = ( $post_type_count > 1 ? apply_filters( "basey_search_results_{$post_type_name}_plural", $post_type['plural'] ) : apply_filters( "basey_search_results_{$post_type_name}_single", $post_type['single'] ) ); ?>
					<div class="uk-clearfix">
						<div class="uk-float-left">
							<h2><?php echo sprintf(__( '%1$s %2$s found', 'basey' ), $post_type_count, $post_type_label ); ?></h2>
						</div>
						<?php echo ( $post_type_count > apply_filters( 'basey_search_results_limit', get_option('posts_per_page') ) && ( !isset( $_GET['post_type'] ) ) ? '<div class="uk-float-right"><a class="uk-button" href="' . add_query_arg( 'post_type', $post_type_name) . '">' . __( 'More', 'basey' ) . ' <i class="uk-icon-ellipsis-h"></i></a></div>' : '' ); ?>
					</div>
				<?php }

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
						if ( ++$i == apply_filters( 'basey_search_results_limit', get_option('posts_per_page') ) ) break;
					}

					wp_reset_postdata();
				}

				// close container around each post type for proper anchors
				echo '</section>';
			}

			if(isset( $_GET['post_type'] ) ) {
				basey_pagination();
			}
		}

	} else {
		basey_no_results();
	}

	if(isset( $_GET['post_type'] ) ) {
		echo '<div class="uk-clearfix"><a class="uk-button" href="' . get_search_link() . '">' . __( '<i class="uk-icon-angle-double-left"></i> Back to search results', 'basey' ) . '</a></div>';
	}
locate_template( 'templates/footer.php', true, true );