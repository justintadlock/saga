<?php
/**
 * Sets up custom filters and actions for the theme.  This does things like sets up sidebars, menus, scripts, 
 * and lots of other awesome stuff that WordPress themes do.
 *
 * @package    Saga
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2014, Justin Tadlock
 * @link       http://themehybrid.com/themes/saga
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register custom image sizes. */
add_action( 'init', 'saga_register_image_sizes', 5 );

/* Register custom menus. */
add_action( 'init', 'saga_register_menus', 5 );

/* Add custom scripts. */
add_action( 'wp_enqueue_scripts', 'saga_enqueue_scripts' );

/* Register custom styles. */
add_action( 'wp_enqueue_scripts', 'saga_enqueue_styles', 5 );
add_action( 'admin_enqueue_scripts', 'saga_admin_register_styles', 0 );
add_action( 'wp_enqueue_scripts', 'saga_dequeue_styles', 95 );

/* Handle the header icon. */
add_filter( 'theme_mod_header_icon',  'saga_theme_mod_header_icon', 95 );
add_filter( 'hybrid_attr_site-title', 'saga_attr_site_title'           );

/* Excerpt-related filters. */
add_filter( 'excerpt_length', 'saga_excerpt_length' );
add_filter( 'excerpt_more',   'saga_excerpt_more'   );
add_filter( 'the_excerpt',    'saga_the_excerpt', 5 );

/* Adds custom settings for the visual editor. */
add_filter( 'tiny_mce_before_init',        'saga_tiny_mce_before_init' );
add_filter( 'wpview_media_sandbox_styles', 'saga_media_sandbox_styles' );

/**
 * Registers custom image sizes for the theme.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_register_image_sizes() {

	/* Sets the 'post-thumbnail' size. */
	set_post_thumbnail_size( 175, 119, true );

	/* Adds the 'saga-large' image size. */
	add_image_size( 'saga-large', 1100, 9999, false );
}

/**
 * Registers nav menu locations.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_register_menus() {
	register_nav_menu( 'primary', _x( 'Primary', 'nav menu location', 'saga' ) );
}

/**
 * Enqueues scripts.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_enqueue_scripts() {

	$suffix = hybrid_get_min_suffix();

	wp_register_script( 'saga', trailingslashit( get_template_directory_uri() ) . "js/theme{$suffix}.js", array( 'jquery' ), null, true );

	wp_enqueue_script( 'saga' );
}

/**
 * Registers custom stylesheets for the front end.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_enqueue_styles() {
	wp_deregister_style( 'mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );

	$suffix = hybrid_get_min_suffix();

	wp_enqueue_style( 'one-five', trailingslashit( HYBRID_CSS ) . "one-five{$suffix}.css" );

	if ( current_theme_supports( 'cleaner-gallery' ) )
		wp_enqueue_style( 'gallery', trailingslashit( HYBRID_CSS ) . "gallery{$suffix}.css" );

	wp_enqueue_style( 'font-awesome', trailingslashit( get_template_directory_uri() ) . "css/font-awesome{$suffix}.css" );
	wp_enqueue_style( 'theme-mediaelement', trailingslashit( get_template_directory_uri() ) . "css/mediaelement/mediaelement{$suffix}.css" );

	wp_enqueue_style( 'saga-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic|Playfair+Display:400,700,900,400italic,700italic,900italic' );

	if ( is_child_theme() )
		wp_enqueue_style( 'parent', trailingslashit( get_template_directory_uri() ) . "style{$suffix}.css" );

	wp_enqueue_style( 'style', get_stylesheet_uri() );
}

/**
 * Removes styles late, particularly the Subtitles plugin stylesheet.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_dequeue_styles() {
	wp_dequeue_style( 'subtitles-style' );
}

/**
 * Registers stylesheets for use in the admin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_admin_register_styles() {
	$suffix = hybrid_get_min_suffix();

	wp_register_style( 'font-awesome', trailingslashit( get_template_directory_uri() ) . "css/font-awesome{$suffix}.css" );
	wp_register_style( 'saga-fonts', '//fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic|Open+Sans:300,400,600,700' );
	wp_register_style( 'saga-admin-custom-header', trailingslashit( get_template_directory_uri() ) . 'css/admin-custom-header.css' );
}

/**
 * Callback function for adding editor styles.  Use along with the add_editor_style() function.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function saga_get_editor_styles() {

	/* Set up an array for the styles. */
	$editor_styles = array();

	/* Add the theme's editor styles. */
	$editor_styles[] = trailingslashit( get_template_directory_uri() ) . 'css/editor-style.css';

	/* If a child theme, add its editor styles. Note: WP checks whether the file exists before using it. */
	if ( is_child_theme() && file_exists( trailingslashit( get_stylesheet_directory() ) . 'css/editor-style.css' ) )
		$editor_styles[] = trailingslashit( get_stylesheet_directory_uri() ) . 'css/editor-style.css';

	/* Add the locale stylesheet. */
	$editor_styles[] = get_locale_stylesheet_uri();

	/* Uses Ajax to display custom theme styles added via the Theme Mods API. */
	$editor_styles[] = add_query_arg( 'action', 'saga_editor_styles', admin_url( 'admin-ajax.php' ) );

	/* Return the styles. */
	return $editor_styles;
}

