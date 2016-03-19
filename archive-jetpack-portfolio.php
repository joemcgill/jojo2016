<?php
/**
 * The template for displaying portfolio archives.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Jojo2016
 */

get_header(); ?>

	<div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">Portfolio</h1>
				<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
			</header><!-- .page-header -->
			<div class="portfolio">
				<?php
				if ( $portfolio_terms = get_terms( 'jetpack-portfolio-type', array( 'orderby' => 'name' ) ) ) {
				?>
				<nav class="portfolio-nav">
					<ul class="list-inline">
						<li class="portfolio-category-link"><a href="/portfolio">All Projects</a></li>
						<?php foreach ( $portfolio_terms as $term ) { ?>
						<li class="portfolio-category-link"><a href="/project-type/<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
						<?php } ?>
					</ul>
				</nav>
				<?php } ?>
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
			</div>

			<?php
			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
set_query_var( 'js-tmpl', true );
get_template_part( 'template-parts/content-jetpack-portfolio' );
get_footer();
