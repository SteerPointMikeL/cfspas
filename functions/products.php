<?php
/**
 * Products: helpers shared by the single product template, product cards/grids,
 * the [products] shortcode and the "Product Grid" ACF page section.
 *
 * Products are a single post type (cfspas_product) distinguished by the
 * cfspas_product_type taxonomy (hot tubs, swim spas, saunas, cold plunges,
 * massage chairs, pre-owned spas) and further organized by the
 * cfspas_product_brand and cfspas_product_collection taxonomies.
 */


/**
 * Default product types. Their slugs drive which specification fields are shown
 * (see sp_get_product_spec_definitions() and the ACF field group location rules).
 */
function sp_get_default_product_types() {
	return array(
		'hot-tubs'       => array( 'name' => __( 'Hot Tubs', SP_TEXT_DOMAIN ),       'singular' => __( 'Hot Tub', SP_TEXT_DOMAIN ),       'spec_set' => 'spa' ),
		'swim-spas'      => array( 'name' => __( 'Swim Spas', SP_TEXT_DOMAIN ),      'singular' => __( 'Swim Spa', SP_TEXT_DOMAIN ),      'spec_set' => 'spa' ),
		'saunas'         => array( 'name' => __( 'Saunas', SP_TEXT_DOMAIN ),         'singular' => __( 'Sauna', SP_TEXT_DOMAIN ),         'spec_set' => 'sauna' ),
		'cold-plunges'   => array( 'name' => __( 'Cold Plunges', SP_TEXT_DOMAIN ),   'singular' => __( 'Cold Plunge', SP_TEXT_DOMAIN ),   'spec_set' => 'cold_plunge' ),
		'massage-chairs' => array( 'name' => __( 'Massage Chairs', SP_TEXT_DOMAIN ), 'singular' => __( 'Massage Chair', SP_TEXT_DOMAIN ), 'spec_set' => 'massage_chair' ),
		'pre-owned-spas' => array( 'name' => __( 'Pre-Owned Spas', SP_TEXT_DOMAIN ), 'singular' => __( 'Pre-Owned Spa', SP_TEXT_DOMAIN ), 'spec_set' => 'spa' ),
	);
}


/**
 * Create the default product type terms the first time the theme runs against a
 * site whose Type taxonomy is still empty. Existing terms are never touched.
 */
function sp_maybe_seed_product_types() {
	if ( get_option( 'sp_product_types_seeded' ) ) return;
	if ( !taxonomy_exists( 'cfspas_product_type' ) ) return;

	$existing = get_terms( array( 'taxonomy' => 'cfspas_product_type', 'hide_empty' => false, 'fields' => 'ids' ) );

	if ( !is_wp_error( $existing ) && empty( $existing ) ) {
		foreach ( sp_get_default_product_types() as $slug => $type ) {
			wp_insert_term( $type['name'], 'cfspas_product_type', array( 'slug' => $slug ) );
		}
	}

	update_option( 'sp_product_types_seeded', 1 );
}
add_action( 'init', 'sp_maybe_seed_product_types', 20 );


/**
 * Return the terms of $taxonomy assigned to a product, most specific (child) terms first.
 */
