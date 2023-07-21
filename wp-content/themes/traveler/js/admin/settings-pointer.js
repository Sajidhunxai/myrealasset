( function ( $ ) {
	$( function () {
		if ( window.Traveler_Settings_Pointer ) {
			$( '#toplevel_page_st_traveler_option .wp-has-submenu' ).pointer( {
				content: Traveler_Settings_Pointer.content,
				position: { 'edge': 'left', 'align': 'center' },
				close: function () {
					$.post( 'admin-ajax.php', {
						action: 'dismiss-wp-pointer',
						pointer: Traveler_Settings_Pointer.name
					} );
				}
			} ).pointer( 'open' );
			$( '#menu-tools .wp-has-submenu' ).pointer( {
				content: Traveler_Settings_Pointer.content2,
				position: { 'edge': 'left', 'align': 'center' },
				close: function () {
					$.post( 'admin-ajax.php', {
						action: 'dismiss-wp-pointer',
						pointer: Traveler_Settings_Pointer.name2
					} );
				}
			}).pointer( 'open' );
		}
	} );
} )( jQuery );
