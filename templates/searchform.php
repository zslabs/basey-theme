<form role="search" method="get" id="searchform" class="form-search" action="<?php echo home_url( '/' ); ?>">
	<label class="visuallyhidden" for="s"><?php _e( 'Search for:', 'basey' ); ?></label>
	<input type="text" value="" name="s" id="s" class="search-query" placeholder="<?php _e( 'Search', 'basey' ); ?> <?php bloginfo( 'name' ); ?>">
	<input type="submit" id="searchsubmit" value="<?php _e( 'Search', 'basey' ); ?>" class="btn">
</form>