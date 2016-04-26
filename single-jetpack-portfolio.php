<?php
/**
 * The template for displaying all single portfolios.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Jojo2016
 */

get_header(); ?>

	<div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main">

		<?php


		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content-jetpack-portfolio-full' );

			the_post_navigation();

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
