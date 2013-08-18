<?php

locate_template( 'templates/header.php', true, true );
	while ( have_posts() ) : the_post();
		locate_template( 'templates/single/default.php', true, false );
	endwhile;
locate_template( 'templates/footer.php', true, true );