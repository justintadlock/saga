<?php 
/**
 * The theme doesn't use this template by default.  It's simply here to serve as an example template for 
 * DIY-users who want to add a sidebar to the theme.
 */

if ( is_active_sidebar( 'primary' ) ) : ?>

	<aside id="sidebar-primary" class="sidebar">

		<?php dynamic_sidebar( 'primary' ); ?>

	</aside><!-- #sidebar-primary -->

<?php endif; ?>