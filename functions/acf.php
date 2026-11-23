<?php

function sp_load_acf_page_sections($modules) {
	if ( empty($modules) ) return false;
	
	$layouts = array(
		'content_editor' => array(
			'file' => 'content',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'content',
			),
		),
		'content_with_image' => array(	
			'file' => 'content-with-image',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'column_space_distribution',
				'pre_title',
				'title',
				'image_position',
				'image',
				'image_caption',
				'link',
				'content',
				'buttons',
			),
		),
		'content_with_image_full_width' => array( // todo: rename to "content_with_image_style_b" and migrate content to new name
			'file' => 'content-with-image-style-b',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'column_space_distribution',
				'pre_title',
				'title',
				'image_position',
				'image',
				'content',
				'buttons',
			),
		),
		'content_with_image_style_c' => array(	
			'file' => 'content-with-image-style-c',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'column_space_distribution',
				'pre_title',
				'title',
				'images_position',
				'images',
				'content',
				'buttons',
			),
		),
		'content_with_image_style_d' => array(	
			'file' => 'content-with-image-style-d',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'column_space_distribution',
				'pre_title',
				'title',
				'images_position',
				'images',
				'brand_logo',
				'content',
				'buttons',
			),
		),
		'content_with_image_grid' => array(	
			'file' => 'content-with-image-grid',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'column_space_distribution',
				'pre_title',
				'title',
				'content',
				'buttons',
				'grid_items',
			),
		),
		'content_with_image_repeater' => array(	
			'file' => 'content-with-image-repeater',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'column_space_distribution',
				'pre_title',
				'title',
				'intro_text',
				'button',
				'content_with_image_pairs',
			),
		),
		'content_with_video' => array(	
			'file' => 'content-with-video',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'appearance_modifiers_more',
				'column_space_distribution',
				'pre_title',
				'title',
				'media_position',
				'video',
				'content',
				'show_play_video_button',
			),
		),
		'multi_column' => array(
			'file' => 'multi-column',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'appearance_modifiers_more',
				'image_lightbox_support',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'columns',
			),
		),
		'multi_column_style_b' => array(
			'file' => 'multi-column-style-b',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'button',
				'intro_text',
				'columns_per_row',
				'columns',
			),
		),
		'multi_column_style_c' => array(
			'file' => 'multi-column-style-c',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'button',
				'intro_text',
				'columns_per_row',
				'columns',
			),
		),
		'multi_column_style_d' => array(
			'file' => 'multi-column-style-d',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'button',
				'intro_text',
				'columns_per_row',
				'columns',
			),
		),
		'multi_column_style_e' => array(
			'file' => 'multi-column-style-e',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'appearance_modifiers_more',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'columns',
				'buttons',
			),
		),
		'multi_column_style_f' => array(
			'file' => 'multi-column-style-f',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'appearance_modifiers_more',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'columns',
			),
		),
		'image_gallery' => array(
			'file' => 'image-gallery',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'columns_per_row',
				'pre_title',
				'title',
				'intro_text',
				'images',
				'buttons',
			),
		),
		'intro_banner' => array(
			'file' => 'intro-banner',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'content',
			),
		),
		'welcome' => array(
			'file' => 'welcome',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'columns',
			),
		),
		'brands' => array(
			'file' => 'brands',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'columns',
			),
		),
		'brands_style_b' => array(
			'file' => 'brands-style-b',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'columns',
			),
		),
		'dealerships' => array( // to-do: rename to "locations" and migrate content to new name
			'file' => 'locations',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'image_lightbox_support',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'columns',
			),
		),
		'locations_style_b' => array(
			'file' => 'locations-style-b',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'columns',
				'social_media_icons',
			),
		),
		'interstitial_section' => array(	
			'file' => 'interstitial-section',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'column_space_distribution',
				'pre_title',
				'title',
				'image_position',
				'image',
				'content',
			),
		),
		'the_benefits' => array(
			'file' => 'the-benefits',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'button',
				'columns_per_row',
				'columns',
			),
		),
		'the_benefits_style_b' => array(
			'file' => 'the-benefits-style-b',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'columns',
			),
		),
		
		'video_grid' => array(
			'file' => 'video-grid',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'videos',
				'buttons',
			),
		),
		'faqs' => array(
			'file' => 'faqs',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'faqs',
			),
		),
		'documents' => array(
			'file' => 'documents',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'columns_per_row',
				'pre_title',
				'title',
				'intro_text',
				'buttons',
			),
		),
		'contact_information' => array(
			'file' => 'contact-information',
			'fields' => array(
				'appearance_modifiers',
				'appearance_modifiers_more',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'columns_per_row',
				'columns',
				'social_media_icons',
			),
		),
		'contact_form' => array(
			'file' => 'contact-form',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'gravityforms_form_id',
				'show_title',
				'show_description',
			),
		),
		'contact_form_style_b' => array(
			'file' => 'contact-form-style-b',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'intro_text',
				'gravityforms_form_id',
				'show_title',
				'show_description',
			),
		),
		'blog_posts' => array(	
			'file' => 'blog-posts',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'pre_title',
				'title',
				'content',
				'buttons',
			),
		),
		'product_grid' => array(
			'file' => 'product-grid',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'columns_per_row',
				'pre_title',
				'title',
				'intro_text',
				'product_types',
				'product_brands',
				'product_collections',
				'specific_products',
				'number_of_products',
				'order_by',
				'filter_by',
				'card_button_text',
				'buttons',
			),
		),
		'complex_resources' => array(	
			'file' => 'complex-resources',
			'fields' => array(
				'appearance_modifiers',
				'additional_css_classes',
				'intro_title',
				'intro_text',
				'button',
				'video',
				'images',
				'title',
				'pre_title',
				'content',
				'buttons',
			),
		),
	);
	
	foreach ( $modules as $module ) {
		$args = array();
		
		if ( !array_key_exists( $module['acf_fc_layout'], $layouts ) ) continue;
		
		foreach ( $module as $field_name => $field_value ) {
			if ( !in_array($field_name, $layouts[$module['acf_fc_layout']]['fields'] ) ) continue;
			
			$args[$field_name] = $module[$field_name];
		}
		
		sp_render_acf_page_section( $layouts[$module['acf_fc_layout']]['file'], $args );
	}
}


