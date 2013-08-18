<?php

locate_template( 'templates/header.php', true, true );
	get_template_part( 'templates/page-header' ); ?>
	<div class="alert">
		<?php _e('Sorry, but the page you were trying to view does not exist.', 'basey'); ?>
	</div>
	<p><?php _e( 'Please try the following:', 'basey' ); ?></p>
	<ul>
		<li><?php _e( 'Check your spelling', 'basey' ); ?> </li>
		<li><?php printf(__( 'Return to the <a href="%s">home page</a>', 'basey' ), home_url() ); ?></li>
		<li><?php _e( 'Click the <a href="javascript:history.back()">Back</a> button', 'basey' ); ?></li>
	</ul>
	<?php get_search_form();
locate_template( 'templates/footer.php', true, true );
