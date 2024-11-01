(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$( window ).load(function() {

		if ( '.toggle' ) {
			$( '.toggle' ).on( 'change', 'input:checkbox', function() {
				$(this).prop( 'selected', $(this)[0].checked ? 1 : 0 );
				activate_merge_css( $(this)[0].checked ? 1 : 0 );
			});
		}

		if ( '#wp-css-merge-generate' ) {
			$( '#wp-css-merge-generate' ).click( function() {
				console.log( 'generate' );
				generate_css();
			});
		}

		function generate_css() {

			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'text',
				cache: false,
				data: {
					action: 'merge_css',
					nonce: wp_css_merge_app.nonces.merge_css
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					alert( 'An error occurred when trying to clear the debug log. Please contact support.' );
				},
				success: function( data ) {
					console.log( 'OK' );
					console.log( data );
				}
			} );

		}

		function activate_merge_css( val ) {

			console.log( 'value: ' + val );
			
			$.ajax( {
				url: ajaxurl,
				type: 'POST',
				dataType: 'text',
				cache: false,
				data: {
					action: 'activate_merge_css',
					value: val,
					nonce: wp_css_merge_app.nonces.activate_merge_css
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					alert( 'An error occurred when trying to clear the debug log. Please contact support.' );
				},
				success: function( data ) {
					console.log( 'OK' );
				}
			} );
			
		}

	})

})( jQuery );
