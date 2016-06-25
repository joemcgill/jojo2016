<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Jojo2016
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function jojo2016_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'jojo2016_infinite_scroll_render',
		'footer'    => 'page',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'jojo2016_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function jojo2016_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		else :
			get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
}

/**
 * Remove the automatic placement of jetpack so we can put it where we want.
 * See: https://jetpack.me/2013/06/10/moving-sharing-icons/
 */
function jptweak_remove_share() {
	remove_filter( 'the_content', 'sharing_display',19 );
	remove_filter( 'the_excerpt', 'sharing_display',19 );
}
add_action( 'loop_start', 'jptweak_remove_share' );

/**
 * Register custom REST API fields for jetpack portfolio items.
 */
function jojo2016_register_rest_fields() {
	register_rest_field( 'jetpack-portfolio', 'thumbnail', array(
		'get_callback'    => 'get_jojo_portfolio_thumbnail_api_data',
		'update_callback' => null,
		'schema'          => null,
	) );

	register_rest_field( 'jetpack-portfolio', 'portfolioType', array(
		'get_callback'    => 'get_jojo_portfolio_terms_api_data',
		'update_callback' => null,
		'schema'          => null,
	) );
}
add_action( 'rest_api_init', 'jojo2016_register_rest_fields' );

/**
 * Callback function for REST API requests for thumbnail.
 */
function get_jojo_portfolio_thumbnail_api_data( $object, $field_name, $request ) {
	// Try to retrieve the thumbnail from a transient.
	$thumbnail = get_transient( 'jojo_portfolio_thumbnail' . $object['id'] );

	// If we don't have the thumnbail data, try to build it.
	if ( ! $thumbnail && $thumbnail['id'] = get_post_thumbnail_id( $object['id'] ) ) {
		$image = wp_get_attachment_image_src( $thumbnail['id'], 'square-500' );

		$thumbnail['alt']      = trim( strip_tags( get_post_meta( $thumbnail['id'], '_wp_attachment_image_alt', true ) ) );
		$thumbnail['src']      = $image[0];
		$thumbnail['width']    = $image[1];
		$thumbnail['height']   = $image[2];
		$thumbnail['metadata'] = wp_get_attachment_metadata( $thumbnail['id'] );
		$thumbnail['srcset']   = wp_calculate_image_srcset( array( $image[1], $image[2] ), $image[0], $thumbnail['metadata'], $thumbnail['id'] );

		// Save it for later.
		set_transient( 'jojo_portfolio_thumbnail' . $object['id'], $thumbnail, HOUR_IN_SECONDS );
	}

	return $thumbnail;
}

/**
 * Callback function for REST API requests for terms.
 */
function get_jojo_portfolio_terms_api_data( $object, $field_name, $request ) {
	$portfolio_types = array();

	$terms = get_the_terms( $object['id'], 'jetpack-portfolio-type' );

	foreach ( $terms as $term ) {
		$portfolio_types[] = $term->slug;
	}

	return $portfolio_types;
}

/**
 * Load our portfolio scripts on the portfolio archive page or taxonomy archive.
 */
function jojo2016_load_portfolio_scripts() {
	if ( is_post_type_archive( 'jetpack-portfolio' ) || is_tax( 'jetpack-portfolio-type' ) ) {
		wp_enqueue_script( 'jojo2016-portfolo', get_template_directory_uri() . '/assets/js/portfolio.js', array( 'wp-backbone' ), null, true );
	}
}
add_action( 'wp_enqueue_scripts', 'jojo2016_load_portfolio_scripts' );

/**
 * Filter the sizes attribute for the portfolio grid.
 */
function jojo2016_filter_portfolio_sizes( $sizes ) {
	// Bail early if we're not in the main loop.
	if ( ! in_the_loop() ) {
		return $sizes;
	}

	if ( is_post_type_archive( 'jetpack-portfolio' ) || is_tax( 'jetpack-portfolio-type' ) ) {
		$sizes = '(max-width: 50em) calc(50vw - 3em), (max-width: 68em) calc(25vw - 8em), 244px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'jojo2016_filter_portfolio_sizes' );

add_post_type_support( 'jetpack-portfolio', 'page-attributes' );

// If Simple Page Ordering is active, filter the portfolio order.
if ( class_exists( 'Simple_Page_Ordering' ) ) {
	add_action( 'pre_get_posts', 'jojo2016_filter_jetpack_portfolio_query' );

	function jojo2016_filter_jetpack_portfolio_query( $query ) {
		if ( ! is_admin() && ( 'jetpack-portfolio' === $query->get( 'post_type' ) || isset( $query->query['jetpack-portfolio-type'] ) ) ) {
			$query->set( 'orderby', 'menu_order' );
			$query->set( 'order', 'ASC' );
		}
	}
}

function jojo2016_remove_attachment_comments( $open, $post_id ) {
	$post = get_post( $post_id );
	if ( 'attachment' === $post->post_type ) {
		return false;
	}

	return $open;
}
add_filter( 'comments_open', 'jojo2016_remove_attachment_comments', 10 , 2 );

function jojo2016_related_custom_image( $media, $post_id, $args ) {
	if ( $media ) {
			return $media;
	} else {
		$permalink = get_permalink( $post_id );
		$url = apply_filters( 'jetpack_photon_url', get_stylesheet_directory_uri() . '/assets/img/jetpack-default.jpg' );

		return array(
			array(
				'type'  => 'image',
				'from'  => 'custom_fallback',
				'src'   => esc_url( $url ),
				'href'  => $permalink,
			),
		);
	}
}
add_filter( 'jetpack_images_get_images', 'jojo2016_related_custom_image', 10, 3 );
