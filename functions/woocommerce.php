<?php

// Declare support for core WooCommerce features
add_action( 'after_setup_theme', function() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-lightbox' );
} );


// Change smallscreen breakpoint from 768px to 767px
add_filter( 'woocommerce_style_smallscreen_breakpoint', function() {
	return '767px';
} );


// Remove page title
add_filter( 'woocommerce_show_page_title', '__return_false' );


// Remove breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );


/* - SHOP ARCHIVE - */

// Add product thumbnail container
function sp_woocommerce_template_loop_product_thumbnail_open() {
	wc_get_template( 'custom/loop/product-thumbnail-open.php' );
}
add_action( 'woocommerce_before_shop_loop_item_title', 'sp_woocommerce_template_loop_product_thumbnail_open', 5 );

function sp_woocommerce_template_loop_product_thumbnail_close() {
	wc_get_template( 'custom/loop/product-thumbnail-close.php' );
}
add_action( 'woocommerce_before_shop_loop_item_title', 'sp_woocommerce_template_loop_product_thumbnail_close', 15 );


// Change product thumbnail size to one that doesn't use WooCommerce's cropping
function sp_single_product_archive_thumbnail_size( $size ) {
	return 'medium';
}
add_filter( 'single_product_archive_thumbnail_size', 'sp_single_product_archive_thumbnail_size' );


// Remove cart controls from product archive
//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );


// Remove decimals if even dollar amount
add_action( 'woocommerce_price_trim_zeros', '__return_true' );


// Relocate product meta to immediately after title
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 5 );


// Category before product title
function sp_woocommerce_template_loop_category() {
	wc_get_template( 'custom/loop/category.php' );
}
add_action( 'woocommerce_shop_loop_item_title', 'sp_woocommerce_template_loop_category', 5 );


// Short description after the title.
function sp_woocommerce_template_loop_short_description() {
	wc_get_template( 'custom/loop/short-description.php' );
}
add_action( 'woocommerce_after_shop_loop_item_title', 'sp_woocommerce_template_loop_short_description', 3 );


// Footer container
function sp_woocommerce_template_loop_footer_open() {
	wc_get_template( 'custom/loop/footer-open.php' );
}
add_action( 'woocommerce_after_shop_loop_item', 'sp_woocommerce_template_loop_footer_open', 6 );

function sp_woocommerce_template_loop_footer_close() {
	wc_get_template( 'custom/loop/footer-close.php' );
}
add_action( 'woocommerce_after_shop_loop_item', 'sp_woocommerce_template_loop_footer_close', 20 );


// Relocate price into product footer
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 8 );


// Price suffix
/* function sp_woocommerce_template_loop_price_suffix() {
	wc_get_template( 'custom/loop/price-suffix.php' );
}
add_action( 'woocommerce_after_shop_loop_item', 'sp_woocommerce_template_loop_price_suffix', 9 ); */


// Add-to-cart link customizations
add_filter( 'woocommerce_loop_add_to_cart_link', function( $html, $product ) {
	if ( ! is_a( $product, WC_Product::class ) ) {
		return $html;
	}

	return sprintf(
		'<a href="%s" class="button learn_more sp_button">%s</a>',
		esc_url( $product->get_permalink() ),
		esc_html( apply_filters( 'sp_loop_learn_more_text', __( 'Learn More', SP_TEXT_DOMAIN ), $product ) )
	);
}, 10, 2 );


// Remove sidebar
add_action( 'template_redirect', function() {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	/* if ( is_shop() ) {
		add_action( 'woocommerce_after_main_content', 'woocommerce_get_sidebar', 5 );
	} */
} );


/* - SINGLE PRODUCT - */

// Relocate price to just before the add-to-cart button
/* remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 ); */


// Add CSS class to main product price to differentiate it from variation price (used by scripts during variation changes)
add_filter( 'woocommerce_product_price_class', function( $price ) {
	return $price . ' price-product_price';
} );


