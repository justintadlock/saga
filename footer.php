			</div><!-- #main -->

		</div><!-- .wrap -->

		<footer <?php hybrid_attr( 'footer' ); ?>>

			<div class="wrap">

		<?php locate_template( array( 'misc/loop-nav.php' ), true ); // Loads the misc/loop-nav.php template. ?>

				<?php //hybrid_get_menu( 'social' ); // Loads the menu/social.php template. ?>

				<?php //if ( !has_nav_menu( 'social' ) ) : // Check if there's a menu assigned to the 'social' location. ?>

					<p class="credit">
						<?php printf(
							/* Translators: 1 is current year, 2 is site name/link, 3 is WordPress name/link, and 4 is theme name/link. */
							__( 'Copyright &#169; %1$s %2$s. Powered by %3$s and %4$s.', 'saga' ), 
							date_i18n( 'Y' ), hybrid_get_site_link(), hybrid_get_wp_link(), hybrid_get_theme_link()
						); ?>
					</p><!-- .credit -->

				<?php //endif; // End check for menu. ?>

			</div><!-- .wrap -->

		</footer><!-- #footer -->

	</div><!-- #container -->

	<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer. ?>

</body>
</html>