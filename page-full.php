<?php
/**
 * Template Name: Full Width Page
 *
 * @package Jojo2016
 * @since 1.1.0
 */

get_header(); ?>

	<div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
