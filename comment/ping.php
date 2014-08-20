<li <?php hybrid_attr( 'comment' ); ?>>

	<header class="comment-meta">
		<cite <?php hybrid_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite><br />
		<time <?php hybrid_attr( 'comment-published' ); ?>><?php printf( __( '%s ago', 'saga' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time>
		<span class="sep"><?php _ex( '&middot;', 'comment meta separator', 'saga' ); ?></span>
		<a <?php hybrid_attr( 'comment-permalink' ); ?>><?php _e( 'Permalink', 'saga' ); ?></a>
		<?php edit_comment_link( null, '<span class="sep">' . _x( '&middot;', 'comment meta separator', 'saga' ) . '</span>' ); ?>
	</header><!-- .comment-meta -->

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>