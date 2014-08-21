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

		<?php if ( is_page( get_the_ID() ) ) : // If viewing a single post. ?>

			<header class="entry-header">
				<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>
			</header><!-- .entry-header -->

			<div <?php hybrid_attr( 'entry-content' ); ?>>
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div><!-- .entry-content -->

		<?php else : // If not viewing a single post. ?>

			<header class="entry-header">
				<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<div <?php hybrid_attr( 'entry-summary' ); ?>>
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

		<?php endif; // End single post check. ?>

	</div><!-- .wrap -->

</article><!-- .entry -->