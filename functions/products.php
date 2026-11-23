<?php
/**
 * Products: helpers used by the the [cfspas_products] shortcode
 *
 * Products are a single post type (cfspas_product) distinguished by the
 * cfspas_product_type taxonomy (hot tubs, swim spas, saunas, cold plunges,
 * massage chairs, pre-owned spas) and further organized by the
 * cfspas_product_brand and cfspas_product_collection taxonomies.
 */

/**
 * Return the terms of $taxonomy assigned to a post, most specific (child) terms first.
 */
function sp_get_the_terms_children_first( $post_id, $taxonomy ) {
	$terms = get_the_terms( $post_id, $taxonomy );

	if ( empty( $terms ) || is_wp_error( $terms ) ) return array();

	$parent_ids = wp_list_pluck( $terms, 'parent' );

	usort( $terms, function( $a, $b ) use ( $parent_ids ) {
		// terms that are parents of other assigned terms go last
		$a_is_parent = in_array( $a->term_id, $parent_ids );
		$b_is_parent = in_array( $b->term_id, $parent_ids );

		if ( $a_is_parent !== $b_is_parent ) return $a_is_parent ? 1 : -1;

		return 0; // usort is stable (PHP 8+), so original order is kept otherwise
	} );

	return $terms;
}


function sp_get_product_brand_image_id( $post_id = null ) {
	foreach ( sp_get_the_terms_children_first( $post_id ?: get_the_ID(), 'cfspas_product_brand' ) as $term ) {
		//$ancestors = array_merge( array( $term->term_id ), get_ancestors( $term->term_id, 'cfspas_product_brand', 'taxonomy' ) ); // probably don't need this since we're only interested in explicitly assigned terms and not their potentially unassigned ancestors

		//foreach ( $ancestors as $term_id ) {
			//$image_id = get_field( 'brand_image', 'cfspas_product_brand_' . $term_id );
			$image_id = get_field( 'brand_image', 'cfspas_product_brand_' . $term->term_id );

			if ( $image_id ) {
				return $image_id;
			}
		//}
	}

	return '';
}


function sp_guess_icon_from_name( $name ) {
	$icons = array(
		'Jets'               => 'compact-disc',
		'Sauna Type'         => 'warehouse',
		'Seating'            => 'chair',
		'Upright Dimensions' => 'chair',
		'Seating Capacity'   => 'users',
		'Weight'             => 'weight-hanging',
	);
	
	if ( array_key_exists( $name, $icons ) ) return $icons[$name];
	
	return false;
}


/**
 * Split a comma separated list (or array) of slugs/IDs into a clean array.
 */
function sp_parse_list( $value ) {
	if ( is_array( $value ) ) return array_values( array_filter( array_map( 'trim', $value ), 'strlen' ) );

	return array_values( array_filter( array_map( 'trim', explode( ',', (string) $value ) ), 'strlen' ) );
}


/**
 * Default arguments understood by sp_render_product_grid() / [products].
 */
function sp_get_product_grid_defaults() {
	return array(
		// query
		'type'            => '',      // product type slug(s) or ID(s), comma separated
		'brand'           => '',      // brand slug(s) or ID(s), comma separated
		'collection'      => '',      // collection slug(s) or ID(s), comma separated
		'ids'             => '',      // specific product IDs, comma separated (displayed in this order unless orderby is set)
		'exclude'         => '',      // product IDs to leave out, comma separated
		'exclude_current' => false,   // leave out the product currently being viewed
		'limit'           => -1,      // number of products (-1 = all)
		'orderby'         => '',      // menu_order (default), title, date, rand, post__in
		'order'           => '',      // ASC or DESC
		'relation'        => 'AND',   // how type/brand/collection filters combine

		// display
		'columns'         => 3,       // 1-6
		'filter_by'       => '',      // show filter tabs: collection, brand or type
		'button_text'     => '',      // card button text (default "View Details")
		'show_details'    => true,    // show collection/seats/jets line on cards
		'show_logo'       => true,    // show brand logo on cards
		'class'           => '',      // extra CSS class(es) on the grid wrapper
		'empty_message'   => '',      // text shown when no products match
	);
}


/**
 * Turn product grid arguments into WP_Query arguments.
 */
function sp_get_product_query_args( $args ) {
	$args = wp_parse_args( $args, sp_get_product_grid_defaults() );

	$query_args = array(
		'post_type'           => 'cfspas_product',
		'post_status'         => 'publish',
		'posts_per_page'      => intval( $args['limit'] ) ?: -1,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	$tax_query = array();
	foreach ( array( 'type' => 'cfspas_product_type', 'brand' => 'cfspas_product_brand', 'collection' => 'cfspas_product_collection' ) as $arg => $taxonomy ) {
		$terms = sp_parse_list( $args[ $arg ] );

		if ( empty( $terms ) ) continue;

		$all_ids = count( array_filter( $terms, 'is_numeric' ) ) === count( $terms );

		$tax_query[] = array(
			'taxonomy'         => $taxonomy,
			'field'            => $all_ids ? 'term_id' : 'slug',
			'terms'            => $all_ids ? array_map( 'intval', $terms ) : $terms,
			'include_children' => true,
		);
	}

	if ( count( $tax_query ) > 1 ) $tax_query['relation'] = strtoupper( $args['relation'] ) === 'OR' ? 'OR' : 'AND';
	if ( $tax_query ) $query_args['tax_query'] = $tax_query;

	$ids = array_map( 'intval', sp_parse_list( $args['ids'] ) );
	if ( $ids ) $query_args['post__in'] = $ids;

	$exclude = array_map( 'intval', sp_parse_list( $args['exclude'] ) );
	if ( filter_var( $args['exclude_current'], FILTER_VALIDATE_BOOLEAN ) && is_singular( 'cfspas_product' ) ) $exclude[] = get_queried_object_id();
	if ( $exclude ) $query_args['post__not_in'] = $exclude;

	$orderby = $args['orderby'] ?: ( $ids ? 'post__in' : 'menu_order' );
	$allowed_orderby = array( 'menu_order', 'title', 'date', 'modified', 'rand', 'post__in' );
	$orderby = in_array( $orderby, $allowed_orderby, true ) ? $orderby : 'menu_order';

	if ( $orderby === 'menu_order' ) {
		$query_args['orderby'] = array( 'menu_order' => strtoupper( $args['order'] ) === 'DESC' ? 'DESC' : 'ASC', 'title' => 'ASC' );
	} else {
		$query_args['orderby'] = $orderby;
		$query_args['order'] = strtoupper( $args['order'] ) === 'DESC' ? 'DESC' : ( $args['order'] ? 'ASC' : ( $orderby === 'date' ? 'DESC' : 'ASC' ) );
	}

	return apply_filters( 'sp_product_query_args', $query_args, $args );
}


/**
 * Render a grid of product cards. Returns HTML.
 */
function sp_render_product_grid( $args = array() ) {
	$args = wp_parse_args( $args, sp_get_product_grid_defaults() );

	$products = new WP_Query( sp_get_product_query_args( $args ) );

	ob_start();
	get_template_part( 'template-parts/product-grid', null, array( 'args' => $args, 'products' => $products ) );
	wp_reset_postdata();

	return ob_get_clean();
}
