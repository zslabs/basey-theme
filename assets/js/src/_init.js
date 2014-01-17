(function( $ ) {
	"use strict";

	/**
	 * Foundation
	 */
	$(document).foundation();

	/**
	 * Parsley
	 */
	$( 'form' ).parsley( 'addListener', {
		onFieldValidate: function ( elem ) {

			// if field is not visible, do not apply Parsley validation!
			if ( !$( elem ).is( ':visible' ) ) {
				return true;
			}

			return false;
		}
	} );

	/**
	 * WordPress
	 */

	// Fix HTML format around pagination links
	// Foundation specific
	$.each($('.pagination li:not(:empty):not(:has(>a)), .page-numbers li:not(:empty):not(:has(>a))'), function(index, val) {

		$(val).addClass('current').wrapInner('<a></a>');
	});

}(jQuery));