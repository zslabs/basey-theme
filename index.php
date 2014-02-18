<?php

locate_template( 'templates/header.php', true, true );

	get_template_part('templates/page', 'header');

	echo '<h1 class="entry-title">';
		basey_title();
	echo '</h1>';

	// start loop
	while ( have_posts() ) : the_post();

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

	endwhile;

	// display navigation to next/previous pages when applicable
	basey_pagination();

	// if no posts
	if ( ( !have_posts() ) || ( get_search_query() == ' ' ) ) {
		basey_no_results();
	}

locate_template( 'templates/footer.php', true, true );