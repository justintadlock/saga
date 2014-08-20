jQuery( document ).ready( function() {

	/*
	 * Adds classes to the `<label>` element based on the type of form element the label belongs 
	 * to. This allows theme devs to style specifically for certain labels (think, icons).
	 */

	jQuery( '#container input, #container textarea, #container select' ).each(

		function() {
			var sg_input_type = 'input';
			var sg_input_id   = jQuery( this ).attr( 'id' );
			var sg_label      = '';

			if ( jQuery( this ).is( 'input' ) )
				sg_input_type = jQuery( this ).attr( 'type' );

			else if ( jQuery( this ).is( 'textarea' ) )
				sg_input_type = 'textarea';

			else if ( jQuery( this ).is( 'select' ) )
				sg_input_type = 'select';

			jQuery( this ).parent( 'label' ).addClass( 'label-' + sg_input_type );

			if ( sg_input_id )
				jQuery( 'label[for="' + sg_input_id + '"]' ).addClass( 'label-' + sg_input_type );

			if ( 'checkbox' === sg_input_type || 'radio' === sg_input_type ) {
				jQuery( this ).parent( 'label' ).removeClass( 'font-secondary' ).addClass( 'font-primary' );

				if ( sg_input_id )
					jQuery( 'label[for="' + sg_input_id + '"]' ).removeClass( 'font-secondary' ).addClass( 'font-primary' );

			}
		}
	);

	/* Focus labels for form elements. */
	jQuery( 'input, select, textarea' ).on( 'focus blur',
		function() {
			var sg_focus_id   = jQuery( this ).attr( 'id' );

			if ( sg_focus_id )
				jQuery( 'label[for="' + sg_focus_id + '"]' ).toggleClass( 'focus' );
			else
				jQuery( this ).parents( 'label' ).toggleClass( 'focus' );
		}
	);

	/*
	 * Handles situations in which CSS `:contain()` would be extremely useful. Since that doesn't actually 
	 * exist or is not supported by browsers, we have the following.
	 */

	/* Adds the 'has-code' class to the `<pre>` tag if it contains the `<code>` tag. */
	jQuery( 'pre' ).has( 'code' ).addClass( 'has-code' );

	/* Adds the 'has-cite' class to the parent element in a blockquote that wraps <cite>, such as a <p>. */
	jQuery( 'blockquote p' ).has( 'cite' ).addClass( 'has-cite' );

	/*
	 * Adds the `.has-cite-only` if the last `<p>` in the `<blockquote>` only has the `<cite>` element.
	 * Adds the `.is-last-child` class to the previous `<p>`.  This is so that we can style correctly 
	 * for blockquotes in English, in which only the last paragraph should have a closing quote.
	 */
	jQuery( 'blockquote p:has( cite )' ).filter(
		function() {
			if ( 1 === jQuery( this ).contents().length ) {
				jQuery( this ).addClass( 'has-cite-only' );
				jQuery( this ).prev( 'p' ).addClass( 'is-last-child' );
			}
		}
	);


	/* Add class to links with an image. */
	jQuery( 'a' ).has( 'img' ).addClass( 'img-hyperlink' );

	/* Adds 'has-posts' to any <td> element in the calendar that has posts for that day. */
	jQuery( '.wp-calendar tbody td' ).has( 'a' ).addClass( 'has-posts' );

	/* Fix Webkit focus bug. */
	jQuery( '#content' ).attr( 'tabindex', '-1' );

	/* Menu focus. */
	jQuery( '.menu li a' ).on( 'focus blur', 
		function() {
			jQuery( this ).parents().toggleClass( 'focus' );
		}
	);

	/* Custom-colored line-through. */
	jQuery( 'del, strike, s' ).wrap( '<span class="line-through" />' );

	/*
	 * Video and other embeds.  Let's make them more responsive.	
	 */

	/* Overrides WP's <div> wrapper around videos, which mucks with flexible videos. */
	jQuery( 'div[style*="max-width: 100%"] > video' ).parent().css( 'width', '100%' );

	/* Responsive videos. */
	/* blip.tv adds a second <embed> with "display: none".  We don't want to wrap that. */
	jQuery( '.entry object, .entry embed, .entry iframe' ).not( 'embed[style*="display"], [src*="soundcloud.com"], [src*="amazon"], [name^="gform_"]' ).wrap( '<div class="embed-wrap" />' );

	/* Removes the 'width' attribute from embedded videos and replaces it with a max-width. */
	/*
	jQuery( '.embed-wrap object, .embed-wrap embed, .embed-wrap iframe' ).attr( 
		'width',
		function( index, value ) {
			jQuery( this ).attr( 'style', 'max-width: ' + value + 'px;' );
			jQuery( this ).removeAttr( 'width' );
		}
	);*/

	/* Menu toggle. */
	jQuery( '#menu-primary > .wrap' ).hide();

	jQuery( '.menu-toggle button' ).click(
		function() {
			jQuery( this ).parents( '.menu' ).children( '.wrap' ).slideToggle( 'slow' ).toggleClass( 'open' );
			jQuery( this ).toggleClass( 'active' );
		}
	);

	jQuery( '.format-aside .entry-content p' ).wrapInner( '<span class="aside-wrap">' );

} );