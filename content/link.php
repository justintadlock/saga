<article <?php hybrid_attr( 'post' ); ?>>

	<?php get_the_image( 
		array( 
			'size'         => 'saga-large', 
			'min_width'    => 1100, 
			'min_height'   => 500, 
			'order'        => array( 'featured' ), 
			'link_to_post' => is_singular() ? false : true, 
			'before'       => '<div class="featured-media">', 
			'after'        => '</div>' 
		) 
	); ?>

	<div class="wrap">

		<?php if ( is_single( get_the_ID() ) ) : // If viewing a single post. ?>

			<header class="entry-header">

				<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

				<div class="entry-byline">
					<?php hybrid_post_format_link(); ?>
					<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'saga' ); ?></span>
					<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
					<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'saga' ); ?></span>
					<?php comments_popup_link( false, false, false, 'comments-link' ); ?>
				</div><!-- .entry-byline -->

			</header><!-- .entry-header -->

			<div <?php hybrid_attr( 'entry-content' ); ?>>
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php hybrid_post_terms( array( 'taxonomy' => 'category', 'text' => __( 'Posted in %s', 'saga' ) ) ); ?>
				<?php hybrid_post_terms( array( 'taxonomy' => 'post_tag', 'text' => __( 'Tagged %s', 'saga' ), 'before' => '<br />' ) ); ?>
			</footer><!-- .entry-footer -->

		<?php else : // If not viewing a single post. ?>

			<header class="entry-header">
				<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . hybrid_get_the_post_format_url() . '">', is_rtl() ? ' <span class="meta-nav">&larr;</span>' : ' <span class="meta-nav">&rarr;</span>' . '</a></h2>' ); ?>
			</header><!-- .entry-header -->

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