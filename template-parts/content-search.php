<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Jojo2016
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'thumbnail', array( 'class' => 'alignright' ) );
		} else {
			$attachments = get_attached_media( 'image' );
			if ( ! empty( $attachments ) ) {
				// Make sure we're on the first image in the loop.
				reset( $attachments );
				echo wp_get_attachment_image( key( $attachments ), 'thumbnail', false, array( 'class' => 'alignright' ) );
			}
		}
		?>
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-## -->