function sp_get_product_terms( $post_id, $taxonomy ) {
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


/**
 * Product type (top-level term of cfspas_product_type), e.g. "Hot Tubs".
 */
function sp_get_product_type( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$terms = sp_get_product_terms( $post_id, 'cfspas_product_type' );

	if ( empty( $terms ) ) return null;

	$term = $terms[0];

	// walk up to the top-level type so child types (e.g. "Infrared Saunas" under "Saunas") inherit the parent's specs
	while ( $term->parent ) {
		$parent = get_term( $term->parent, 'cfspas_product_type' );
		if ( !$parent || is_wp_error( $parent ) ) break;
		$term = $parent;
	}

	return $term;
}


/**
 * Singular label for a product's type, e.g. "Hot Tub". Uses the type term's
 * "Singular Name" field, then the built-in defaults, then the term name.
 */
function sp_get_product_type_singular_label( $post_id = null ) {
	$type = sp_get_product_type( $post_id );

	if ( !$type ) return __( 'Product', SP_TEXT_DOMAIN );

	if ( function_exists( 'get_field' ) && get_field( 'singular_name', $type ) ) return get_field( 'singular_name', $type );

	$defaults = sp_get_default_product_types();
	if ( isset( $defaults[ $type->slug ] ) ) return $defaults[ $type->slug ]['singular'];

	return $type->name;
}


/**
 * Product title followed by its type (e.g. "Cantabria® Hot Tub"), without
 * doubling the type when the title already contains it (e.g. "Emerge™ Cold Plunge").
 */
function sp_get_product_title_with_type( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$title = get_the_title( $post_id );
	$type_label = sp_get_product_type_singular_label( $post_id );

	if ( stripos( wp_strip_all_tags( $title ), $type_label ) !== false ) return $title;

	return $title . ' ' . $type_label;
}


/**
 * Key of the specification field set used by a product: spa, sauna, cold_plunge or massage_chair.
 */
function sp_get_product_spec_set( $post_id = null ) {
	$type = sp_get_product_type( $post_id );

	if ( !$type ) return '';

	$defaults = sp_get_default_product_types();
	$spec_set = isset( $defaults[ $type->slug ] ) ? $defaults[ $type->slug ]['spec_set'] : '';

	return apply_filters( 'sp_product_spec_set', $spec_set, $type, $post_id );
}


function sp_get_product_brand( $post_id = null ) {
	$terms = sp_get_product_terms( $post_id ?: get_the_ID(), 'cfspas_product_brand' );

	return $terms ? $terms[0] : null;
}


function sp_get_product_collection( $post_id = null ) {
	$terms = sp_get_product_terms( $post_id ?: get_the_ID(), 'cfspas_product_collection' );

	return $terms ? $terms[0] : null;
}


/**
 * Brand logo <img> for a product. Uses the most specific brand term that has a logo,
 * falling back to its parent brands.
 */
function sp_get_product_brand_logo( $post_id = null, $size = 'medium', $attr = array() ) {
	if ( !function_exists( 'get_field' ) ) return '';

	foreach ( sp_get_product_terms( $post_id ?: get_the_ID(), 'cfspas_product_brand' ) as $term ) {
		$ancestors = array_merge( array( $term->term_id ), get_ancestors( $term->term_id, 'cfspas_product_brand', 'taxonomy' ) );

		foreach ( $ancestors as $term_id ) {
			$image_id = get_field( 'brand_image', 'cfspas_product_brand_' . $term_id );

			if ( $image_id ) {
				$brand = get_term( $term_id, 'cfspas_product_brand' );

				return wp_get_attachment_image( $image_id, $size, false, array_merge( array( 'class' => 'brand_logo', 'alt' => wp_strip_all_tags( $brand->name ) ), $attr ) );
			}
		}
	}

	return '';
}


/**
 * Product image <img>.
 *
 * $view: "front" (main/card image) or "top".
 * Uses the uploaded image field first, then the external image URL field
 * (the original site serves most product renders from a CDN), then the featured image.
 */
function sp_get_product_image( $post_id = null, $view = 'front', $size = 'large', $attr = array() ) {
	$post_id = $post_id ?: get_the_ID();
	$alt = wp_strip_all_tags( get_the_title( $post_id ) );
	$attr = array_merge( array( 'class' => 'product_image product_image-' . $view, 'alt' => $alt ), $attr );

	if ( function_exists( 'get_field' ) ) {
		$image_id = get_field( $view . '_view_image', $post_id );
		if ( $image_id ) return wp_get_attachment_image( $image_id, $size, false, $attr );

		$image_url = get_field( $view . '_view_image_url', $post_id );
		if ( $image_url ) {
			$attr_html = '';
			foreach ( array_merge( array( 'loading' => 'lazy', 'decoding' => 'async' ), $attr ) as $name => $value ) {
				$attr_html .= ' ' . $name . '="' . esc_attr( $value ) . '"';
			}

			return '<img src="' . esc_url( $image_url ) . '"' . $attr_html . ' />';
		}
	}

	if ( $view === 'front' && has_post_thumbnail( $post_id ) ) return get_the_post_thumbnail( $post_id, $size, $attr );

	return '';
}


/**
 * Availability note (e.g. "Find this hot tub only at our Jacuzzi® Dealership, ...").
 * Product field overrides the brand term's default. Returns array( 'text' => '', 'link' => '' ).
 */
function sp_get_product_availability( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$availability = array( 'text' => '', 'link' => '' );

	if ( !function_exists( 'get_field' ) ) return $availability;

	$availability['text'] = (string) get_field( 'availability_text', $post_id );
	$availability['link'] = (string) get_field( 'availability_link', $post_id );

	if ( empty( $availability['text'] ) ) {
		foreach ( sp_get_product_terms( $post_id, 'cfspas_product_brand' ) as $term ) {
			$ancestors = array_merge( array( $term->term_id ), get_ancestors( $term->term_id, 'cfspas_product_brand', 'taxonomy' ) );

			foreach ( $ancestors as $term_id ) {
				$text = get_field( 'availability_text', 'cfspas_product_brand_' . $term_id );

				if ( $text ) {
					$availability['text'] = $text;
					$availability['link'] = $availability['link'] ?: (string) get_field( 'availability_link', 'cfspas_product_brand_' . $term_id );

					break 2;
				}
			}
		}
	}

	$availability['text'] = str_replace( '%s', sp_get_product_type_singular_label( $post_id ), $availability['text'] );
	$availability['text'] = str_ireplace( '{type}', strtolower( sp_get_product_type_singular_label( $post_id ) ), $availability['text'] );

	return $availability;
}


/**
 * Specification definitions by spec set.
 *
 * Each row: label + one or more value parts. Each part is a field name and a
 * sprintf() format. Rows whose fields are all empty are skipped.
 */
function sp_get_product_spec_definitions() {
	$definitions = array(
		'spa' => array(
			array( 'label' => __( 'Dimensions', SP_TEXT_DOMAIN ),              'parts' => array( array( 'dimensions_imperial', '%s' ), array( 'dimensions_metric', '%s' ) ) ),
			array( 'label' => __( 'Seating', SP_TEXT_DOMAIN ),                 'parts' => array( array( 'seats', __( 'Seats: %s Adults', SP_TEXT_DOMAIN ) ), array( 'seating_type', '%s' ) ) ),
			array( 'label' => __( 'Jets', SP_TEXT_DOMAIN ),                    'parts' => array( array( 'jets', __( '%s Jets', SP_TEXT_DOMAIN ) ) ) ),
			array( 'label' => __( 'Spa Volume', SP_TEXT_DOMAIN ),              'parts' => array( array( 'volume_gal', __( '%s gal', SP_TEXT_DOMAIN ) ), array( 'volume_l', __( '(%s L)', SP_TEXT_DOMAIN ) ) ) ),
			array( 'label' => __( 'Spa Weight Filled', SP_TEXT_DOMAIN ),       'parts' => array( array( 'weight_filled_lbs', __( '%s lbs.', SP_TEXT_DOMAIN ) ), array( 'weight_filled_kg', __( '(%s kg)', SP_TEXT_DOMAIN ) ) ) ),
			array( 'label' => __( 'Spa Weight Dry', SP_TEXT_DOMAIN ),          'parts' => array( array( 'weight_dry_lbs', __( '%s lbs.', SP_TEXT_DOMAIN ) ), array( 'weight_dry_kg', __( '(%s kg)', SP_TEXT_DOMAIN ) ) ) ),
			array( 'label' => __( 'Water Management System', SP_TEXT_DOMAIN ), 'parts' => array( array( 'water_management', '%s' ) ) ),
			array( 'label' => __( 'Electrical', SP_TEXT_DOMAIN ),              'parts' => array( array( 'electrical', '%s' ) ) ),
		),
		'sauna' => array(
			array( 'label' => __( 'Sauna Type', SP_TEXT_DOMAIN ),  'parts' => array( array( 'sauna_type', '%s' ) ) ),
			array( 'label' => __( 'Seating', SP_TEXT_DOMAIN ),     'parts' => array( array( 'seats', __( 'Seats: %s Adults', SP_TEXT_DOMAIN ) ) ) ),
			array( 'label' => __( 'Width', SP_TEXT_DOMAIN ),       'parts' => array( array( 'width', '%s' ) ) ),
			array( 'label' => __( 'Depth', SP_TEXT_DOMAIN ),       'parts' => array( array( 'depth', '%s' ) ) ),
			array( 'label' => __( 'Height', SP_TEXT_DOMAIN ),      'parts' => array( array( 'height', '%s' ) ) ),
			array( 'label' => __( 'Wood Type', SP_TEXT_DOMAIN ),   'parts' => array( array( 'wood_type', '%s' ) ) ),
			array( 'label' => __( 'Sauna Bench', SP_TEXT_DOMAIN ), 'parts' => array( array( 'bench', '%s' ) ) ),
			array( 'label' => __( 'Heater', SP_TEXT_DOMAIN ),      'parts' => array( array( 'heater', '%s' ) ) ),
			array( 'label' => __( 'Electrical', SP_TEXT_DOMAIN ),  'parts' => array( array( 'electrical', '%s' ) ) ),
		),
		'cold_plunge' => array(
			array( 'label' => __( 'Dimensions', SP_TEXT_DOMAIN ),    'parts' => array( array( 'dimensions_imperial', '%s' ), array( 'dimensions_metric', '%s' ) ) ),
			array( 'label' => __( 'Seating', SP_TEXT_DOMAIN ),       'parts' => array( array( 'seats', __( 'Seats: %s', SP_TEXT_DOMAIN ) ) ) ),
			array( 'label' => __( 'Temperature', SP_TEXT_DOMAIN ),   'parts' => array( array( 'temperature', '%s' ) ) ),
			array( 'label' => __( 'Filter System', SP_TEXT_DOMAIN ), 'parts' => array( array( 'filter_system', '%s' ) ) ),
			array( 'label' => __( 'Cabinet', SP_TEXT_DOMAIN ),       'parts' => array( array( 'cabinet', '%s' ) ) ),
			array( 'label' => __( 'Volume', SP_TEXT_DOMAIN ),        'parts' => array( array( 'volume_gal', __( '%s gal', SP_TEXT_DOMAIN ) ), array( 'volume_l', __( '(%s L)', SP_TEXT_DOMAIN ) ) ) ),
			array( 'label' => __( 'Weight', SP_TEXT_DOMAIN ),        'parts' => array( array( 'weight_filled_lbs', __( '%s lbs. Filled', SP_TEXT_DOMAIN ) ), array( 'weight_dry_lbs', __( '%s lbs. Dry', SP_TEXT_DOMAIN ) ) ) ),
			array( 'label' => __( 'Electrical', SP_TEXT_DOMAIN ),    'parts' => array( array( 'electrical', '%s' ) ) ),
		),
		'massage_chair' => array(
			array( 'label' => __( 'Upright Dimensions', SP_TEXT_DOMAIN ),  'parts' => array( array( 'upright_dimensions', '%s' ) ) ),
			array( 'label' => __( 'Reclined Dimensions', SP_TEXT_DOMAIN ), 'parts' => array( array( 'reclined_dimensions', '%s' ) ) ),
			array( 'label' => __( 'Chair Weight', SP_TEXT_DOMAIN ),        'parts' => array( array( 'chair_weight', '%s' ) ) ),
			array( 'label' => __( 'Color', SP_TEXT_DOMAIN ),               'parts' => array( array( 'color', '%s' ) ) ),
			array( 'label' => __( 'Electrical', SP_TEXT_DOMAIN ),          'parts' => array( array( 'electrical', '%s' ) ) ),
		),
	);

	return apply_filters( 'sp_product_spec_definitions', $definitions );
}


/**
 * Format a spec value: numbers get thousands separators, everything else is escaped as-is.
 */
function sp_format_product_spec_value( $value ) {
	if ( is_array( $value ) ) $value = implode( ', ', array_filter( $value ) );

	$value = trim( (string) $value );

	if ( is_numeric( $value ) ) {
		$decimals = strpos( $value, '.' ) !== false ? strlen( substr( strrchr( $value, '.' ), 1 ) ) : 0;

		return number_format_i18n( (float) $value, $decimals );
	}

	return wp_kses_post( $value );
}


/**
 * Rendered specification rows for a product:
 * array( array( 'label' => 'Jets', 'values' => array( '74 Jets' ) ), ... )
 */
function sp_get_product_specs( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$definitions = sp_get_product_spec_definitions();
	$spec_set = sp_get_product_spec_set( $post_id );
	$specs = array();

	if ( !function_exists( 'get_field' ) || empty( $definitions[ $spec_set ] ) ) return $specs;

	foreach ( $definitions[ $spec_set ] as $row ) {
		$values = array();

		foreach ( $row['parts'] as $part ) {
			$value = get_field( $part[0], $post_id );

			if ( $value === null || $value === '' || $value === false || $value === array() ) continue;

			$values[] = sprintf( $part[1], sp_format_product_spec_value( $value ) );
		}

		if ( $values ) $specs[] = array( 'label' => $row['label'], 'values' => $values );
	}

	// free-form extra rows entered on the product
	$additional = get_field( 'additional_specifications', $post_id );
	if ( !empty( $additional ) ) {
		foreach ( $additional as $row ) {
			if ( empty( $row['label'] ) || empty( $row['value'] ) ) continue;

			$specs[] = array( 'label' => $row['label'], 'values' => array_filter( array_map( 'trim', explode( "\n", wp_kses_post( $row['value'] ) ) ) ) );
		}
	}

	return apply_filters( 'sp_product_specs', $specs, $post_id, $spec_set );
}


/**
 * Short list of details shown on product cards (e.g. collection, "8 Adults", "74 Jets").
 */
function sp_get_product_card_details( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$details = array();

	$collection = sp_get_product_collection( $post_id );
	$brand = sp_get_product_brand( $post_id );

	if ( $collection ) {
		$details['group'] = $collection->name;
	} else if ( $brand ) {
		$details['group'] = $brand->name;
	}

	if ( function_exists( 'get_field' ) ) {
		$field = function( $name, $format = '%s' ) use ( $post_id ) {
			$value = get_field( $name, $post_id );

			return ( $value === null || $value === '' || $value === false ) ? '' : sprintf( $format, sp_format_product_spec_value( $value ) );
		};

		switch ( sp_get_product_spec_set( $post_id ) ) {
			case 'spa' :
				$details['seats'] = $field( 'seats', __( '%s Adults', SP_TEXT_DOMAIN ) );
				$details['jets'] = $field( 'jets', __( '%s Jets', SP_TEXT_DOMAIN ) );
				$details['seating_type'] = $field( 'seating_type' );
				$details['sale_price'] = $field( 'sale_price' );
				break;
			case 'sauna' :
				$details['seats'] = $field( 'seats', __( '%s Adults', SP_TEXT_DOMAIN ) );
				$details['sauna_type'] = $field( 'sauna_type' );
				break;
			case 'cold_plunge' :
				$details['temperature'] = $field( 'temperature' );
				break;
			case 'massage_chair' :
				$details['upright_dimensions'] = $field( 'upright_dimensions', __( 'Upright: %s', SP_TEXT_DOMAIN ) );
				$details['chair_weight'] = $field( 'chair_weight' );
				break;
		}
	}

	return apply_filters( 'sp_product_card_details', array_filter( $details ), $post_id );
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


/**
 * Render a grid of feature cards (cfspas_feature posts). Returns HTML.
 */
function sp_render_feature_grid( $features, $columns = 3 ) {
	if ( empty( $features ) ) return '';

	ob_start();
	get_template_part( 'template-parts/feature-grid', null, array( 'features' => $features, 'columns' => $columns ) );

	return ob_get_clean();
}
