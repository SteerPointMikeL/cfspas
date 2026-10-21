<?php

define('SP_TEXT_DOMAIN', 'cfspas');

require_once( get_template_directory() . '/functions/filters.php' );
require_once( get_template_directory() . '/functions/shortcodes.php' );
require_once( get_template_directory() . '/functions/tags.php' );
require_once( get_template_directory() . '/functions/class-wp-widget-recent-posts-with-thumbnails.php' );
require_once( get_template_directory() . '/functions/walker_nav_menu_large_with_thumbnails.php' );

if (
	in_array( 'advanced-custom-fields/acf.php', apply_filters( 'active_plugins', get_option('active_plugins') ) ) ||
	in_array( 'advanced-custom-fields-pro/acf.php', apply_filters( 'active_plugins', get_option('active_plugins') ) )
) {
	require_once( get_template_directory() . '/functions/acf.php' );
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option('active_plugins') ) ) ) {
	require_once( get_template_directory() . '/functions/woocommerce.php' );
} else if ( !function_exists( 'is_shop' ) ) {
	function is_shop() {}
}


function sp_after_setup_theme() {
	
	// Make theme available for translation
	load_theme_textdomain( SP_TEXT_DOMAIN, get_template_directory() . '/languages' );
	
	// Featured Images
	add_theme_support( 'post-thumbnails', array('post') );
	add_image_size( 'sp_medium_less_large', 500, 500 );
	
	// HTML5 markup
	add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'widgets', 'navigation-widgets') );
	
	// Document title
	add_theme_support( 'title-tag' );
	
	// Menus
	register_nav_menus( array(
		'header'   => __( 'Header', SP_TEXT_DOMAIN ),
		'mobile'   => __( 'Mobile', SP_TEXT_DOMAIN ),
		'footer-1' => __( 'Footer (1)', SP_TEXT_DOMAIN ),
		'footer-2' => __( 'Footer (2)', SP_TEXT_DOMAIN ),
		'footer-3' => __( 'Footer (3)', SP_TEXT_DOMAIN ),
	) );
	
	// Remove global styles and duotone support from frontend
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
	
}
add_action('after_setup_theme', 'sp_after_setup_theme');


function sp_init() {
	
	// Define custom post types and taxonomies here
	
}
add_action('init', 'sp_init');


function sp_widgets_init() {
	
	// Names of sidebars to create
	$sidebars = array(
		array('name' => __( 'Sidebar', SP_TEXT_DOMAIN ),        'id' => 'sidebar' ),
		array('name' => __( 'Blog', SP_TEXT_DOMAIN ),           'id' => 'blog' ),
		array('name' => __( 'About', SP_TEXT_DOMAIN ),          'id' => 'about' ),
		array('name' => __( 'Shop', SP_TEXT_DOMAIN ),           'id' => 'shop' ),
		array('name' => __( 'Single Product', SP_TEXT_DOMAIN ), 'id' => 'single-product' ),
	);
	
	foreach ($sidebars as $sidebar) {
		register_sidebar( array(
			'name'          => $sidebar['name'],
			'id'            => $sidebar['id'],
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );
	}
	
}
add_action('widgets_init', 'sp_widgets_init');


function sp_enqueue_scripts() {
	$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	
	wp_register_style( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel' . $suffix . '.css' );
	wp_register_style( 'glightbox', get_template_directory_uri().'/js/glightbox' . $suffix . '.css' );
	wp_register_style( 'lite-youtube-embed', get_template_directory_uri().'/js/lite-yt-embed.css' );
	
	wp_enqueue_style( 'googleapis-fonts', '//fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap' );
	wp_enqueue_style( 'icomoon', get_template_directory_uri() . '/icons/style.css' );
	wp_enqueue_style( 'jquery-modal', get_template_directory_uri().'/js/jquery.modal' . $suffix . '.css' );
	wp_enqueue_style( SP_TEXT_DOMAIN.'-styles', get_stylesheet_uri() );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
	
	wp_register_script( 'jquery-cycle2', get_template_directory_uri() . '/js/jquery.cycle2' . $suffix . '.js', null, '2.1.6', true );
	wp_register_script( 'jquery-cycle2-swipe', get_template_directory_uri() . '/js/jquery.cycle2.swipe' . $suffix . '.js', array('jquery-cycle2'), '20121120', true );
	wp_register_script( 'js-cookie', get_template_directory_uri().'/js/js.cookie' . $suffix . '.js', array('jquery'), '3.0.5', true );
	wp_register_script( 'jquery-modal', get_template_directory_uri() . '/js/jquery.modal' . $suffix . '.js', array('jquery'), '0.9.2', true );
	wp_register_script( 'wow', get_template_directory_uri() . '/js/wow' . $suffix . '.js', null, '1.1.2', true );
	wp_register_script( 'owl-carousel', get_template_directory_uri().'/js/owl.carousel' . $suffix . '.js', array('jquery'), '2.3.4', true );
	wp_register_script( 'glightbox', get_template_directory_uri().'/js/glightbox' . $suffix . '.js', null, '1.1.2', true );
	wp_register_script( 'lite-youtube-embed', get_template_directory_uri() . '/js/lite-yt-embed.js', null, '0.3.3', true );
	wp_register_script( 'lite-vimeo', get_template_directory_uri().'/js/lite-vimeo' . $suffix . '.js', null, '0.1.1', true );
	
	wp_enqueue_script( SP_TEXT_DOMAIN.'-script', get_template_directory_uri().'/js/functions.js', array('jquery', 'js-cookie', 'jquery-modal', 'wow'), null, true );
}
add_action('wp_enqueue_scripts', 'sp_enqueue_scripts');