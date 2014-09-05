<?php
/**
 * Handles the theme's theme customizer functionality.
 *
 * @package    Saga
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2014, Justin Tadlock
 * @link       http://themehybrid.com/themes/saga
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Theme Customizer setup. */
add_action( 'customize_register', 'saga_customize_register' );

/**
 * Sets up the theme customizer sections, controls, and settings.
 *
 * @since  1.0.0
 * @access public
 * @param  object  $wp_customize
 * @return void
 */
function saga_customize_register( $wp_customize ) {

	/* Load the Font Awesome definitions. */
	require_once( trailingslashit( get_template_directory() ) . 'inc/font-icons.php' );

	/* Load JavaScript files. */
	add_action( 'customize_preview_init', 'saga_enqueue_customizer_scripts' );

	/* Load CSS files. */
	add_action( 'customize_controls_print_styles', 'saga_customize_controls_print_styles' );

	/* Enable live preview for WordPress theme features. */
	$wp_customize->get_setting( 'blogname' )->transport              = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport       = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'background_image' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'background_position_x' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_repeat' )->transport     = 'postMessage';
	$wp_customize->get_setting( 'background_attachment' )->transport = 'postMessage';

	/* Remove the WordPress background image control. */
	$wp_customize->remove_control( 'background_image' );

	/* Add our custom background image control. */
	$wp_customize->add_control( new Hybrid_Customize_Control_Background_Image( $wp_customize ) );

	/* Adds the header icon setting. */
	$wp_customize->add_setting(
		'header_icon',
		array(
			'default'              => get_theme_mod( 'header_icon', 'default' ),
			'type'                 => 'theme_mod',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'esc_attr',
			'sanitize_js_callback' => 'esc_attr',
			'transport'            => 'postMessage',
		)
	);

	/* Adds the header icon control. */
	$wp_customize->add_control(
		'saga-header-icon',
		array(
			'label'    => __( 'Header Icon', 'saga' ),
			'section'  => 'title_tagline',
			'settings' => 'header_icon',
			'type'     => 'select',
			'choices'  => saga_get_header_icon_choices()
		)
	);
}

/**
 * Returns an array of header icons for use with the 'header_icon' theme option.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function saga_get_header_icon_choices() {

	$icons = array( '' => '' );

	foreach ( saga_get_font_icons() as $class => $code )
		$icons[ $class ] = "&#x{$code};";

	return $icons;
}

/**
 * Loads theme customizer JavaScript.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_enqueue_customizer_scripts() {

	$suffix = hybrid_get_min_suffix();

	wp_enqueue_script( 'saga-customize', trailingslashit( get_template_directory_uri() ) . "js/customize{$suffix}.js", array( 'jquery' ), null, true );
}

/**
 * Loads theme customizer CSS.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_customize_controls_print_styles() {

	$suffix = hybrid_get_min_suffix();

	wp_enqueue_style( 'font-awesome', trailingslashit( get_template_directory_uri() ) . "css/font-awesome{$suffix}.css" );
}
