<?php
/**
 * Custom widgets or widget overrides go here.
 *
 * @package Jojo2016
 */

// Load the social media icon widget
require get_template_directory() . '/inc/class-jojo-social-widget.php';

// Register widgets
function jojo_register_widgets() {
	register_widget( 'Jojo_Social_Widget' );
}
add_action( 'widgets_init', 'jojo_register_widgets' );
