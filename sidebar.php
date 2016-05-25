<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Jojo2016
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

// Disable the Featured Video Plus filter on sidebar items.
global $featured_video_plus;
if ( ! is_null( $featured_video_plus ) ) {
	remove_filter( 'post_thumbnail_html', array( $featured_video_plus, 'filter_post_thumbnail' ), 99, 5 );
}

?>
<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
