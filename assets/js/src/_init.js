(function( $ ) {
	"use strict";

	/**
	 * Foundation
	 */
	$(document).foundation();

	/**
	 * Placeholder
	 */
	$('[placeholder]').placeholder();

	/**
	 * Smooth Scroll
	 */
	$('a.scroll').click(function(event) {
		event.preventDefault();
		var link = this;
		$.smoothScroll({
			scrollTarget: link.hash
		});
	});

	/**
	 * WordPress
	 */

	// Fix HTML format around pagination links
	// Foundation specific
	$.each($('.pagination li:not(:empty):not(:has(>a)), .page-numbers li:not(:empty):not(:has(>a))'), function(index, val) {

		$(val).addClass('current').wrapInner('<a></a>');
	});

}(jQuery));