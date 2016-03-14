<?php
/**
 * The template for displaying portfolio archives.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Jojo2016
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main full-width" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">Portfolio</h1>
				<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
			</header><!-- .page-header -->

			<div class="portfolio-list">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content-jetpack-portfolio' );

			endwhile;
			?>
			</div>

			<?php
			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
