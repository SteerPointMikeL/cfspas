<?php

define('SP_TEXT_DOMAIN', 'cfspas');

require_once( get_template_directory() . '/functions/filters.php' );
require_once( get_template_directory() . '/functions/shortcodes.php' );
require_once( get_template_directory() . '/functions/products.php' );
require_once( get_template_directory() . '/functions/tags.php' );
require_once( get_template_directory() . '/functions/class-wp-widget-recent-posts-with-thumbnails.php' );
require_once( get_template_directory() . '/functions/walker_nav_menu_large_with_thumbnails.php' );

if (
	in_array( 'advanced-custom-fields/acf.php', apply_filters( 'active_plugins', get_option('active_plugins') ) ) ||
	in_array( 'advanced-custom-fields-pro/acf.php', apply_filters( 'active_plugins', get_option('active_plugins') ) )
) {
	require_once( get_template_directory() . '/functions/acf.php' );
}

function sp_after_setup_theme() {
	
	// Make theme available for translation
	load_theme_textdomain( SP_TEXT_DOMAIN, get_template_directory() . '/languages' );
	
	// Featured Images
	add_theme_support( 'post-thumbnails', array('post', 'cfspas_product', 'cfspas_feature') );
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
	
	// Custom Post Type for Product
	register_post_type( 'cfspas_product', array(
		'labels' => array(
			'name'               => __( 'Products', SP_TEXT_DOMAIN ),
			'singular_name'      => __( 'Product', SP_TEXT_DOMAIN ),
			'all_items'          => __( 'All Products', SP_TEXT_DOMAIN ),
			'add_new_item'       => __( 'Add New Product', SP_TEXT_DOMAIN ),
			'edit_item'          => __( 'Edit Product', SP_TEXT_DOMAIN ),
			'new_item'           => __( 'New Product', SP_TEXT_DOMAIN ),
			'view_item'          => __( 'View Product', SP_TEXT_DOMAIN ),
			'search_items'       => __( 'Search Products', SP_TEXT_DOMAIN ),
			'not_found'          => __( 'No Products Found', SP_TEXT_DOMAIN ),
			'not_found_in_trash' => __( 'No Products Found in Trash', SP_TEXT_DOMAIN ),
		),
		'show_ui'   => true,
		'public'      => true,
		'supports'    => array('title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes'),
		'rewrite'     => array('slug' => 'product'),
		'menu_icon' => 'dashicons-store',
	) );
	
	// Custom Taxonomy "Type" for Product Post Type
	register_taxonomy( 'cfspas_product_type', 'cfspas_product', array(
		'labels' => array(
			'name'              => _x( 'Types', 'taxonomy general name', SP_TEXT_DOMAIN ),
			'singular_name'     => _x( 'Type', 'taxonomy singular name', SP_TEXT_DOMAIN ),
			'search_items'      => __( 'Search Types', SP_TEXT_DOMAIN ),
			'all_items'         => __( 'All Types', SP_TEXT_DOMAIN ),
			'parent_item'       => __( 'Parent Type', SP_TEXT_DOMAIN ),
			'parent_item_colon' => __( 'Parent Type:', SP_TEXT_DOMAIN ),
			'edit_item'         => __( 'Edit Type', SP_TEXT_DOMAIN ),
			'update_item'       => __( 'Update Type', SP_TEXT_DOMAIN ),
			'add_new_item'      => __( 'Add New Type', SP_TEXT_DOMAIN ),
			'new_item_name'     => __( 'New Type Name', SP_TEXT_DOMAIN ),
			'menu_name'         => __( 'Types', SP_TEXT_DOMAIN ),
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
	) );
	
	// Custom Taxonomy "Brand" for Product Post Type
	register_taxonomy( 'cfspas_product_brand', array('cfspas_product', 'cfspas_feature'), array(
		'labels' => array(
			'name'              => _x( 'Brands', 'taxonomy general name', SP_TEXT_DOMAIN ),
			'singular_name'     => _x( 'Brand', 'taxonomy singular name', SP_TEXT_DOMAIN ),
			'search_items'      => __( 'Search Brands', SP_TEXT_DOMAIN ),
			'all_items'         => __( 'All Brands', SP_TEXT_DOMAIN ),
			'parent_item'       => __( 'Parent Brand', SP_TEXT_DOMAIN ),
			'parent_item_colon' => __( 'Parent Brand:', SP_TEXT_DOMAIN ),
			'edit_item'         => __( 'Edit Brand', SP_TEXT_DOMAIN ),
			'update_item'       => __( 'Update Brand', SP_TEXT_DOMAIN ),
			'add_new_item'      => __( 'Add New Brand', SP_TEXT_DOMAIN ),
			'new_item_name'     => __( 'New Brand Name', SP_TEXT_DOMAIN ),
			'menu_name'         => __( 'Brands', SP_TEXT_DOMAIN ),
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
	) );
	
	// Custom Taxonomy "Collection" for Product Post Type
	/* register_taxonomy( 'cfspas_product_collection', array('cfspas_product', 'cfspas_feature'), array(
		'labels' => array(
			'name'              => _x( 'Collections', 'taxonomy general name', SP_TEXT_DOMAIN ),
			'singular_name'     => _x( 'Collection', 'taxonomy singular name', SP_TEXT_DOMAIN ),
			'search_items'      => __( 'Search Collections', SP_TEXT_DOMAIN ),
			'all_items'         => __( 'All Collections', SP_TEXT_DOMAIN ),
			'parent_item'       => __( 'Parent Collection', SP_TEXT_DOMAIN ),
			'parent_item_colon' => __( 'Parent Collection:', SP_TEXT_DOMAIN ),
			'edit_item'         => __( 'Edit Collection', SP_TEXT_DOMAIN ),
			'update_item'       => __( 'Update Collection', SP_TEXT_DOMAIN ),
			'add_new_item'      => __( 'Add New Collection', SP_TEXT_DOMAIN ),
			'new_item_name'     => __( 'New Collection Name', SP_TEXT_DOMAIN ),
			'menu_name'         => __( 'Collections', SP_TEXT_DOMAIN ),
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
	) ); */
	
	
	// Custom Post Type for Product Feature (shown on single product pages, e.g. "FreshWater® IQ System")
	/* register_post_type( 'cfspas_feature', array(
		'labels' => array(
			'name'               => __( 'Product Features', SP_TEXT_DOMAIN ),
			'singular_name'      => __( 'Product Feature', SP_TEXT_DOMAIN ),
			'all_items'          => __( 'Features', SP_TEXT_DOMAIN ),
			'add_new_item'       => __( 'Add New Feature', SP_TEXT_DOMAIN ),
			'edit_item'          => __( 'Edit Feature', SP_TEXT_DOMAIN ),
			'new_item'           => __( 'New Feature', SP_TEXT_DOMAIN ),
			'view_item'          => __( 'View Feature', SP_TEXT_DOMAIN ),
			'search_items'       => __( 'Search Features', SP_TEXT_DOMAIN ),
			'not_found'          => __( 'No Features Found', SP_TEXT_DOMAIN ),
			'not_found_in_trash' => __( 'No Features Found in Trash', SP_TEXT_DOMAIN ),
		),
		'show_ui'      => true,
		'show_in_menu' => 'edit.php?post_type=cfspas_product',
		'supports'     => array('title', 'editor', 'thumbnail'),
		'taxonomies'   => array('cfspas_product_brand', 'cfspas_product_collection'), // for organizing/filtering only
	) ); */
	
	
	// Custom Post Type for Document
	register_post_type( 'cfspas_document', array(
		'labels' => array(
			'name'               => __( 'Documents', SP_TEXT_DOMAIN ),
			'singular_name'      => __( 'Document', SP_TEXT_DOMAIN ),
			'all_items'          => __( 'All Documents', SP_TEXT_DOMAIN ),
			'add_new_item'       => __( 'Add New Document', SP_TEXT_DOMAIN ),
			'edit_item'          => __( 'Edit Document', SP_TEXT_DOMAIN ),
			'new_item'           => __( 'New Document', SP_TEXT_DOMAIN ),
			'view_item'          => __( 'View Document', SP_TEXT_DOMAIN ),
			'search_items'       => __( 'Search Documents', SP_TEXT_DOMAIN ),
			'not_found'          => __( 'No Documents Found', SP_TEXT_DOMAIN ),
			'not_found_in_trash' => __( 'No Documents Found in Trash', SP_TEXT_DOMAIN ),
		),
		'show_ui'   => true,
		'supports'    => array('title', 'custom-fields'),
		'menu_icon' => 'dashicons-text-page',
	) );
	
	// Custom Taxonomy "Brand" for Document Post Type
	register_taxonomy( 'cfspas_document_brand', 'cfspas_document', array(
		'labels' => array(
			'name'              => _x( 'Brands', 'taxonomy general name', SP_TEXT_DOMAIN ),
			'singular_name'     => _x( 'Brand', 'taxonomy singular name', SP_TEXT_DOMAIN ),
			'search_items'      => __( 'Search Brands', SP_TEXT_DOMAIN ),
			'all_items'         => __( 'All Brands', SP_TEXT_DOMAIN ),
			'parent_item'       => __( 'Parent Brand', SP_TEXT_DOMAIN ),
			'parent_item_colon' => __( 'Parent Brand:', SP_TEXT_DOMAIN ),
			'edit_item'         => __( 'Edit Brand', SP_TEXT_DOMAIN ),
			'update_item'       => __( 'Update Brand', SP_TEXT_DOMAIN ),
			'add_new_item'      => __( 'Add New Brand', SP_TEXT_DOMAIN ),
			'new_item_name'     => __( 'New Brand Name', SP_TEXT_DOMAIN ),
			'menu_name'         => __( 'Brands', SP_TEXT_DOMAIN ),
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
	) );
	
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
	
	wp_enqueue_script( SP_TEXT_DOMAIN.'-script', get_template_directory_uri().'/js/functions.js', array('jquery', 'js-cookie', 'jquery-modal', 'wow'), null, true );
}
add_action('wp_enqueue_scripts', 'sp_enqueue_scripts');