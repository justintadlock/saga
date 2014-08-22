<?php
/**
 * Handles the setup and usage of the WordPress custom headers feature.
 *
 * @package    Saga
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2014, Justin Tadlock
 * @link       http://themehybrid.com/themes/saga
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Call late so child themes can override. */
add_action( 'after_setup_theme', 'saga_custom_header_setup', 15 );

/**
 * Adds support for the WordPress 'custom-header' theme feature and registers custom headers.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_custom_header_setup() {

	/* Adds support for WordPress' "custom-header" feature. */
	add_theme_support( 
		'custom-header', 
		array(
			'default-image'          => '',
			'random-default'         => false,
			'width'                  => 1100,
			'height'                 => 300,
			'flex-width'             => true,
			'flex-height'            => true,
			'default-text-color'     => 'dadada',
			'header-text'            => true,
			'uploads'                => true,
			'wp-head-callback'       => 'saga_custom_header_wp_head',
			'admin-head-callback'    => 'saga_custom_header_admin_head',
			'admin-preview-callback' => 'saga_custom_header_admin_preview',
		)
	);

	/* Load the stylesheet for the custom header screen. */
	add_action( 'admin_enqueue_scripts', 'saga_enqueue_admin_custom_header_styles', 5 );
}

/**
 * Enqueues the styles for the "Appearance > Custom Header" screen in the admin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_enqueue_admin_custom_header_styles( $hook_suffix ) {

	if ( 'appearance_page_custom-header' === $hook_suffix ) {
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'saga-fonts' );
		wp_enqueue_style( 'saga-admin-custom-header' );

		if ( is_child_theme() ) {
			$dir = trailingslashit( get_stylesheet_directory() );
			$uri = trailingslashit( get_stylesheet_directory_uri() );

			if ( file_exists( $dir . 'css/admin-custom-header.css' ) )
				wp_enqueue_style( get_stylesheet() . '-admin-custom-header', "{$uri}css/admin-custom-header.css" );
		}
	}
}

/**
 * Callback function for outputting the custom header CSS to `wp_head`.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_custom_header_wp_head() {

	if ( !display_header_text() )
		return;

	$hex = get_header_textcolor();

	if ( empty( $hex ) )
		return;

	$style = '';

	$rgb = hybrid_hex_to_rgb( $hex );

	$style .= "#site-title, #site-title a, #footer .credit a { color: #{$hex} }";

	$style .= "#site-description, #footer .credit { color: rgba( {$rgb['r']}, {$rgb['g']}, {$rgb['b']}, 0.75 ); }";

	echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
}

/**
 * Callback for the admin preview output on the "Appearance > Custom Header" screen.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_custom_header_admin_preview() { ?>

		<div <?php hybrid_attr( 'body' ); // Fake <body> class. ?>>

			<header <?php hybrid_attr( 'header' ); ?>>

				<?php if ( display_header_text() ) : // If user chooses to display header text. ?>

					<div id="branding">
						<?php hybrid_site_title(); ?>
						<?php hybrid_site_description(); ?>
					</div><!-- #branding -->

				<?php endif; // End check for header text. ?>

			</header><!-- #header -->

			<?php if ( get_header_image() && !display_header_text() ) : // If there's a header image but no header text. ?>

				<a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><img class="header-image" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>

			<?php elseif ( get_header_image() ) : // If there's a header image. ?>

				<img class="header-image" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />

			<?php endif; // End check for header image. ?>

		</div><!-- Fake </body> close. -->

<?php }

/**
 * Callback function for outputting the custom header CSS to `admin_head` on "Appearance > Custom Header".  See 
 * the `css/admin-custom-header.css` file for all the style rules specific to this screen.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function saga_custom_header_admin_head() {

	if ( !display_header_text() )
		return;

	$hex = get_header_textcolor();

	if ( empty( $hex ) )
		return;

	$rgb = hybrid_hex_to_rgb( $hex );

	$style = "#site-title, #site-title a { color: #{$hex} }";

	$style .= "#site-description { color: rgba( {$rgb['r']}, {$rgb['g']}, {$rgb['b']}, 0.75 ); }";

	/* Get the background color. */
	$color = get_background_color();

	if ( !empty( $color ) )
		$style .= "div.wordpress{ background: #{$color}; }";

	echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
}
