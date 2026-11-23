<?php

// Add shortcode support to text widgets
add_filter('widget_text', 'do_shortcode');


/**
 * Product grid.
 *
 * Examples:
 *   [products type="hot-tubs"]
 *   [products type="hot-tubs" brand="jacuzzi-hot-tubs" columns="4" limit="4"]
 *   [products brand="caldera-spas" filter_by="collection"]
 *   [products collection="utopia-series" exclude_current="true"]
 *   [products ids="12,34,56"]
 *
 * See sp_get_product_grid_defaults() in functions/products.php for every attribute.
 */
function sp_shortcode_products( $atts ) {
	$atts = shortcode_atts( sp_get_product_grid_defaults(), $atts, 'products' );
	
	return sp_render_product_grid( $atts );
}
add_shortcode( 'cfspas_products', 'sp_shortcode_products' );