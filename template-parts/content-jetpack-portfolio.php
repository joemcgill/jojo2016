<?php
/**
 * Template part for displaying portfolio.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Jojo2016
 */

?>

<?php if ( get_query_var( 'js-tmpl', false ) ) { ?>
<script id="tmpl-portfolio-item" type="text/template">
	<header class="entry-header">
		<a href="{{ data.link }}">
			<img width="500" height="500" src="{{ data.thumbnail.src }}" class="attachment-square-500 size-square-500 wp-post-image" alt="{{ data.thumbnail.alt }}" srcset="{{ data.thumbnail.srcset }}" sizes="(max-width: 50em) calc(50vw - 3em), (max-width: 68em) calc(25vw - 8em), 244px">
		</a>
		<h3 class="portfolio-title"><a href="{{ data.link }}" rel="bookmark">{{ data.title.rendered }}</a></h3>
	</header>
</script>
<?php } else { ?>
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
<?php } ?>
