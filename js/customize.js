/**
 * Function for turning a hex color into an RGB string.
 */
function saga_hex_to_rgb( hex ) {
	var color = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec( hex );

	return parseInt( color[1], 16 ) + ", " + parseInt( color[2], 16 ) + ", " + parseInt( color[3], 16 );
}

/**
 * Handles the customizer live preview settings.
 */
jQuery( document ).ready( function() {

	/*
	 * Shows a live preview of changing the site title.
	 */
	wp.customize( 'blogname', function( value ) {

		value.bind( function( to ) {

			jQuery( '#site-title a' ).html( to );

		} ); // value.bind

	} ); // wp.customize

	/*
	 * Handles the header textcolor.  This code also accounts for the possibility that the header text color
	 * may be set to 'blank', in which case, any text in the header is hidden.
	 */
	wp.customize( 'header_textcolor', function( value ) {

		value.bind( function( to ) {

			/* If set to 'blank', hide the branding section and secondary menu. */
			if ( 'blank' === to ) {

				/* Hides branding and menu-secondary. */
				jQuery( '#branding' ).css( 'display', 'none' );

				/* Removes the 'display-header-text' <body> class. */
				jQuery( 'body' ).removeClass( 'display-header-text' );
			}

			/* Change the header and secondary menu colors. */
			else {

				/* Adds the 'display-header-text' <body> class. */
				jQuery( 'body' ).addClass( 'display-header-text' );

				/* Makes sures both branding and menu-secondary display. */
				jQuery( '#branding' ).css( 'display', 'block' );

				var rgb = saga_hex_to_rgb( to );

				/* Changes the color of the site title link. */
				jQuery( '#site-title, #site-title a, #footer .credit a' ).css( 'color', to );

				jQuery( '#site-description, #footer .credit' ).css( 'color', 'rgba( ' + rgb + ', 0.75 )' );

			} // endif

		} ); // value.bind

	} ); // wp.customize

	/*
	 * Handes the header image.  This code replaces the "src" attribute for the image.
	 */
	wp.customize( 'header_image', function( value ) {

		value.bind( function( to ) {

			/* If removing the header image, make sure to hide it so there's not an error image. */
			if ( 'remove-header' === to ) {
				jQuery( '.header-image' ).hide();
			}

			/* Else, make sure to show the image and change the source. */
			else {
				jQuery( '.header-image' ).show();
				jQuery( '.header-image' ).attr( 'src', to );
			}

		} ); // value.bind

	} ); // wp.customize

	/*
	 * Shows a live preview of changing the site description.
	 */
	wp.customize( 'blogdescription', function( value ) {

		value.bind( function( to ) {

			jQuery( '#site-description' ).html( to );

		} ); // value.bind

	} ); // wp.customize

	/*
	 * Handles the header icon.  This is only displayed if the header text is displayed.
	 */
	wp.customize( 'header_icon', function( value ) {

		value.bind( function( new_icon, old_icon ) {

			if ( '' !== old_icon ) {
				jQuery( '#site-title' ).removeClass( old_icon );
			}

			if ( '' !== new_icon ) {
				jQuery( '#site-title' ).addClass( new_icon );
			}

		} ); // value.bind

	} ); // wp.customize

	/*
	 * Handles the Primary color for the theme.  This color is used for various elements and at different 
	 * shades. It must set an rgba color value to handle the "shades".
	 */
	wp.customize( 'color_primary', function( value ) {

		value.bind( function( to ) {

			var rgb = saga_hex_to_rgb( to );

			/* special case: hover */

			jQuery( '.entry-title a, .mejs-button button' ).
				hover(
					function() {
						jQuery( this ).css( 'color', to );
						jQuery( this ).children( '.entry-subtitle' ).css( 'color', to );

					},
					function() {
						jQuery( this ).css( 'color', 'inherit' );
						jQuery( this ).children( '.entry-subtitle' ).css( 'color', 'inherit' );
					}
			); // .hover

			jQuery( 'a, .wp-playlist-light .wp-playlist-item, .mejs-overlay-button' ).
				not( '#header a, #footer a, .entry-title a, .entry-author a, .wp-playlist a, .mejs-button button, .loop-pagination a, .comment-reply-link, .comment-reply-login' ).
				hover(
					function() {
						jQuery( this ).css( 'color', to );

					},
					function() {
						jQuery( this ).css( 'color', 'rgba( ' + rgb + ', 0.75 )' );
					}
			); // .hover

			jQuery( "input[type='submit'], input[type='reset'], input[type='button'], button, .comment-reply-link, .page-links a" ).
				not( '.menu-toggle button, .mejs-button button' ).
				hover(
					function() {
						jQuery( this ).css( 'background-color', to );

					},
					function() {
						jQuery( this ).css( 'background-color', 'rgba( ' + rgb + ', 0.75 )' );
					}
			); // .hover

			jQuery( '.entry-content a, .entry-summary a, .comment-content a' ).
				hover(
					function() {
						jQuery( this ).css( 'border-bottom-color', 'rgba( ' + rgb + ', 0.75 )' );

					},
					function() {
						jQuery( this ).css( 'border-bottom-color', 'rgba( ' + rgb + ', 0.25 )' );
					}
			); // .hover

			/* color */

			jQuery( 'label.focus, legend, pre, .form-allowed-tags code, .required, .line-through' ).
				css( 'color', to );

			jQuery( 'a, .mejs-overlay-button' ).
				not( '#header a, #footer a, .entry-title a, .entry-author a, .wp-playlist a, .loop-pagination a, .comment-reply-link, .comment-reply-login' ).
				css( 'color', 'rgba( ' + rgb + ', 0.75 )' );

			/* background color */

			jQuery( '.mejs-time-rail .mejs-time-loaded' ).
				css( 'background-color', to );

			jQuery( ".page-links a, input[type='submit'], input[type='reset'], input[type='button'], button, .comment-reply-link" ).
				not( '.menu-toggle button, .mejs-button button' ).
				css( 'background-color', 'rgba( ' + rgb + ', 0.75 )' );

			jQuery( 'legend, pre, .form-allowed-tags code' ).
				css( 'background-color', 'rgba( ' + rgb + ', 0.1 )' );

			/* border color */

			jQuery( 'legend, pre, .form-allowed-tags code' ).
				css( 'border-color', 'rgba( ' + rgb + ', 0.15 )' );

			/* border bottom color */

			jQuery( 'ins, u' ).
				css( 'border-bottom-color', to );

			jQuery( '.entry-content a, .entry-summary a, .comment-content a, blockquote.alignright, blockquote.alignleft, blockquote.aligncenter' ).
				css( 'border-bottom-color', 'rgba( ' + rgb + ', 0.25 )' );

			/* border top color */

			jQuery( '.format-chat .chat-author' ).
				css( 'border-top-color', 'rgba( ' + rgb + ', 0.25 )' );

		} ); // value.bind

	} ); // wp.customize

	/*
	 * Handles the Menu color for the theme.  This color is used for various elements and at different 
	 * shades. It must set an rgba color value to handle the "shades".
	 */
	wp.customize( 'color_menu', function( value ) {

		value.bind( function( to ) {

			var rgb = saga_hex_to_rgb( to );

			jQuery( '.menu-toggle button, #menu-primary li a' ).
				hover(
					function() {
						jQuery( this ).css( 'background-color', to );

					},
					function() {
						jQuery( this ).css( 'background-color', 'rgba( ' + rgb + ', 0.95 )' );
					}
			); // .hover

			jQuery( '.menu-toggle button, #menu-primary li a, .loop-pagination a' ).focus(
				function() {
					jQuery( this ).css( 'background-color', to );
				}
			); // .focus

			jQuery( '.menu-toggle button, #menu-primary li a' ).blur(
				function() {
					jQuery( this ).css( 'background-color', 'rgba( ' + rgb + ', 0.95 )' );
				}
			); // .blur

			jQuery( '.loop-pagination a' ).blur(
				function() {
					jQuery( this ).css( 'background-color', 'rgba( ' + rgb + ', 0.9 )' );
				}
			); // .blur

			jQuery( '.loop-pagination a' ).
				hover(
					function() {
						jQuery( this ).css( 'background-color', to );

					},
					function() {
						jQuery( this ).css( 'background-color', 'rgba( ' + rgb + ', 0.9 )' );
					}
			); // .hover

			jQuery( '.menu-toggle button, #menu-primary li a' ).
				css( 'background-color', 'rgba( ' + rgb + ', 0.95 )' );

			jQuery( '.loop-pagination a, .loop-pagination span' ).
				css( 'background-color', 'rgba( ' + rgb + ', 0.9 )' );

			jQuery( '.loop-pagination .current' ).css( 'background-color', to );

		} ); // value.bind

	} ); // wp.customize

} ); // jQuery( document ).ready