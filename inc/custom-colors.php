<?php
/**
 * Handles the custom colors feature for the theme.  This feature allows the theme or child theme author to 
 * set a custom color by default.  However the user can overwrite this default color via the theme customizer 
 * to a color of their choosing.
 *
 * @package    Saga
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2014, Justin Tadlock
 * @link       http://themehybrid.com/themes/saga
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Handles custom theme color options via the WordPress theme customizer.
 *
 * @since  1.0.0
 * @access public
 */
final class Saga_Custom_Colors {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Sets up the Custom Colors Palette feature.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Output CSS into <head>. */
		add_action( 'wp_head', array( $this, 'wp_head_callback' ) );

		/* Add a '.custom-colors' <body> class. */
		add_filter( 'body_class', array( $this, 'body_class' ) );

		/* Add options to the theme customizer. */
		add_action( 'customize_register', array( $this, 'customize_register' ) );

		/* Filter the default colors late. */
		add_filter( 'theme_mod_color_primary', array( $this, 'color_primary_default' ), 95 );
		add_filter( 'theme_mod_color_menu',    array( $this, 'color_menu_default'    ), 95 );

		/* Delete the cached data for this feature. */
		add_action( 'update_option_theme_mods_' . get_stylesheet(), array( $this, 'cache_delete' ) );

		/* Visual editor colors */
		add_action( 'wp_ajax_saga_editor_styles',         array( $this, 'editor_styles_callback' ) );
		add_action( 'wp_ajax_no_priv_saga_editor_styles', array( $this, 'editor_styles_callback' ) );

