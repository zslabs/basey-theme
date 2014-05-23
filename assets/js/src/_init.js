(function( $ ) {
	"use strict";

	/**
	 * Variables
	 */
	var $window = $(window);

	/**
	 * Foundation
	 */
	$(document).foundation();

	/**
	 * Grid Spacing
	 * Calculates if columns are stacked for proper vertical spacing
	 */
	function baseyGridSpacing() {
		var isStacked = false;

		$.each($('[data-grid-row]'), function(index, val) {
			var $gridRow = $(val),
				vals = $gridRow.find('[data-grid-column]:visible');

			if (vals.length === 0) return;

			var firstTopOffset = vals.first().offset().top;
			vals.each(function(){
				var el = $(this);
				if (el.offset().top !== firstTopOffset) {
					$gridRow.addClass('is-stacked');
				}
				else {
					$gridRow.removeClass('is-stacked');
				}
			});
		});
	}
	baseyGridSpacing();

	$window.on('resize', Foundation.utils.throttle(function(){
		baseyGridSpacing();
	}, 300));

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
	$.each($('.pagination li:not(:empty):not(:has(>a)) .current, .page-numbers li:not(:empty):not(:has(>a)) .current'), function(index, val) {
		$(val).parent().addClass('current').wrapInner('<a></a>');
	});

}(jQuery));