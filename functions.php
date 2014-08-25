<?php
/**
 * "Oh, when I look back now / That summer seemed to last forever / And if I had the choice / 
 * Yeah, I'd always wanna be there / Those were the best days of my life" - Bryan Adams (Summer of '69)
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Saga
 * @subpackage Functions
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2014, Justin Tadlock
 * @link       http://themehybrid.com/themes/saga
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Get the template directory and make sure it has a trailing slash. */
$saga_dir = trailingslashit( get_template_directory() );

/* Load the Hybrid Core framework and theme files. */
require_once( $saga_dir . 'library/hybrid.php'        );
require_once( $saga_dir . 'inc/custom-background.php' );
require_once( $saga_dir . 'inc/custom-header.php'     );
require_once( $saga_dir . 'inc/custom-colors.php'     );
require_once( $saga_dir . 'inc/theme.php'             );
require_once( $saga_dir . 'inc/customize.php'         );

/* Launch the Hybrid Core framework. */
new Hybrid();

/* Set up the theme early. */
add_action( 'after_setup_theme', 'saga_theme_setup', 5 );

/**
 * The theme setup function.  This function sets up support for various WordPress and framework functionality.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_theme_setup() {

	/* Enable custom template hierarchy. */
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* The best thumbnail/image script ever. */
	add_theme_support( 'get-the-image' );

	/* Pagination. */
	add_theme_support( 'loop-pagination' );

	/* Nicer [gallery] shortcode implementation. */
	add_theme_support( 'cleaner-gallery' );

	/* Better captions for themes to style. */
	add_theme_support( 'cleaner-caption' );

	/* Automatically add feed links to <head>. */
	add_theme_support( 'automatic-feed-links' );

	/* Post formats. */
	add_theme_support( 
		'post-formats', 
		array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) 
	);

	/* Editor styles. */
	add_editor_style( saga_get_editor_styles() );

	/* Handle content width for embeds and images. */
	hybrid_set_content_width( 1100 );
}
