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
				// Set up category placeholder
				$current_category = '';

				/* Start the Loop */
				foreach ( $portfolio_terms as $term ) {

					if ( ! is_tax() || is_tax( 'jetpack-portfolio-type', $term ) ) {
						$tile_html = '<div class="jetpack-portfolio jetpack-porfolio-tile jetpack-portfolio-type-%s"><h2 class="jetpack-portfolio-tile-title">%s</h2></div>';
						printf( $tile_html, $term->slug, $term->name );
					}

					while ( have_posts() ) : the_post();
						if ( has_term( $term->name, 'jetpack-portfolio-type', $post ) ) {
							get_template_part( 'template-parts/content-jetpack-portfolio' );
						}
					endwhile;

					rewind_posts();
				}
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

$posts = get_portfolio_data();

function get_portfolio_data() {
	if ( ! $posts = get_transient( 'portfolio-items' ) ) {
		$posts = wp_remote_get( get_site_url() . '/wp-json/wp/v2/jetpack-portfolio?filter[posts_per_page]=100' );

		// Cache portfolio results for 10 minutes.
		set_transient( 'portfolio-items', $posts, 300 );
	}

	return $posts;
}

wp_localize_script( 'jojo2016-portfolo', 'portfolioData', array( 'portfolioTypes' => $portfolio_terms, 'portfolioItems' => json_decode( $posts['body'] ) ) );
get_footer();
