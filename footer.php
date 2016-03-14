<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Jojo2016
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-categories">
			<h3 class="section-slug">Browse by category</h3>
			<div class="category-list">
				<?php jojo2016_the_category_items(); ?>
			</div>
		</div>
		<div class="site-footer-meta">
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'jojo2016' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'jojo2016' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( esc_html__( 'Theme design by: %1$s. Site development by: %2$s.', 'jojo2016' ), '<a href="http://ashsmash.com/" rel="designer">Ash Huang</a>', '<a href="http://joemcgill.net/" rel="developer">Joe McGill</a>' ); ?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
