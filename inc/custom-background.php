<?php
/**
 * Handles the setup and usage of the WordPress custom backgrounds feature.
 *
 * @package    Saga
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2014, Justin Tadlock
 * @link       http://themehybrid.com/themes/saga
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Call late so child themes can override. */
add_action( 'after_setup_theme', 'saga_custom_background_setup', 15 );

/* Register default background images. */
add_filter( 'hybrid_default_backgrounds', 'saga_default_backgrounds', 15 );

/**
 * Adds support for the WordPress 'custom-background' theme feature.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_custom_background_setup() {

	add_theme_support(
		'custom-background',
		array(
			'default-color'    => '151515',
			'default-image'    => '',
			'wp-head-callback' => 'saga_custom_background_callback',
		)
	);
}

/**
 * Registers custom backgrounds for the theme.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_default_backgrounds( $backgrounds ) {

	$_backgrounds = array(
		'black-cross-circle' => array(
			'url'           => '%s/images/backgrounds/black-cross-circle.png',
			'thumbnail_url' => '%s/images/backgrounds/black-cross-circle-thumb.png',
		),
		'black-grid' => array(
			'url'           => '%s/images/backgrounds/black-grid.png',
			'thumbnail_url' => '%s/images/backgrounds/black-grid-thumb.png',
		),
	);

	return array_merge( $backgrounds, $_backgrounds );
}

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What 
 * happens is the theme's background image hides the user-selected background color.  If a user selects a 
 * background image, we'll just use the WordPress custom background callback.  This also fixes WordPress 
 * not correctly handling the theme's default background color.
 *
 * @link http://core.trac.wordpress.org/ticket/16919
 * @link http://core.trac.wordpress.org/ticket/21510
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) )
		return;

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

?>
<style type="text/css" id="custom-background-css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php

}
