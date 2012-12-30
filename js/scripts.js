(function($) {

	// Smooth Scroll
	$('a.scroll').click(function(event) {
		event.preventDefault();
		var link = this;
		$.smoothScroll({
			offset: -10,
			scrollTarget: link.hash // only use if you want to override default behavior
		});
	});

})(jQuery);