		add_action( 'wp_ajax_saga_media_sandbox_styles',         array( $this, 'editor_styles_callback' ) );
		add_action( 'wp_ajax_no_priv_saga_media_sandbox_styles', array( $this, 'editor_styles_callback' ) );

	}

	/**
	 * Returns a default primary color if there is none set.  We use this instead of setting a default
	 * so that child themes can overwrite the default early.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $hex
	 * @return string
	 */
	public function color_primary_default( $hex ) {
		return $hex ? $hex : 'e74c3c';
	}

	/**
	 * Returns a default menu color if there is none set.  We use this instead of setting a default
	 * so that child themes can overwrite the default early.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $hex
	 * @return string
	 */
	public function color_menu_default( $hex ) {
		return $hex ? $hex : 'e74c3c';
	}

	/**
	 * Adds the 'custom-colors' class to the <body> element.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $classes
	 * @return array
	 */
	public function body_class( $classes ) {

		$classes[] = 'custom-colors';

		return $classes;
	}

	/**
	 * Callback for 'wp_head' that outputs the CSS for this feature.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function wp_head_callback() {

		$stylesheet = get_stylesheet();

		/* Get the cached style. */
		$style = wp_cache_get( "{$stylesheet}_custom_colors" );

		/* If the style is available, output it and return. */
		if ( !empty( $style ) ) {
			echo $style;
			return;
		}

		$style  = $this->get_primary_styles();
		$style .= $this->get_menu_styles();

		/* Put the final style output together. */
		$style = "\n" . '<style type="text/css" id="custom-colors-css">' . trim( $style ) . '</style>' . "\n";

		/* Cache the style, so we don't have to process this on each page load. */
		wp_cache_set( "{$stylesheet}_custom_colors", $style );

		/* Output the custom style. */
		echo $style;
	}

	/**
	 * Ajax callback for outputting the primary styles for the WordPress visual editor.
	 *
	 * Note: We don't need the menu color for the editor style, so it's not included.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function editor_styles_callback() {

		header( 'Content-type: text/css' );

		echo $this->get_primary_styles();

		die();
	}

	/**
	 * Formats the primary styles for output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_primary_styles() {

		$style = '';

		$hex = get_theme_mod( 'color_primary', '' );
		$rgb = join( ', ', hybrid_hex_to_rgb( $hex ) );

		/* === Color === */

		$style .= "
				a:hover,
				a:focus,
				a:hover .entry-subtitle,
				a:focus .entry-subtitle,
				.wp-playlist-light .wp-playlist-item:hover, 
				.wp-playlist-light .wp-playlist-item:focus,
				.mejs-button button:hover, 
				.mejs-button button:focus,
				.mejs-overlay-button:hover, 
				.mejs-overlay-button:focus,
				label.focus,
				legend,
				pre,
				.form-allowed-tags code,
				.required,
				.line-through
				{ color: #{$hex}; }
			";

		$style .= "
				a,
				.format-quote blockquote::before,
				.format-quote blockquote::after,
				.mejs-overlay-button
				{ color: rgba( {$rgb}, 0.75 ); }
			";

		/* === Background Color === */

		$style .= "::selection { background-color: #{$hex}; }";

		$style .= "
				input[type='submit']:hover,
				input[type='submit']:focus,
				input[type='reset']:hover,
				input[type='reset']:focus,
				input[type='button']:hover,
				input[type='button']:focus,
				button:hover,
				button:focus,
				.comment-reply-link:hover,
				.comment-reply-link:focus,
				.page-links a:hover,
				.page-links a:focus,
				.mejs-time-rail .mejs-time-loaded 
				{ background-color: #{$hex}; }
			";

		$style .= "
				.page-links a,
				input[type='submit'],
				input[type='reset'],
				input[type='button'],
				button,
				.comment-reply-link
				{ background-color: rgba( {$rgb}, 0.75 ); }
			";

		$style .= "legend, pre, .form-allowed-tags code { background-color: rgba( {$rgb}, 0.1 ); }";

		/* === Border Color === */

		$style .= "a:focus img { border-color: #{$hex}; }";

		$style .= "legend, pre, .form-allowed-tags code { border-color: rgba( {$rgb}, 0.15 ); }";

		/* === Border Bottom Color === */

		$style .= "ins, u { border-bottom-color: #{$hex}; }";

		$style .= "
				.entry-content a:hover,
				.entry-content a:focus,
				.entry-summary a:hover,
				.entry-summary a:focus,
				.comment-content a:hover,
				.comment-content a:focus
				{ border-bottom-color: rgba( {$rgb}, 0.75 ); }
			";

		$style .= "
				.entry-content a,
				.entry-summary a,
				.comment-content a,
				blockquote.alignright,
				blockquote.alignleft,
				blockquote.aligncenter 
				{ border-bottom-color: rgba( {$rgb}, 0.25 ); }
			";

		/* === Border Top Color === */

		$style .= ".format-chat .chat-author { border-top-color: rgba( {$rgb}, 0.25 ); }";

		/* === Outline Color === */

		$style .= "a:focus, .featured-media a:focus img { outline-color: #{$hex}; }";

		/* Return the styles. */
		return str_replace( array( "\r", "\n", "\t" ), '', $style );
	}

	/**
	 * Formats the primary styles for output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_menu_styles() {

		$style = '';

		$hex = get_theme_mod( 'color_menu', '' );
		$rgb = join( ', ', hybrid_hex_to_rgb( $hex ) );

		/* === Background Color === */

		$style .= "
				.menu-toggle button:hover,
				.menu-toggle button:focus,
				#menu-primary li a:hover,
				#menu-primary li a:focus,
				.loop-pagination a:hover,
				.loop-pagination a:focus,
				.loop-pagination .current
				{ background-color: #{$hex}; }
			";

		$style .= ".menu-toggle button, #menu-primary li a { background: rgba( {$rgb}, 0.95 ); }";

		$style .= ".loop-pagination span, .loop-pagination a { background: rgba( {$rgb}, 0.9 ); }";

		/* Return the styles. */
		return str_replace( array( "\r", "\n", "\t" ), '', $style );
	}

	/**
	 * Registers the customize settings and controls.  We're tagging along on WordPress' built-in 
	 * 'Colors' section.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $wp_customize
	 * @return void
	 */
	public function customize_register( $wp_customize ) {

		/* Add the menu color setting. */
		$wp_customize->add_setting(
			'color_menu',
			array(
				'default'              => get_theme_mod( 'color_primary', '' ),
				'type'                 => 'theme_mod',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage',
			)
		);

		/* Add the primary color setting. */
		$wp_customize->add_setting(
			'color_primary',
			array(
				'default'              => get_theme_mod( 'color_menu', '' ),
				'type'                 => 'theme_mod',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage',
			)
		);

		/* Add menu color control. */
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'custom-colors-menu',
				array(
					'label'    => esc_html__( 'Menu Color', 'saga' ),
					'section'  => 'colors',
					'settings' => 'color_menu',
					'priority' => 10,
				)
			)
		);

		/* Add the primary color control. */
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'custom-colors-primary',
				array(
					'label'    => esc_html__( 'Primary Color', 'saga' ),
					'section'  => 'colors',
					'settings' => 'color_primary',
					'priority' => 15,
				)
			)
		);
	}

	/**
	 * Deletes the cached style CSS that's output into the header.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function cache_delete() {
		wp_cache_delete( get_stylesheet() . '_custom_colors' );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

Saga_Custom_Colors::get_instance();
