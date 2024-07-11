/* global dismissNotices */

/**
 * Handle notice dismiss in customizer.
 */
jQuery( function ( $ ) {
	$( document ).on( 'click', '.hestia-notice .notice-dismiss', function () {
		var control_id = $( this ).closest('li').attr( 'id' ).replace( 'accordion-section-', '' );
		$.ajax( {
			url: dismissNotices.ajaxurl,
			type: 'POST',
			data: {
				action: 'dismissed_notice_handler',
				control: control_id
			},
			success: function () {
				$( '#accordion-section-' + control_id ).fadeOut( 300, function () {
					if ( 'function' === typeof wp.customize ) {
						wp.customize.section.remove( control_id );
					} else {
						$( this ).remove();
					}
				} );
			}
		} );
	} );
} );