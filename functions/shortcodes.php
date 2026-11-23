<?php

// Add shortcode support to text widgets
add_filter('widget_text', 'do_shortcode');


function sp_shortcode_list_child_pages() {
	global $post;
	
	return wp_list_pages( array('child_of' => $post->ID, 'title_li' => false) );
}
add_shortcode('list-child-pages', 'sp_shortcode_list_child_pages');


function sp_shortcode_testimonials_carousel($atts) {
	ob_start();
	
	$atts = shortcode_atts( array(
		'title'         => null,
		'intro_text'    => null,
		'visible_items' => 3,
		'nav'           => 'false',
	), $atts, 'testimonials_carousel' );
	
	if ( !empty( $atts['intro_text'] ) ) $atts['intro_text'] = apply_filters( 'the_content', $atts['intro_text'] );
	
	get_template_part( 'layout-modules/testimonials-carousel', null, array(
		'title'         => $atts['title'],
		'intro_text'    => $atts['intro_text'],
		'visible_items' => $atts['visible_items'],
		'nav'           => $atts['nav'],
	) );
	
	return ob_get_clean();
}
add_shortcode('testimonials_carousel', 'sp_shortcode_testimonials_carousel');

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
add_shortcode( 'products', 'sp_shortcode_products' );
