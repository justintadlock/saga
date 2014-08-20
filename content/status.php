<article <?php hybrid_attr( 'post' ); ?>>

	<div class="wrap">

		<?php if ( is_single( get_the_ID() ) ) : // If viewing a single post. ?>

			<?php if ( get_option( 'show_avatars' ) ) : // If avatars are enabled. ?>

				<header class="entry-header">
					<?php echo get_avatar( get_the_author_meta( 'email' ) ); ?>
				</header><!-- .entry-header -->

			<?php endif; // End avatars check. ?>

			<div <?php hybrid_attr( 'entry-content' ); ?>>
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php hybrid_post_format_link(); ?>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'saga' ); ?></span>
				<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
				<?php hybrid_post_terms( array( 'taxonomy' => 'category', 'before' => '<br />' ) ); ?>
				<?php hybrid_post_terms( array( 'taxonomy' => 'post_tag', 'before' => sprintf( '<span class="sep">%s</span>', _x( '&middot;', 'post meta separator', 'saga' ) ) ) ); ?>
			</footer><!-- .entry-footer -->

		<?php else : // If not viewing a single post. ?>

			<?php if ( get_option( 'show_avatars' ) ) : // If avatars are enabled. ?>

				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_avatar( get_the_author_meta( 'email' ) ); ?></a>

			<?php endif; // End avatars check. ?>

			<div <?php hybrid_attr( 'entry-content' ); ?>>
				<?php the_content(); ?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php hybrid_post_format_link(); ?>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'saga' ); ?></span>
				<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'saga' ); ?></span>
				<a class="entry-permalink" href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url"><?php _e( 'Permalink', 'saga' ); ?></a>
				<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'saga' ); ?></span>
				<?php comments_popup_link( false, false, false, 'comments-link' ); ?>
			</footer><!-- .entry-footer -->

		<?php endif; // End single post check. ?>

	</div><!-- .wrap -->

</article><!-- .entry -->