/**
 * Overwrite sandboxed media view styles.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $styles
 * @return array
 */
function saga_media_sandbox_styles( $styles ) {
	$version = 'ver=' . $GLOBALS['wp_version'];

 	$mediaelement   = includes_url( "js/mediaelement/mediaelementplayer.min.css?$version" );
 	$wpmediaelement = includes_url( "js/mediaelement/wp-mediaelement.css?$version" );

	foreach ( $styles as $key => $style ) {

		if ( $style === $mediaelement || $style === $wpmediaelement )
			unset( $styles[ $key ] );
	}

	$styles[] = '//fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic|Playfair+Display:400,700,900,400italic,700italic,900italic';
	$styles[] = trailingslashit( HYBRID_CSS ) . 'one-five.min.css';
	$styles[] = trailingslashit( get_template_directory_uri() ) . 'css/mediaelement/mediaelement.min.css';
	$styles[] = trailingslashit( get_template_directory_uri() ) . 'css/font-awesome.min.css';
	$styles[] = trailingslashit( get_template_directory_uri() ) . 'style.min.css';

	/* Uses Ajax to display custom theme styles added via the Theme Mods API. */
	$styles[] = add_query_arg( 'action', 'saga_media_sandbox_styles', admin_url( 'admin-ajax.php' ) );

	return $styles;
}

/**
 * Adds the <body> class to the visual editor.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $settings
 * @return array
 */
function saga_tiny_mce_before_init( $settings ) {

	$settings['body_class'] = join( ' ', array_merge( get_body_class(), get_post_class() ) );

	return $settings;
}

/**
 * Filters the header icon to set the default.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $icon
 * @return string
 */
function saga_theme_mod_header_icon( $icon ) {
	return 'default' === $icon ? 'icon-pencil' : $icon;
}

/**
 * Adds a class to the site title to handle the header icon.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @return array
 */
function saga_attr_site_title( $attr ) {

	if ( $icon = get_theme_mod( 'header_icon', 'default' ) )
		$attr['class'] = sanitize_html_class( $icon );

	return $attr;
}

/**
 * Adds a custom excerpt length.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $length
 * @return int
 */
function saga_excerpt_length( $length ) {
	return 20;
}

/**
 * Custom excerpt more text and link.
 *
 * @since  1.2.0
 * @access public
 * @param  string  $more
 * @return string
 */
function saga_excerpt_more( $more ) {
	return ' &hellip; ';
}

/**
 * Appends a "Continue reading %s" link to the end of all excerpts.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $excerpt
 * @return string
 */
function saga_the_excerpt( $excerpt ) {

	/* Translators: The %s is the post title shown to screen readers. */
	$text = sprintf( __( 'Continue reading %s', 'saga' ), '<span class="screen-reader-text">' . get_the_title() . '</span>' );
	$more = sprintf( '<p class="more-link-wrap"><a href="%s" class="more-link">%s</a></p>', get_permalink(), $text );

	return $excerpt . $more;
}
