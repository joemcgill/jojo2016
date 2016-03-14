<?php
/**
 * Jojo2016 functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Jojo2016
 */

if ( ! function_exists( 'jojo2016_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function jojo2016_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Jojo2016, use a find and replace
		 * to change 'jojo2016' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'jojo2016', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'jojo2016' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'jojo2016_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add custom image sizes.
		add_image_size( 'square-500', 500, 500, true );
	}
endif;
add_action( 'after_setup_theme', 'jojo2016_setup' );

if ( ! function_exists( 'jojo2016_content_width' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function jojo2016_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'jojo2016_content_width', 640 );
	}
endif;
add_action( 'after_setup_theme', 'jojo2016_content_width', 0 );


if ( ! function_exists( 'jojo2016_widgets_init' ) ) :
	/**
	 * Register widget area.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function jojo2016_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'jojo2016' ),
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
endif;
add_action( 'widgets_init', 'jojo2016_widgets_init' );

if ( ! function_exists( 'jojo2016_scripts' ) ) :
	/**
	 * Enqueue scripts and styles.
	 */
	function jojo2016_scripts() {
		wp_enqueue_style( 'jojo2016-style', get_stylesheet_uri() );

		wp_enqueue_script( 'jojo2016-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

		wp_enqueue_script( 'jojo2016-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
endif;
add_action( 'wp_enqueue_scripts', 'jojo2016_scripts' );

if ( ! function_exists( 'jojo_load_typekit' ) ) :
	/**
	 * Enqueue Typekit scripts
	 */
	function jojo_load_typekit() {
		?>
		<script src="https://use.typekit.net/rkf4jbu.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>
		<?php
	}
endif;
add_action( 'wp_head', 'jojo_load_typekit' );

/**
 * Filter the search form markup.
 */
function jojo2016_filter_search_form( $form ) {
	return preg_replace( '|placeholder="[^"]+"|', 'placeholder="Search Jojotastic"', $form );
}
add_filter( 'get_search_form', 'jojo2016_filter_search_form' );

/**
 * Filter the archive page title HTML.
 */
function jojo2016_filter_the_archive_title( $title ) {
	return preg_replace( '|: (.+)|', ': <span class="archive-title">$1</span>', $title );
}
add_filter( 'get_the_archive_title', 'jojo2016_filter_the_archive_title' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
