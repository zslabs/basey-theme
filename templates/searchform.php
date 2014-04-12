<form role="search" method="get" id="searchform" class="form-search" action="<?php echo home_url( '/' ); ?>" data-parsley-validate>
	<div class="row collapse">
		<div class="small-9 columns">
			<input type="text" value="" name="s" id="s" class="search-query" placeholder="<?php _e( 'Search', 'basey' ); ?>" data-parsley-required>
		</div>
		<div class="small-3 columns">
			<input type="submit" id="searchsubmit" value="<?php _e( 'Search', 'basey' ); ?>" class="button postfix">
		</div>
	</div>
</form>