function sp_render_acf_page_section( $file, $args = array() ) {
	// prepare variables for use in template
	extract($args);
	
	// find and load template
	$template_location = 'template-parts/acf-page-sections/' . $file . '.php';
	if ( locate_template($template_location) ) {
		require( get_template_directory() . '/' . $template_location );
	} else if ( WP_DEBUG ) {
		error_log('Layout module not found.');
	}
}


// Enable Abilities API
add_filter( 'acf/settings/enable_acf_ai', '__return_true' );


// Process shortcodes inside ACF fields
function sp_acf_format_value( $value ) {
	return do_shortcode( $value );
}
add_filter( 'acf/format_value/type=text', 'sp_acf_format_value', 9999 );
add_filter( 'acf/format_value/type=textarea', 'sp_acf_format_value', 9999 );


// Populate ACF FAQs Category dropdown fields with categories from FAQs Options page
add_filter('acf/load_field/name=faqs_category', function( $field ) {
	$field['choices'] = array();
	
	$faqs_categories_data = get_field('faqs_categories', 'option');
	
	if ( empty($faqs_categories_data) ) return $field;
	
	foreach ( $faqs_categories_data as $faqs_category_data_field ) {
		if ( empty($faqs_category_data_field['name'] ) ) continue;
		
		$field['choices'][$faqs_category_data_field['name']] = $faqs_category_data_field['name'];
	}
	
	return $field;
} );


// Populate ACF contact form dropdown fields with Gravity Forms forms
function sp_acf_load_gravityforms_choices($field) {
	// clear them out
	$field['choices'] = array();
	
	// bail
	if ( !class_exists('GFAPI') ) { // (is_plugin_active() isn't loaded on the front end, where get_field() also runs this filter)
		return $field;
	}
	
	$forms = GFAPI::get_forms();
	
	// probably redundant
	if ( empty($forms) ) {
		return $field;
	}
	
	foreach ( $forms as $form ) {
		$choices[$form['id']] = $form['title'];
	}
	
	ksort($choices);
	
	foreach ( $choices as $key => $choice ) {
		$field['choices'][$key] = $choice;
	}
	
	return $field;
}
add_filter('acf/load_field/name=gravityforms_form_id', 'sp_acf_load_gravityforms_choices');
add_filter('acf/load_field/name=product_contact_form', 'sp_acf_load_gravityforms_choices');


// Populate ACF sidebar fields with available sidebars
add_filter('acf/load_field/name=sidebar', function($field) {
	global $wp_registered_sidebars;
	
	$field['choices'] = array();
	
	foreach ( $wp_registered_sidebars as $sidebar ) {
		$field['choices'][$sidebar['id']] = $sidebar['name'];
	}
	
	return $field;
} );