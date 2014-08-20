<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_attachment( get_the_ID() ) ) : // If viewing a single attachment. ?>

		<?php if ( has_excerpt() ) : // If the image has an excerpt/caption. ?>

			<?php $src = wp_get_attachment_image_src( get_the_ID(), 'full' ); ?>

			<div class="featured-media">
				<?php echo img_caption_shortcode( array( 'align' => 'aligncenter', 'width' => esc_attr( $src[1] ), 'caption' => get_the_excerpt() ), wp_get_attachment_image( get_the_ID(), 'saga-large', false ) ); ?>
			</div><!-- .featured-media -->

		<?php else : // If the image doesn't have a caption. ?>

			<div class="featured-media">
				<?php echo wp_get_attachment_image( get_the_ID(), 'saga-large', false, array( 'class' => 'aligncenter' ) ); ?>
			</div><!-- .featured-media -->

		<?php endif; // End check for image caption. ?>

		<div class="wrap">

			<header class="entry-header">

				<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

				<div class="entry-byline">
					<span class="image-sizes"><?php printf( __( 'Sizes: %s', 'saga' ), hybrid_get_image_size_links() ); ?></span>
				</div><!-- .entry-byline -->

			</header><!-- .entry-header -->

			<div <?php hybrid_attr( 'entry-content' ); ?>>
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div><!-- .entry-content -->

		</div><!-- .wrap -->

	<?php else : // If not viewing a single post. ?>

		<?php get_the_image(
			array( 
				'size'       => 'saga-large', 
				'min_width'  => 1100, 
				'min_height' => 500, 
				'order'      => array( 'featured', 'attachment' ), 
				'before'     => '<div class="featured-media">', 
				'after'      => '</div>' 
			) 
		); ?>

		<div class="wrap">

			<header class="entry-header">
				<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<div <?php hybrid_attr( 'entry-summary' ); ?>>
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

		</div><!-- .wrap -->

	<?php endif; // End single attachment check. ?>

</article><!-- .entry -->

<?php if ( is_attachment( get_the_ID() ) ) : // If viewing a single attachment. ?>

	<div class="attachment-meta">

		<div class="media-info image-info">

			<h3 class="attachment-meta-title"><?php _e( 'Image Info', 'saga' ); ?></h3>

			<?php hybrid_media_meta(); ?>

		</div><!-- .media-info -->

		<?php $gallery = gallery_shortcode( array( 'columns' => 4, 'numberposts' => 8, 'orderby' => 'rand', 'id' => get_queried_object()->post_parent, 'exclude' => get_the_ID() ) ); ?>

		<?php if ( !empty( $gallery ) ) : // Check if the gallery is not empty. ?>

			<div class="image-gallery">
				<h3 class="attachment-meta-title"><?php _e( 'Gallery', 'saga' ); ?></h3>
				<?php echo $gallery; ?>
			</div>

		<?php endif; // End gallery check. ?>

	</div><!-- .attachment-meta -->

<?php endif; // End single attachment check. ?>