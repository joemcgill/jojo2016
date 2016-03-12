<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Jojo2016
 */

if ( ! function_exists( 'jojo2016_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function jojo2016_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'jojo2016' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'By %s', 'post author', 'jojo2016' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	$tagged = get_the_tag_list( 'Tagged: ', ' ');

	if ( $tagged ) {
		$tagged = sprintf( '<span class="tagged">%s</span>', get_the_tag_list( 'Tagged: ', ' ') );
	};

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline">' . $byline . '</span>' . $tagged; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'jojo2016_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function jojo2016_entry_footer() {
	global $post;
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'jojo2016' ) );
		if ( $categories_list && jojo2016_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'jojo2016' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		// /* translators: used between list items, there is a space after the comma */
		// $tags_list = get_the_tag_list( '', esc_html__( ', ', 'jojo2016' ) );
		// if ( $tags_list ) {
		// 	printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'jojo2016' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		// }
	}
	if ( current_user_can( 'edit_post', $post->post_id ) ) {
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'jojo2016' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}


	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Comment', 'jojo2016' ), esc_html__( '1 Comment', 'jojo2016' ), esc_html__( '% Comments', 'jojo2016' ) );
		echo '</span>';
	}

	// Show sharing links.
	if ( function_exists( 'sharing_display' ) ) {
		echo '<span class="sharing-label">Share</span>';
		sharing_display( '', true );
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function jojo2016_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'jojo2016_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'jojo2016_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so jojo2016_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so jojo2016_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in jojo2016_categorized_blog.
 */
function jojo2016_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'jojo2016_categories' );
}
add_action( 'edit_category', 'jojo2016_category_transient_flusher' );
add_action( 'save_post',     'jojo2016_category_transient_flusher' );


function jojo2016_the_category_items( $categories = array() ) {
	$defaults = array(
		'fashion',
		'home-decor-interiors',
		'happy-holidays',
		'shopping-gift-guides',
	);

	if ( ! is_array( $categories ) || empty( $categories ) ) {
		$categories = $defaults;
	}

	foreach ( $categories as $slug ) {
		// Get the ID of a given category.
		$category = get_category_by_slug( $slug );

		// Skip if the category isn't found.
		if ( ! $category ) {
			continue;
		}

		// Get the URL of this category.
		$category_link = get_term_link( $category->term_id );

		// Create the thumbnail.
		$post_meta_query = array(
			'key' => '_thumbnail_id',
			'compare' => 'EXISTS',
		);

		$post_query_args = array(
			'cat'            => $category->cat_ID,
			'meta_query'     => array(
				'key'     => '_thumbnail_id',
				'compare' => 'EXISTS',
			),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		);

		$post_query = new WP_Query( $post_query_args );

		if ( $post_query ) {
			$category_thumbnail_url = get_the_post_thumbnail_url( $post_query->posts[0], 'thumbnail' );
		} else {
			$category_thumbnail_url = 'https://placehold.it/400x400';
		}

		$category_thumbnail = sprintf( '<img class="category-thumb" src="%s">', esc_url( $category_thumbnail_url ) );

		// Get the name of this category
		$category_name = $category->name;

		// Output the category items.
		printf( '<div class="category-item"><a href="%1$s">%2$s</a><div class="category-name"><a href="%1$s">%3$s</a></div></div>', $category_link, $category_thumbnail, $category_name );
	}
}
