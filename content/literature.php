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

				<div class="entry-meta">
					<?php hybrid_post_terms( array( 'taxonomy' => 'literary_form' ) ); ?>
					<?php hybrid_post_terms( array( 'taxonomy' => 'literary_technique', 'before' => sprintf( '<span class="sep">%s</span>', _x( '&middot;', 'post meta separator', 'saga' ) ) ) ); ?>
					<?php hybrid_post_terms( array( 'taxonomy' => 'literary_genre', 'before' => sprintf( '<span class="sep">%s</span>', _x( '&middot;', 'post meta separator', 'saga' ) ) ) ); ?>
				</div><!-- .entry-meta -->

				<div class="entry-byline">
					<?php hybrid_post_author( array( 'text' => __( 'Written by %s', 'saga' ) ) ); ?>
				</div><!-- .entry-byline -->

			</header><!-- .entry-header -->

			<div <?php hybrid_attr( 'entry-content' ); ?>>
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div><!-- .entry-content -->


		<?php else : // If not viewing a single post. ?>

			<header class="entry-header">

				<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

				<div class="entry-byline">
					<?php hybrid_post_terms( array( 'taxonomy' => 'literary_form' ) ); ?>
					<?php hybrid_post_terms( array( 'taxonomy' => 'literary_technique', 'before' => sprintf( '<span class="sep">%s</span>', _x( '&middot;', 'post meta separator', 'saga' ) ) ) ); ?>
					<?php hybrid_post_terms( array( 'taxonomy' => 'literary_genre', 'before' => sprintf( '<span class="sep">%s</span>', _x( '&middot;', 'post meta separator', 'saga' ) ) ) ); ?>
				</div><!-- .entry-byline -->

			</header><!-- .entry-header -->

			<div <?php hybrid_attr( 'entry-summary' ); ?>>
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

		<?php endif; // End single post check. ?>

	</div><!-- .wrap -->

</article><!-- .entry -->