// price suffix after the single product price (currently displays currency unit).
/* function sp_woocommerce_template_single_price_suffix() {
	wc_get_template( 'custom/loop/price-suffix.php' );
}
add_action( 'woocommerce_single_product_summary', 'sp_woocommerce_template_single_price_suffix', 15 ); */


// Remove "Clear" link from variable product cart
add_filter( 'woocommerce_reset_variations_link', '__return_false' );


// Remove headings from tab content
add_filter( 'woocommerce_product_description_heading', '__return_false' );
add_filter( 'sp_woocommerce_product_faqs_heading', '__return_false' );


// Modify tabs
add_filter( 'woocommerce_product_tabs', function( $tabs ) {
	$faqs_category = get_field('faqs_category');
	
	// Remove "Additional Information" tab
	unset( $tabs['additional_information'] );
	
	// Add FAQs tab if data exists
	if ( !empty($faqs_category) ) {
		$tabs['faqs'] = array(
			'title'    => __( 'FAQs', SP_TEXT_DOMAIN ),
			'priority' => 20,
			'callback' => 'sp_faqs_tab_content',
		);
	}
	
	return $tabs;
} );


// FAQs tab content
function sp_faqs_tab_content() {
	$faqs_categories_data = get_field( 'faqs_categories', 'option' );
	$faqs_category = get_field( 'faqs_category' );
	
	wc_get_template( 'custom/single-product/tabs/faqs.php');
}


// Remove upsell and related products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


// Add related products with alternate accessories template
function sp_woocommerce_output_related_productsas_accessories() {

	$args = array(
		'posts_per_page' => 4,
		'columns'        => 4,
		'orderby'        => 'rand', // @codingStandardsIgnoreLine.
	);

	sp_woocommerce_related_products_as_accessories( apply_filters( 'woocommerce_output_related_products_args', $args ) );
}
add_action( 'woocommerce_after_single_product_summary', 'sp_woocommerce_output_related_productsas_accessories', 20 );

function sp_woocommerce_related_products_as_accessories( $args = array() ) {
	global $product;

	if ( ! ( $product instanceof WC_Product ) ) {
		return;
	}

	$defaults = array(
		'posts_per_page' => 2,
		'columns'        => 2,
		'orderby'        => 'rand', // @codingStandardsIgnoreLine.
		'order'          => 'desc',
	);

	$args = wp_parse_args( $args, $defaults );

	$related_products    = array();
	$related_product_ids = wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() );
	if ( ! empty( $related_product_ids ) ) {
		// Prime caches to reduce future queries.
		_prime_post_caches( $related_product_ids );

		// Get visible related products then sort them at random, then handle orderby.
		$related_products = array_filter( array_map( 'wc_get_product', $related_product_ids ), 'wc_products_array_filter_visible' );
		$related_products = wc_products_array_orderby( $related_products, $args['orderby'], $args['order'] );
		/** @var WC_Product[] $related_products */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort

		// Prime caches to reduce future queries.
		_prime_post_caches( array_filter( array_map( fn( $product ) => (int) $product->get_image_id(), $related_products ) ) );
	}
	$args['related_products'] = $related_products;

	// Set global loop values.
	wc_set_loop_prop( 'name', 'related' );
	wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );

	wc_get_template( 'custom/single-product/related-accessories.php', $args );
}


// Add Advanced Custom Fields flexible content page sections to single product page
function sp_woocommerce_load_acf_page_sections() {
	sp_load_acf_page_sections( get_field('page_sections') );
}
add_action( 'woocommerce_after_main_content', 'sp_woocommerce_load_acf_page_sections', 20 );


/* - CART PAGE - */

// Add store notice to cart and checkout pages
function sp_woocommerce_template_cart_notice() {
	wc_get_template( 'custom/cart/before-cart-notice.php' );
}
add_action( 'woocommerce_before_cart_table', 'sp_woocommerce_template_cart_notice', 10 );
add_action( 'woocommerce_checkout_before_customer_details', 'sp_woocommerce_template_cart_notice', 10 );