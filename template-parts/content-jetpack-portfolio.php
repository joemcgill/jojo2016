<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Jojo2016
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( has_post_thumbnail() ) {
			printf( '<a href="%1$s">%2$s</a>', get_the_permalink(), get_the_post_thumbnail( null, 'square-500' ) );
		}

		the_title( '<h3 class="portfolio-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		?>
	</header><!-- .entry-header -->

</article><!-- #post-## -->
